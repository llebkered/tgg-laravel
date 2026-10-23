<?php

namespace Tests\Feature\Listeners;

use App\Events\OrderInvoiced;
use App\Events\OrderPaid;
use App\Listeners\SendOrderInvoiceEmail;
use App\Listeners\SendOrderPaidEmail;
use App\Mail\OrderEmailFailedMail;
use App\Mail\OrderPaidMail;
use App\Models\Order;
use Illuminate\Events\CallQueuedListener;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Mockery;
use RuntimeException;
use Tests\TestCase;

class OrderEmailListenersTest extends TestCase
{
    use RefreshDatabase;

    private function order(): Order
    {
        return Order::create([
            'order_status_id' => 3,
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'total' => 25.00,
        ]);
    }

    public function test_order_emails_are_queued()
    {
        Queue::fake();
        $order = $this->order();

        OrderPaid::dispatch($order);
        OrderInvoiced::dispatch($order);

        Queue::assertPushed(CallQueuedListener::class, fn ($job) => $job->class === SendOrderPaidEmail::class);
        Queue::assertPushed(CallQueuedListener::class, fn ($job) => $job->class === SendOrderInvoiceEmail::class);
    }

    public function test_failed_send_is_retried_before_alerting_sales()
    {
        $listener = new SendOrderPaidEmail;

        $this->assertSame(3, $listener->tries);
        $this->assertSame(60, $listener->backoff);
    }

    public function test_failed_send_throws_so_the_queue_can_retry()
    {
        Mail::shouldReceive('to')->andThrow(new RuntimeException('550 mailbox unavailable'));

        $this->expectExceptionMessage('550 mailbox unavailable');

        (new SendOrderPaidEmail)->handle(new OrderPaid($this->order()));
    }

    public function test_receipt_that_keeps_failing_alerts_sales()
    {
        Mail::fake();
        $order = $this->order();

        (new SendOrderPaidEmail)->failed(new OrderPaid($order), new RuntimeException('550 mailbox unavailable'));

        Mail::assertSent(OrderEmailFailedMail::class, function (OrderEmailFailedMail $mail) use ($order) {
            return $mail->hasTo('sales@toadgully.com.au')
                && $mail->order->is($order)
                && $mail->email === 'receipt'
                && $mail->error === '550 mailbox unavailable';
        });
    }

    public function test_invoice_that_keeps_failing_alerts_sales()
    {
        Mail::fake();
        $order = $this->order();

        (new SendOrderInvoiceEmail)->failed(new OrderInvoiced($order), new RuntimeException('550 mailbox unavailable'));

        Mail::assertSent(OrderEmailFailedMail::class, fn ($mail) => $mail->order->is($order) && $mail->email === 'invoice');
    }

    public function test_failed_alert_is_reported_not_thrown()
    {
        Exceptions::fake();
        Mail::shouldReceive('to')->andThrow(new RuntimeException('mail server down'));

        (new SendOrderPaidEmail)->failed(new OrderPaid($this->order()), new RuntimeException('550 mailbox unavailable'));

        Exceptions::assertReported(fn (RuntimeException $e) => $e->getMessage() === 'mail server down');
    }

    public function test_with_the_sync_queue_a_failed_receipt_alerts_sales_straight_away()
    {
        // phpunit.xml uses the sync queue, as the live site does until a
        // worker runs
        $order = $this->order();

        Mail::shouldReceive('to')
            ->once()
            ->with(Mockery::type(Order::class))
            ->andThrow(new RuntimeException('550 mailbox unavailable'));

        $sales = Mockery::mock();
        $sales->shouldReceive('send')->once()->with(Mockery::on(
            fn ($mail) => $mail instanceof OrderEmailFailedMail && $mail->order->is($order)
        ));
        Mail::shouldReceive('to')->once()->with('sales@toadgully.com.au')->andReturn($sales);

        // The sync queue rethrows after calling failed(); the checkout
        // controllers catch it with rescue()
        rescue(fn () => OrderPaid::dispatch($order), report: false);
    }

    public function test_successful_email_sends_no_alert()
    {
        Mail::fake();

        (new SendOrderPaidEmail)->handle(new OrderPaid($this->order()));

        Mail::assertSent(OrderPaidMail::class);
        Mail::assertNotSent(OrderEmailFailedMail::class);
    }
}
