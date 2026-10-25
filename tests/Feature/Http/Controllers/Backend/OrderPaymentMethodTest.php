<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Mail\OrderPaidMail;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderPaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
    }

    private function signInAsAdmin(): void
    {
        $this->actingAs(User::factory()->admin()->create());
    }

    private function order(array $attributes = []): Order
    {
        return Order::create(array_merge([
            'order_status_id' => OrderStatus::Invoiced->value,
            'payment_method' => PaymentMethod::DirectDeposit->value,
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'total' => 67.00,
        ], $attributes));
    }

    public function test_invoiced_order_shows_the_payment_received_panel()
    {
        $this->signInAsAdmin();
        $order = $this->order();

        $this->get(route('backend.orders.edit', $order->id))
            ->assertOk()
            ->assertSee('Waiting for direct deposit')
            ->assertSee('$67.00')
            ->assertSee('Payment received');
    }

    public function test_other_orders_have_no_payment_received_panel()
    {
        $this->signInAsAdmin();

        foreach ([OrderStatus::Paid, OrderStatus::Shipped, OrderStatus::InCart] as $status) {
            $order = $this->order(['order_status_id' => $status->value]);

            $this->get(route('backend.orders.edit', $order->id))->assertDontSee('Waiting for direct deposit');
        }
    }

    public function test_payment_received_marks_the_order_paid_and_emails_the_receipt()
    {
        $this->signInAsAdmin();
        $order = $this->order(['payment_method' => null]);

        $this->post(route('backend.orders.payment.deposit', $order->id), ['email_receipt' => '1'])
            ->assertSessionHas('success_message', 'Order marked as paid. The receipt has been emailed to the customer.');

        $order->refresh();
        $this->assertSame(OrderStatus::Paid, $order->order_status_id);
        $this->assertSame(PaymentMethod::DirectDeposit, $order->payment_method);
        Mail::assertSent(OrderPaidMail::class, fn ($mail) => $mail->order->is($order)
            && $mail->hasTo('john@test.com')
            && $mail->hasBcc('sales@toadgully.com.au'));
    }

    public function test_payment_received_can_skip_the_receipt()
    {
        $this->signInAsAdmin();
        $order = $this->order();

        $this->post(route('backend.orders.payment.deposit', $order->id))
            ->assertSessionHas('success_message', 'Order marked as paid.');

        $this->assertSame(OrderStatus::Paid, $order->fresh()->order_status_id);
        Mail::assertNothingSent();
    }

    public function test_payment_received_only_works_once_and_only_for_invoiced_orders()
    {
        $this->signInAsAdmin();
        $invoiced = $this->order();
        $shipped = $this->order(['order_status_id' => OrderStatus::Shipped->value]);
        $inCart = $this->order(['order_status_id' => OrderStatus::InCart->value, 'payment_method' => null]);

        $this->post(route('backend.orders.payment.deposit', $invoiced->id), ['email_receipt' => '1']);
        $this->post(route('backend.orders.payment.deposit', $invoiced->id), ['email_receipt' => '1'])
            ->assertSessionHas('danger_message');

        foreach ([$shipped, $inCart] as $order) {
            $this->post(route('backend.orders.payment.deposit', $order->id), ['email_receipt' => '1'])
                ->assertSessionHas('danger_message');
        }

        Mail::assertSentCount(1);
        $this->assertSame(OrderStatus::Shipped, $shipped->fresh()->order_status_id);
        $this->assertSame(OrderStatus::InCart, $inCart->fresh()->order_status_id);
        $this->assertNull($inCart->fresh()->payment_method);
    }

    public function test_payment_received_needs_an_admin()
    {
        $order = $this->order();

        $this->post(route('backend.orders.payment.deposit', $order->id))->assertRedirect('/login');

        $this->assertSame(OrderStatus::Invoiced, $order->fresh()->order_status_id);
    }

    public function test_order_list_shows_and_filters_by_payment_method()
    {
        $this->signInAsAdmin();
        $card = $this->order(['name' => 'Carla Card', 'order_status_id' => OrderStatus::Paid->value, 'payment_method' => 'card']);
        $deposit = $this->order(['name' => 'Dan Deposit']);
        $unknown = $this->order(['name' => 'Una Unknown', 'order_status_id' => OrderStatus::Shipped->value, 'payment_method' => null]);

        $this->get(route('backend.orders.index'))
            ->assertSee('Carla Card')->assertSee('Dan Deposit')->assertSee('Una Unknown')
            ->assertSee('Direct deposit');

        $this->get(route('backend.orders.index', ['payment' => 'card']))
            ->assertSee('Carla Card')->assertDontSee('Dan Deposit')->assertDontSee('Una Unknown');

        $this->get(route('backend.orders.index', ['payment' => 'direct_deposit']))
            ->assertDontSee('Carla Card')->assertSee('Dan Deposit')->assertDontSee('Una Unknown');

        $this->get(route('backend.orders.index', ['payment' => 'unknown']))
            ->assertDontSee('Carla Card')->assertDontSee('Dan Deposit')->assertSee('Una Unknown');

        $this->get(route('backend.orders.index', ['payment' => 'bitcoin']))
            ->assertSee('Carla Card')->assertSee('Dan Deposit')->assertSee('Una Unknown');

        // The dashboard's list filters the same way
        $this->get(route('backend.index', ['payment' => 'card']))
            ->assertSee('Carla Card')->assertDontSee('Dan Deposit');
    }

    public function test_staff_can_set_the_payment_method_of_an_older_order()
    {
        $this->signInAsAdmin();
        $order = $this->order(['order_status_id' => OrderStatus::Shipped->value, 'payment_method' => null]);

        $this->put(route('backend.orders.update', $order->id), [
            'order_status_id' => OrderStatus::Shipped->value,
            'payment_method' => 'direct_deposit',
        ])->assertSessionHas('success_message');
        $this->assertSame(PaymentMethod::DirectDeposit, $order->fresh()->payment_method);

        $this->put(route('backend.orders.update', $order->id), [
            'order_status_id' => OrderStatus::Shipped->value,
            'payment_method' => '',
        ]);
        $this->assertNull($order->fresh()->payment_method);

        $this->put(route('backend.orders.update', $order->id), [
            'order_status_id' => OrderStatus::Shipped->value,
            'payment_method' => 'bitcoin',
        ])->assertSessionHasErrors('payment_method');
    }

    public function test_open_orders_leave_out_unfinished_checkouts()
    {
        $this->signInAsAdmin();
        $this->order(['order_status_id' => OrderStatus::InCart->value]);
        $this->order(['order_status_id' => OrderStatus::InCart->value]);
        $this->order(['order_status_id' => OrderStatus::Invoiced->value]);
        $this->order(['order_status_id' => OrderStatus::Paid->value]);
        $this->order(['order_status_id' => OrderStatus::Shipped->value]);

        $this->get(route('backend.index'))
            ->assertViewHas('openOrders', fn ($open) => $open->count() === 2)
            ->assertViewHas('orders', fn ($orders) => $orders->count() === 5);
    }
}
