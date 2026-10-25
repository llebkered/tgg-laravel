<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Mail\OrderPaidMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderPaymentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        // Opening an unconfirmed order asks Pin; these tests don't need its answer
        Http::fake(['*/1/charges/search*' => Http::response(['response' => []])]);
    }

    private function signInAsAdmin(): void
    {
        $this->actingAs(User::factory()->admin()->create());
    }

    private function order(array $attributes = []): Order
    {
        return Order::create(array_merge([
            'order_status_id' => OrderStatus::InCart->value,
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'total' => 67.00,
        ], $attributes));
    }

    private function unconfirmedOrder(): Order
    {
        return $this->order(['payment_started_at' => now()->subMinutes(10)]);
    }

    public function test_order_screen_shows_an_unconfirmed_payment()
    {
        $this->signInAsAdmin();
        $order = $this->unconfirmedOrder();

        $this->get(route('backend.orders.edit', $order->id))
            ->assertOk()
            ->assertSee('Card payment not confirmed')
            ->assertSee('Mark as paid')
            ->assertSee('Release the order');
    }

    public function test_order_screen_hides_the_panel_while_a_payment_is_running_or_when_paid()
    {
        $this->signInAsAdmin();
        $running = $this->order(['payment_started_at' => now()]);
        $paid = $this->order(['order_status_id' => OrderStatus::Paid->value, 'payment_started_at' => now()->subHour()]);
        $untouched = $this->order();

        foreach ([$running, $paid, $untouched] as $order) {
            $this->get(route('backend.orders.edit', $order->id))
                ->assertOk()
                ->assertDontSee('Card payment not confirmed');
        }
    }

    public function test_order_screen_hides_the_panel_once_the_order_has_moved_on_from_paid()
    {
        $this->signInAsAdmin();

        foreach ([OrderStatus::Shipped, OrderStatus::Cancelled, OrderStatus::Refunded] as $status) {
            $order = $this->order(['order_status_id' => $status->value, 'payment_started_at' => now()->subHour()]);

            $this->get(route('backend.orders.edit', $order->id))
                ->assertOk()
                ->assertDontSee('Card payment not confirmed');
        }

        $this->get(route('backend.orders.index'))->assertOk()->assertDontSee('Payment unconfirmed');
    }

    public function test_order_list_flags_unconfirmed_payments()
    {
        $this->signInAsAdmin();
        $this->unconfirmedOrder();

        $this->get(route('backend.orders.index'))->assertOk()->assertSee('Payment unconfirmed');
    }

    public function test_mark_paid_records_the_charge_and_emails_the_receipt()
    {
        $this->signInAsAdmin();
        $order = $this->unconfirmedOrder();

        $this->post(route('backend.orders.payment.paid', $order->id), [
            'charge_token' => 'ch_abc123',
            'email_receipt' => '1',
        ])->assertSessionHas('success_message');

        $order->refresh();
        $this->assertTrue($order->isPaid());
        $this->assertSame('ch_abc123', $order->charge_token);
        Mail::assertSent(OrderPaidMail::class, fn ($mail) => $mail->order->is($order) && $mail->hasTo('john@test.com'));
    }

    public function test_mark_paid_can_skip_the_receipt()
    {
        $this->signInAsAdmin();
        $order = $this->unconfirmedOrder();

        $this->post(route('backend.orders.payment.paid', $order->id));

        $this->assertTrue($order->fresh()->isPaid());
        Mail::assertNothingSent();
    }

    public function test_release_lets_the_order_be_paid_again()
    {
        $this->signInAsAdmin();
        $order = $this->unconfirmedOrder();

        $this->post(route('backend.orders.payment.release', $order->id))->assertSessionHas('success_message');

        $order->refresh();
        $this->assertNull($order->payment_started_at);
        $this->assertFalse($order->isPaid());
    }

    public function test_actions_refuse_orders_without_an_unconfirmed_payment()
    {
        $this->signInAsAdmin();
        $running = $this->order(['payment_started_at' => $started = now()->subSeconds(30)]);
        $paid = $this->order(['order_status_id' => OrderStatus::Paid->value, 'payment_started_at' => now()->subHour(), 'charge_token' => 'ch_real']);
        $untouched = $this->order();

        foreach ([$running, $paid, $untouched] as $order) {
            $this->post(route('backend.orders.payment.paid', $order->id), ['charge_token' => 'ch_wrong'])
                ->assertSessionHas('danger_message');
            $this->post(route('backend.orders.payment.release', $order->id))
                ->assertSessionHas('danger_message');
        }

        $this->assertFalse($running->fresh()->isPaid());
        $this->assertNotNull($running->fresh()->payment_started_at);
        $this->assertSame('ch_real', $paid->fresh()->charge_token);
        $this->assertNotNull($paid->fresh()->payment_started_at);
        $this->assertFalse($untouched->fresh()->isPaid());
        Mail::assertNothingSent();
    }

    public function test_actions_need_an_admin()
    {
        $order = $this->unconfirmedOrder();

        $this->post(route('backend.orders.payment.paid', $order->id))->assertRedirect('/login');
        $this->post(route('backend.orders.payment.release', $order->id))->assertRedirect('/login');

        $this->assertFalse($order->fresh()->isPaid());
        $this->assertNotNull($order->fresh()->payment_started_at);
    }
}
