<?php

namespace Tests\Feature\Listeners;

use App\Events\OrderInvoiced;
use App\Events\OrderPaid;
use App\Listeners\SendOrderInvoiceEmail;
use App\Listeners\SendOrderPaidEmail;
use App\Mail\OrderEmailFailedMail;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Exceptions;
use Illuminate\Support\Facades\Mail;
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

    /**
     * Make the customer's email fail, and capture what is sent to sales.
     */
    private function failCustomerEmail(?callable $salesExpectation): void
    {
        Mail::shouldReceive('to')
            ->once()
            ->with(Mockery::type(Order::class))
            ->andThrow(new RuntimeException('550 mailbox unavailable'));

        $sales = Mockery::mock();
        $salesExpectation
            ? $sales->shouldReceive('send')->once()->with(Mockery::on($salesExpectation))
            : $sales->shouldReceive('send')->once()->andThrow(new RuntimeException('mail server down'));

        Mail::shouldReceive('to')->once()->with('sales@toadgully.com.au')->andReturn($sales);
    }

    public function test_failed_receipt_alerts_sales()
    {
        Exceptions::fake();
        $order = $this->order();

        $this->failCustomerEmail(fn ($mail) => $mail instanceof OrderEmailFailedMail
            && $mail->order->is($order)
            && $mail->email === 'receipt'
            && $mail->error === '550 mailbox unavailable');

        (new SendOrderPaidEmail)->handle(new OrderPaid($order));

        Exceptions::assertReported(fn (RuntimeException $e) => $e->getMessage() === '550 mailbox unavailable');
    }

    public function test_failed_invoice_alerts_sales()
    {
        Exceptions::fake();
        $order = $this->order();

        $this->failCustomerEmail(fn ($mail) => $mail instanceof OrderEmailFailedMail
            && $mail->order->is($order)
            && $mail->email === 'invoice');

        (new SendOrderInvoiceEmail)->handle(new OrderInvoiced($order));
    }

    public function test_failed_alert_is_reported_not_thrown()
    {
        Exceptions::fake();

        $this->failCustomerEmail(null);

        (new SendOrderPaidEmail)->handle(new OrderPaid($this->order()));

        Exceptions::assertReported(fn (RuntimeException $e) => $e->getMessage() === '550 mailbox unavailable');
        Exceptions::assertReported(fn (RuntimeException $e) => $e->getMessage() === 'mail server down');
    }

    public function test_successful_email_sends_no_alert()
    {
        Mail::fake();

        (new SendOrderPaidEmail)->handle(new OrderPaid($this->order()));

        Mail::assertNotSent(OrderEmailFailedMail::class);
    }
}
