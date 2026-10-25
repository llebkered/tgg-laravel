<?php

namespace Tests\Feature\Console;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MatchPinPaymentsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['pin.host' => 'test-api.pinpayments.com', 'pin.secret' => 'secret_key']);
    }

    private function order(string $email, array $attributes = []): Order
    {
        return Order::create(array_merge([
            'order_status_id' => OrderStatus::Shipped->value,
            'name' => 'John Doe',
            'email' => $email,
            'total' => 67.00,
            'created_at' => '2025-03-10 01:00:00',
        ], $attributes));
    }

    private function charge(array $attributes = []): array
    {
        return array_merge([
            'token' => 'ch_paid',
            'success' => true,
            'captured' => true,
            'amount' => 6700,
            'email' => 'paid@test.com',
            'description' => 'Farm Pack',
            'created_at' => '2025-03-10T01:05:00Z',
        ], $attributes);
    }

    /**
     * Fake Pin's search, answering by the email searched for.
     */
    private function fakePinSearch(array $chargesByEmail): void
    {
        Http::fake(function (Request $request) use ($chargesByEmail) {
            return Http::response(['response' => $chargesByEmail[$request['query']] ?? []]);
        });
    }

    public function test_orders_with_a_successful_pin_charge_are_set_to_card()
    {
        $paid = $this->order('paid@test.com');
        $deposit = $this->order('deposit@test.com');
        $declined = $this->order('declined@test.com');
        $wrongAmount = $this->order('other@test.com');
        $this->fakePinSearch([
            'paid@test.com' => [$this->charge()],
            'declined@test.com' => [$this->charge(['token' => 'ch_declined', 'email' => 'declined@test.com', 'success' => false, 'captured' => false])],
            'other@test.com' => [$this->charge(['token' => 'ch_other', 'email' => 'other@test.com', 'amount' => 1500])],
        ]);

        $this->artisan('orders:match-pin-payments')
            ->expectsOutputToContain('Set to card: 1. Unclear: 0. No successful charge in Pin: 3. Errors: 0.')
            ->assertSuccessful();

        $this->assertSame(PaymentMethod::Card, $paid->fresh()->payment_method);
        $this->assertSame('ch_paid', $paid->fresh()->charge_token);
        $this->assertSame(OrderStatus::Shipped, $paid->fresh()->order_status_id);
        foreach ([$deposit, $declined, $wrongAmount] as $order) {
            $this->assertNull($order->fresh()->payment_method);
            $this->assertNull($order->fresh()->charge_token);
        }
    }

    public function test_dry_run_saves_nothing()
    {
        $order = $this->order('paid@test.com');
        $this->fakePinSearch(['paid@test.com' => [$this->charge()]]);

        $this->artisan('orders:match-pin-payments --dry-run')
            ->expectsOutputToContain('Would set to card: 1.')
            ->assertSuccessful();

        $this->assertNull($order->fresh()->payment_method);
    }

    public function test_orders_with_several_possible_charges_are_left_for_staff()
    {
        $order = $this->order('paid@test.com');
        $this->fakePinSearch(['paid@test.com' => [$this->charge(), $this->charge(['token' => 'ch_paid2'])]]);

        $this->artisan('orders:match-pin-payments')
            ->expectsOutputToContain('Unclear: 1.')
            ->assertSuccessful();

        $this->assertNull($order->fresh()->payment_method);
    }

    public function test_orders_with_a_known_payment_method_are_not_checked()
    {
        $this->order('paid@test.com', ['payment_method' => PaymentMethod::DirectDeposit->value]);
        Http::fake();

        $this->artisan('orders:match-pin-payments')
            ->expectsOutputToContain('No orders have an unknown payment method.')
            ->assertSuccessful();

        Http::assertNothingSent();
    }

    public function test_can_check_chosen_orders_only()
    {
        $chosen = $this->order('paid@test.com');
        $other = $this->order('paid@test.com');
        $this->fakePinSearch(['paid@test.com' => [$this->charge()]]);

        $this->artisan('orders:match-pin-payments', ['--order' => [$chosen->id]])->assertSuccessful();

        $this->assertSame(PaymentMethod::Card, $chosen->fresh()->payment_method);
        $this->assertNull($other->fresh()->payment_method);
        Http::assertSentCount(1);
    }

    public function test_pin_errors_are_reported_and_other_orders_still_checked()
    {
        $failing = $this->order('down@test.com');
        $paid = $this->order('paid@test.com');
        Http::fake(function (Request $request) {
            return $request['query'] === 'down@test.com'
                ? Http::response(['error' => 'server_error'], 500)
                : Http::response(['response' => [$this->charge()]]);
        });

        $this->artisan('orders:match-pin-payments')
            ->expectsOutputToContain('Pin error')
            ->assertFailed();

        $this->assertNull($failing->fresh()->payment_method);
        $this->assertSame(PaymentMethod::Card, $paid->fresh()->payment_method);
    }

    public function test_charged_order_still_in_cart_is_flagged()
    {
        $order = $this->order('paid@test.com', ['order_status_id' => OrderStatus::InCart->value]);
        $this->fakePinSearch(['paid@test.com' => [$this->charge()]]);

        $this->artisan('orders:match-pin-payments')
            ->expectsOutputToContain('still In Cart')
            ->assertSuccessful();

        $this->assertSame(OrderStatus::InCart, $order->fresh()->order_status_id);
    }
}
