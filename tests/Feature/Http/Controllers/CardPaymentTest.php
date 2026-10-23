<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Page;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CardPaymentTest extends TestCase
{
    use RefreshDatabase;

    private const PAID = [201, ['response' => ['token' => 'ch_test123', 'success' => true]]];

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Page::factory()->create(['title' => 'Checkout', 'slug' => 'checkout']);
        Http::preventStrayRequests();
    }

    /**
     * Fake Pin's replies to charge requests, in order. A status of 0 means
     * Pin didn't reply (e.g. a timeout).
     */
    private function fakePin(array ...$replies): void
    {
        $sequence = Http::sequence();

        foreach ($replies as [$status, $body]) {
            $status === 0 ? $sequence->pushFailedConnection('timed out') : $sequence->push($body, $status);
        }

        Http::fake(['*/1/charges' => $sequence]);
    }

    private function createOrder(array $attributes = []): Order
    {
        $order = Order::create(array_merge([
            'order_status_id' => OrderStatus::InCart->value,
            'name' => 'John Doe',
            'email' => 'john@test.com',
            'total' => 25.00,
        ], $attributes));

        $this->withSession(['order' => $order->id]);

        return $order;
    }

    private function payByCard()
    {
        return $this->post('/checkout/card', [
            'number' => '4200000000000000',
            'month' => '12',
            'year' => (string) (date('Y') + 1),
            'cvc' => '123',
        ]);
    }

    public function test_successful_payment_marks_the_order_paid()
    {
        $order = $this->createOrder();
        $this->fakePin(self::PAID);

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.thankyou'));
        Http::assertSentCount(1);
        $order->refresh();
        $this->assertEquals(OrderStatus::Paid->value, $order->order_status_id);
        $this->assertSame('ch_test123', $order->charge_token);
    }

    public function test_charge_amount_is_the_order_total_in_cents()
    {
        $this->createOrder(['total' => 19.99]);
        $this->fakePin(self::PAID);

        $this->payByCard();

        Http::assertSent(fn (Request $request) => $request['amount'] === 1999);
    }

    public function test_charge_is_sent_to_pin_with_the_card_and_order_details()
    {
        config(['pin.host' => 'test-api.pinpayments.com', 'pin.secret' => 'secret_key']);
        $this->createOrder([
            'line1' => '1 Main St',
            'city' => 'Melbourne',
            'postcode' => '3000',
            'cart' => json_encode(['row1' => ['name' => 'Farm Pack'], 'row2' => ['name' => 'Estate Pack']]),
        ]);
        $this->fakePin(self::PAID);

        $this->payByCard();

        Http::assertSent(function (Request $request) {
            return $request->url() === 'https://test-api.pinpayments.com/1/charges'
                && $request->hasHeader('Authorization', 'Basic ' . base64_encode('secret_key:'))
                && $request['card']['number'] === '4200000000000000'
                && $request['card']['expiry_month'] === '12'
                && $request['card']['cvc'] === '123'
                && $request['card']['name'] === 'John Doe'
                && $request['card']['address_line1'] === '1 Main St'
                && $request['card']['address_postcode'] === '3000'
                && $request['description'] === 'Farm Pack <br> Estate Pack <br> '
                && $request['email'] === 'john@test.com';
        });
    }

    public function test_paid_order_is_not_charged_again()
    {
        $this->createOrder();
        $this->fakePin(self::PAID);

        $this->payByCard();
        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.thankyou'));
        Http::assertSentCount(1);
    }

    public function test_order_being_paid_is_not_charged_again()
    {
        // Another request (e.g. a double click) has already claimed the order.
        $this->createOrder(['payment_started_at' => now()]);

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.card'));
        $response->assertSessionHas('danger_message');
        Http::assertSentCount(0);
    }

    public function test_declined_card_can_be_retried()
    {
        $order = $this->createOrder();
        $this->fakePin(
            [400, ['error' => 'card_declined', 'error_description' => 'The card was declined']],
            self::PAID,
        );

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.card'));
        $response->assertSessionHas('danger_message', 'The card was declined');
        $this->assertNull($order->fresh()->payment_started_at);

        $this->payByCard()->assertRedirect(route('checkout.thankyou'));
        Http::assertSentCount(2);
        $this->assertEquals(OrderStatus::Paid->value, $order->fresh()->order_status_id);
    }

    public function test_declined_card_details_are_not_kept_in_the_session()
    {
        $this->createOrder();
        $this->fakePin([400, ['error_description' => 'The card was declined']]);

        $this->payByCard();

        $this->assertNull(session()->getOldInput('number'));
        $this->assertNull(session()->getOldInput('cvc'));
    }

    public function test_gateway_error_blocks_retries()
    {
        $order = $this->createOrder();
        $this->fakePin([502, ['error' => 'gateway_error']]);

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.card'));
        $response->assertSessionHas('danger_message');
        $this->assertNotNull($order->fresh()->payment_started_at);
        $this->assertEquals(OrderStatus::InCart->value, $order->fresh()->order_status_id);

        // A retry must not reach Pin, because the first charge may have gone through.
        $this->payByCard();
        Http::assertSentCount(1);
    }

    public function test_timeout_blocks_retries()
    {
        $order = $this->createOrder();
        $this->fakePin([0, null]);

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.card'));
        $this->assertNotNull($order->fresh()->payment_started_at);

        $this->payByCard();
        Http::assertSentCount(1);
    }

    public function test_card_page_redirects_once_the_order_is_paid()
    {
        $this->createOrder(['order_status_id' => OrderStatus::Paid->value]);

        $this->get('/checkout/card')->assertRedirect(route('checkout.thankyou'));
    }

    public function test_successful_payment_emails_the_receipt_and_ends_the_checkout()
    {
        Mail::spy();
        Cart::instance('cart')->add('1', 'Farm Pack', 1, 25.00);
        $order = $this->createOrder();
        $this->fakePin(self::PAID);

        $this->payByCard();

        Mail::shouldHaveReceived('send')->once();
        $this->assertSame(0, Cart::instance('cart')->count());
        $this->assertNull(session('order'));
        $this->assertSame($order->id, session('paid_order'));
    }

    public function test_failed_receipt_email_still_completes_the_checkout()
    {
        Mail::shouldReceive('send')->andThrow(new \RuntimeException('mail server down'));
        $order = $this->createOrder();
        $this->fakePin(self::PAID);

        $this->payByCard()->assertRedirect(route('checkout.thankyou'));

        $this->assertEquals(OrderStatus::Paid->value, $order->fresh()->order_status_id);
        $this->assertSame($order->id, session('paid_order'));
    }

    public function test_thank_you_page_can_be_refreshed_without_sending_email()
    {
        $this->createOrder([
            'line1' => '1 Main St',
            'cart' => json_encode(['row1' => ['name' => 'Farm Pack', 'price' => 25]]),
        ]);
        $this->fakePin(self::PAID);
        $this->payByCard();

        Mail::spy();
        $this->get('/checkout/thankyou')->assertOk()->assertSee('John Doe')->assertSee('Farm Pack');
        $this->get('/checkout/thankyou')->assertOk()->assertSee('1 Main St');

        Mail::shouldNotHaveReceived('send');
    }

    public function test_resubmitting_the_card_form_after_paying_shows_the_thank_you_page()
    {
        $this->createOrder();
        $this->fakePin(self::PAID);
        $this->payByCard();

        $this->get('/checkout/card')->assertRedirect(route('checkout.thankyou'));
        $this->payByCard()->assertRedirect(route('checkout.thankyou'));
        Http::assertSentCount(1);
    }

    public function test_direct_deposit_does_not_change_a_paid_order()
    {
        Mail::spy();
        $order = $this->createOrder(['order_status_id' => OrderStatus::Paid->value]);

        $this->get('/checkout/directdeposit')->assertRedirect(route('checkout.thankyou'));

        $this->assertEquals(OrderStatus::Paid->value, $order->fresh()->order_status_id);
        Mail::shouldNotHaveReceived('send');
    }

    public function test_direct_deposit_after_paying_by_card_shows_the_thank_you_page()
    {
        $order = $this->createOrder();
        $this->fakePin(self::PAID);
        $this->payByCard();

        $this->get('/checkout/directdeposit')->assertRedirect(route('checkout.thankyou'));

        $this->assertEquals(OrderStatus::Paid->value, $order->fresh()->order_status_id);
    }

    public function test_direct_deposit_is_blocked_while_a_card_payment_is_in_progress()
    {
        Mail::spy();
        $order = $this->createOrder(['payment_started_at' => now()]);

        $response = $this->get('/checkout/directdeposit');

        $response->assertRedirect(route('checkout.card'));
        $response->assertSessionHas('danger_message');
        $this->assertEquals(OrderStatus::InCart->value, $order->fresh()->order_status_id);
        Mail::shouldNotHaveReceived('send');
    }

    public function test_thank_you_page_needs_a_paid_order()
    {
        $this->get('/checkout/thankyou')->assertRedirect('/cart');

        $this->createOrder();
        $this->get('/checkout/thankyou')->assertRedirect('/cart');
    }
}
