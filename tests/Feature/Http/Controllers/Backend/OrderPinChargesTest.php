<?php

namespace Tests\Feature\Http\Controllers\Backend;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderPinChargesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Http::preventStrayRequests();
        config(['pin.host' => 'test-api.pinpayments.com', 'pin.secret' => 'secret_key']);
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
        return $this->order(['payment_started_at' => '2026-10-24 02:15:00']);
    }

    private function pinCharge(array $attributes = []): array
    {
        return array_merge([
            'token' => 'ch_found1',
            'success' => true,
            'captured' => true,
            'amount' => 6700,
            'email' => 'john@test.com',
            'description' => 'Farm Pack <br> ',
            'status_message' => 'Success',
            'error_message' => null,
            'created_at' => '2026-10-24T02:15:20Z',
            'metadata' => [],
        ], $attributes);
    }

    private function checkPin(Order $order)
    {
        return $this->get(route('backend.orders.edit', ['order' => $order->id, 'check_pin' => 1]));
    }

    public function test_opening_a_paid_order_does_not_ask_pin()
    {
        $order = $this->order(['order_status_id' => OrderStatus::Paid->value, 'charge_token' => 'ch_paid1']);

        $this->get(route('backend.orders.edit', $order->id))
            ->assertOk()
            ->assertSee('Check with Pin');

        Http::assertNothingSent();
    }

    public function test_warning_shows_a_matching_charge_and_fills_in_its_token()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response([
            'response' => [$this->pinCharge(), $this->pinCharge(['token' => 'ch_other', 'amount' => 1200])],
        ])]);

        $this->get(route('backend.orders.edit', $order->id))
            ->assertOk()
            ->assertSeeInOrder(['Pin status', 'Charged', 'successful charge of $67.00', 'ch_found1', 'mark the order as paid'])
            ->assertSee('id="charge_token" name="charge_token" placeholder="ch_..." value="ch_found1"', false);
    }

    public function test_warning_asks_staff_to_choose_between_several_matching_charges()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response([
            'response' => [$this->pinCharge(), $this->pinCharge(['token' => 'ch_found2'])],
        ])]);

        $this->get(route('backend.orders.edit', $order->id))
            ->assertSee('2 possible charges')
            ->assertSee('placeholder="ch_..." value=""', false);
    }

    public function test_warning_shows_a_failed_charge_as_not_charged()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response([
            'response' => [$this->pinCharge(['success' => false, 'captured' => false, 'error_message' => 'The card was declined'])],
        ])]);

        $this->get(route('backend.orders.edit', $order->id))
            ->assertSee('Not charged')
            ->assertSee('The card was declined')
            ->assertSee('placeholder="ch_..." value=""', false);
    }

    public function test_warning_says_when_pin_has_no_charge()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response(['response' => []])]);

        $this->get(route('backend.orders.edit', $order->id))
            ->assertSee('No charge found')
            ->assertSeeInOrder(['so release the order', 'Recommended', 'Release the order']);
    }

    public function test_warning_falls_back_to_the_pin_dashboard_when_pin_cannot_be_checked()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::failedConnection()]);

        $this->get(route('backend.orders.edit', $order->id))
            ->assertOk()
            ->assertSee('Check the Pin Payments dashboard for a charge to john@test.com for $67.00');
    }

        public function test_orders_never_paid_by_card_have_no_pin_panel()
    {
        $this->get(route('backend.orders.edit', $this->order()->id))
            ->assertOk()
            ->assertDontSee('Card payment in Pin');
    }

    public function test_unconfirmed_order_searches_pin_by_email_around_the_payment()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response([
            'response' => [
                $this->pinCharge(),
                $this->pinCharge(['token' => 'ch_other', 'amount' => 1200]),
            ],
        ])]);

        $this->checkPin($order)
            ->assertOk()
            ->assertSee('ch_found1')
            ->assertSee('ch_other')
            ->assertSee('24 Oct 2026, 1:15 pm')
            ->assertSee('Matches order')
            ->assertSee('Mark paid with this charge')
            ->assertSee('value="ch_found1"', false);

        Http::assertSent(function (Request $request) {
            return str_starts_with($request->url(), 'https://test-api.pinpayments.com/1/charges/search')
                && $request->hasHeader('Authorization', 'Basic ' . base64_encode('secret_key:'))
                && $request['query'] === 'john@test.com'
                && $request['start_date'] === '2026/10/23'
                && $request['end_date'] === '2026/10/26';
        });
    }

    public function test_charges_sent_with_the_order_number_are_marked_as_this_order()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response([
            'response' => [$this->pinCharge(['metadata' => ['order_id' => (string) $order->id]])],
        ])]);

        $this->checkPin($order)->assertSee('This order');
    }

    public function test_failed_charges_show_the_reason_and_cannot_be_used_to_mark_paid()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response([
            'response' => [$this->pinCharge(['success' => false, 'error_message' => 'The card was declined'])],
        ])]);

        $this->checkPin($order)
            ->assertSee('Failed')
            ->assertSee('The card was declined')
            ->assertDontSee('Mark paid with this charge');
    }

    public function test_no_charges_found_suggests_releasing_the_order()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response(['response' => []])]);

        $this->checkPin($order)
            ->assertOk()
            ->assertSee('Pin has no charges to john@test.com between 23 Oct 2026 and 25 Oct 2026')
            ->assertSee('release the order');
    }

    public function test_paid_order_looks_up_its_charge_by_token()
    {
        $order = $this->order([
            'order_status_id' => OrderStatus::Paid->value,
            'payment_started_at' => now()->subDay(),
            'charge_token' => 'ch_paid1',
        ]);
        Http::fake(['*/1/charges/ch_paid1' => Http::response(['response' => $this->pinCharge(['token' => 'ch_paid1'])])]);

        $this->checkPin($order)
            ->assertOk()
            ->assertSee('ch_paid1')
            ->assertSee('Charged')
            ->assertDontSee('Mark paid with this charge');

        Http::assertSent(fn (Request $request) => $request->url() === 'https://test-api.pinpayments.com/1/charges/ch_paid1');
    }

    public function test_unknown_charge_token_says_so()
    {
        $order = $this->order(['order_status_id' => OrderStatus::Paid->value, 'charge_token' => 'ch_missing']);
        Http::fake(['*/1/charges/ch_missing' => Http::response(['error' => 'not_found'], 404)]);

        $this->checkPin($order)->assertOk()->assertSee('Pin has no charge with this token');
    }

    public function test_pin_errors_are_shown_without_breaking_the_order_screen()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::response(['error' => 'server_error'], 500)]);

        $this->checkPin($order)
            ->assertOk()
            ->assertSee("Pin could not be checked")
            ->assertSee('Edit Order #' . $order->id);
    }

    public function test_pin_not_replying_is_shown_without_breaking_the_order_screen()
    {
        $order = $this->unconfirmedOrder();
        Http::fake(['*/1/charges/search*' => Http::failedConnection()]);

        $this->checkPin($order)->assertOk()->assertSee("Pin could not be checked");
    }

    public function test_missing_pin_key_is_explained()
    {
        config(['pin.secret' => null]);
        $order = $this->unconfirmedOrder();

        $this->checkPin($order)->assertOk()->assertSee('Set PIN_SECRET');

        Http::assertNothingSent();
    }
}
