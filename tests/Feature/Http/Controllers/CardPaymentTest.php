<?php

namespace Tests\Feature\Http\Controllers;

use App\Enums\OrderStatus;
use App\Libraries\Pin\PinPayments;
use App\Models\Order;
use App\Models\Page;
use Gloudemans\Shoppingcart\Facades\Cart;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Request as PsrRequest;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CardPaymentTest extends TestCase
{
    use RefreshDatabase;

    private FakePinPayments $pin;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Page::factory()->create(['title' => 'Checkout', 'slug' => 'checkout']);

        $this->pin = new FakePinPayments();
        $this->app->instance(PinPayments::class, $this->pin);
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
        $this->pin->respondWith(new Response(201, [], json_encode(['response' => ['token' => 'ch_test123', 'success' => true]])));

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.thankyou'));
        $this->assertSame(1, $this->pin->charges);
        $order->refresh();
        $this->assertEquals(OrderStatus::Paid->value, $order->order_status_id);
        $this->assertSame('ch_test123', $order->charge_token);
    }

    public function test_charge_amount_is_the_order_total_in_cents()
    {
        $this->createOrder(['total' => 19.99]);
        $this->pin->respondWith(new Response(201, [], json_encode(['response' => ['token' => 'ch_test123']])));

        $this->payByCard();

        $this->assertSame(1999, $this->pin->lastCharge['amount']);
    }

    public function test_paid_order_is_not_charged_again()
    {
        $this->createOrder();
        $this->pin->respondWith(new Response(201, [], json_encode(['response' => ['token' => 'ch_test123']])));

        $this->payByCard();
        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.thankyou'));
        $this->assertSame(1, $this->pin->charges);
    }

    public function test_order_being_paid_is_not_charged_again()
    {
        // Another request (e.g. a double click) has already claimed the order.
        $this->createOrder(['payment_started_at' => now()]);

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.card'));
        $response->assertSessionHas('danger_message');
        $this->assertSame(0, $this->pin->charges);
    }

    public function test_declined_card_can_be_retried()
    {
        $order = $this->createOrder();
        $this->pin->respondWith(
            new Response(400, [], json_encode(['error' => 'card_declined', 'error_description' => 'The card was declined'])),
            new Response(201, [], json_encode(['response' => ['token' => 'ch_test123']])),
        );

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.card'));
        $response->assertSessionHas('danger_message', 'The card was declined');
        $this->assertNull($order->fresh()->payment_started_at);

        $this->payByCard()->assertRedirect(route('checkout.thankyou'));
        $this->assertSame(2, $this->pin->charges);
        $this->assertEquals(OrderStatus::Paid->value, $order->fresh()->order_status_id);
    }

    public function test_declined_card_details_are_not_kept_in_the_session()
    {
        $this->createOrder();
        $this->pin->respondWith(new Response(400, [], json_encode(['error_description' => 'The card was declined'])));

        $this->payByCard();

        $this->assertNull(session()->getOldInput('number'));
        $this->assertNull(session()->getOldInput('cvc'));
    }

    public function test_gateway_error_blocks_retries()
    {
        $order = $this->createOrder();
        $this->pin->respondWith(new Response(502, [], json_encode(['error' => 'gateway_error'])));

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.card'));
        $response->assertSessionHas('danger_message');
        $this->assertNotNull($order->fresh()->payment_started_at);
        $this->assertEquals(OrderStatus::InCart->value, $order->fresh()->order_status_id);

        // A retry must not reach Pin, because the first charge may have gone through.
        $this->payByCard();
        $this->assertSame(1, $this->pin->charges);
    }

    public function test_timeout_blocks_retries()
    {
        $order = $this->createOrder();
        $this->pin->respondWith(new ConnectException('timed out', new PsrRequest('POST', 'https://example.test')));

        $response = $this->payByCard();

        $response->assertRedirect(route('checkout.card'));
        $this->assertNotNull($order->fresh()->payment_started_at);

        $this->payByCard();
        $this->assertSame(1, $this->pin->charges);
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
        $this->pin->respondWith(new Response(201, [], json_encode(['response' => ['token' => 'ch_test123']])));

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
        $this->pin->respondWith(new Response(201, [], json_encode(['response' => ['token' => 'ch_test123']])));

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
        $this->pin->respondWith(new Response(201, [], json_encode(['response' => ['token' => 'ch_test123']])));
        $this->payByCard();

        Mail::spy();
        $this->get('/checkout/thankyou')->assertOk()->assertSee('John Doe')->assertSee('Farm Pack');
        $this->get('/checkout/thankyou')->assertOk()->assertSee('1 Main St');

        Mail::shouldNotHaveReceived('send');
    }

    public function test_resubmitting_the_card_form_after_paying_shows_the_thank_you_page()
    {
        $this->createOrder();
        $this->pin->respondWith(new Response(201, [], json_encode(['response' => ['token' => 'ch_test123']])));
        $this->payByCard();

        $this->get('/checkout/card')->assertRedirect(route('checkout.thankyou'));
        $this->payByCard()->assertRedirect(route('checkout.thankyou'));
        $this->assertSame(1, $this->pin->charges);
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
        $this->pin->respondWith(new Response(201, [], json_encode(['response' => ['token' => 'ch_test123']])));
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

class FakePinPayments extends PinPayments
{
    public int $charges = 0;

    public ?array $lastCharge = null;

    private array $responses = [];

    public function respondWith(...$responses): void
    {
        $this->responses = $responses;
    }

    public function charge($card)
    {
        $this->charges++;
        $this->lastCharge = $card;
        $response = array_shift($this->responses);

        if ($response instanceof \Throwable) {
            throw $response;
        }

        return $response;
    }
}
