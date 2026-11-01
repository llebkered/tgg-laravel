<?php

namespace Tests\Feature;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\User;
use App\Models\Variation;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

/**
 * Prices with cents are stored as whole cents, shown to customers and staff
 * to 2 decimal places, and charged for exactly what the cart adds up to.
 */
class DecimalPricesTest extends TestCase
{
    use RefreshDatabase;

    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        Mail::fake();
        Http::preventStrayRequests();
        Http::fake(['*/1/charges' => Http::response(['response' => ['token' => 'ch_test123', 'success' => true]], 201)]);

        foreach (['products', 'cart', 'checkout', 'thankyou'] as $slug) {
            Page::factory()->create(['title' => ucfirst($slug), 'slug' => $slug]);
        }

        $this->product = Product::factory()->create([
            'title' => 'Paulownia',
            'slug' => 'paulownia',
            'published' => true,
            'stocked' => true,
        ]);
    }

    private function variation(string $title, $price): Variation
    {
        return $this->product->variations()->create([
            'title' => $title,
            'slug' => str($title)->slug(),
            'description' => 'A pack',
            'price' => $price,
            'is_published' => true,
        ]);
    }

    private function addToCart(Variation $variation, int $qty = 1): void
    {
        for ($i = 0; $i < $qty; $i++) {
            $this->post('/cart', ['id' => $variation->id]);
        }
    }

    private function checkout(): Order
    {
        $this->post('/checkout', ['name' => 'John Doe', 'email' => 'john@test.com', 'phone' => '0491 570 000']);
        $this->post('/checkout/delivery', ['line1' => '1 Test St', 'city' => 'Testville', 'postcode' => '3000', 'state' => 'VIC', 'country' => 'Australia']);

        return Order::latest('id')->first();
    }

    private function payByCard()
    {
        return $this->post('/checkout/card', [
            'name' => 'John Doe',
            'number' => '4200000000000000',
            'month' => '12',
            'year' => (string) (date('Y') + 1),
            'cvc' => '123',
        ]);
    }

    public function test_prices_are_stored_as_integer_cents()
    {
        $variation = $this->variation('Small', '19.95');

        $this->assertSame('integer', Schema::getColumnType('variations', 'price_cents'));
        $this->assertFalse(Schema::hasColumn('variations', 'price'));
        $this->assertSame(1995, DB::table('variations')->where('id', $variation->id)->value('price_cents'));
    }

    public function test_customers_see_prices_to_two_decimal_places()
    {
        $small = $this->variation('Small', '19.95');
        $this->variation('Large', 35);

        $this->get('/product/paulownia')->assertOk()->assertSee('$19.95')->assertSee('$35.00');

        $this->addToCart($small, 3);

        $this->get('/cart')->assertOk()->assertSee('$19.95')->assertSee('$59.85');

        $this->checkout();
        $this->get('/checkout/directdeposit')->assertOk()->assertSee('$19.95')->assertSee('Total: $59.85');
    }

    public function test_thank_you_page_shows_prices_to_two_decimal_places()
    {
        $this->addToCart($this->variation('Small', '19.95'), 2);
        $this->checkout();

        $this->payByCard()->assertRedirect(route('checkout.thankyou'));

        $this->get('/checkout/thankyou')->assertOk()->assertSee('$19.95')->assertSee('Total: $39.90');
    }

    public function test_staff_see_prices_to_two_decimal_places()
    {
        $small = $this->variation('Small', '19.95');
        $this->addToCart($small, 3);
        $order = $this->checkout();

        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('backend.products.show', $this->product))->assertOk()->assertSee('$19.95');
        $this->get(route('backend.variations.edit', $small))->assertOk()->assertSee('value="19.95"', false);
        $this->get(route('backend.orders.edit', $order))->assertOk()->assertSee('$59.85');
    }

    public function test_an_order_total_with_a_zero_in_the_cents_shows_both_decimal_places()
    {
        $this->addToCart($this->variation('Small', '19.95'), 2);
        $order = $this->checkout();

        $this->actingAs(User::factory()->admin()->create());

        $this->get(route('backend.orders.edit', $order))->assertOk()->assertSee('$39.90')->assertDontSee('$39.9<', false);
    }

    public static function baskets(): array
    {
        // Each is [[price, qty], ...] and the total in cents. They include
        // amounts that floating-point arithmetic gets slightly wrong, such as
        // 0.1 + 0.2 and 19.95 x 3.
        return [
            'one dollar' => [[['1', 1]], 100],
            'one cent' => [[['0.01', 1]], 1],
            'one hundred dollars' => [[['100', 1]], 10000],
            'one item' => [[['19.95', 1]], 1995],
            'several of one item' => [[['19.95', 3]], 5985],
            'ten cents and twenty cents' => [[['0.10', 1], ['0.20', 1]], 30],
            'thirds of a hundred' => [[['33.33', 3]], 9999],
            'seven at 29 cents' => [[['0.29', 7]], 203],
            'over a thousand dollars' => [[['1234.56', 1], ['0.01', 1]], 123457],
            'whole dollars' => [[['35', 2], ['59', 1]], 12900],
        ];
    }

    #[DataProvider('baskets')]
    public function test_card_is_charged_exactly_what_the_cart_adds_up_to(array $basket, int $cents)
    {
        foreach ($basket as $i => [$price, $qty]) {
            $this->addToCart($this->variation("Pack $i", $price), $qty);
        }

        $order = $this->checkout();

        $this->assertSame($cents, (int) round($order->total * 100));

        $this->payByCard()->assertRedirect(route('checkout.thankyou'));

        Http::assertSentCount(1);
        Http::assertSent(fn (Request $request) => $request['amount'] === $cents);
    }

    public function test_staff_entering_a_price_with_cents_changes_what_the_customer_pays()
    {
        $small = $this->variation('Small', 20);
        $this->actingAs(User::factory()->admin()->create());

        $this->put(route('backend.variations.update', $small), [
            'title' => 'Small',
            'description' => 'A pack',
            'price' => '19.95',
            'is_published' => 1,
        ])->assertSessionHasNoErrors();

        $this->addToCart($small, 2);
        $this->checkout();
        $this->payByCard();

        Http::assertSent(fn (Request $request) => $request['amount'] === 3990);
    }

    public function test_card_page_shows_the_amount_to_be_charged_in_aud()
    {
        $this->addToCart($this->variation('Small', '19.95'), 3);
        $this->checkout();

        $this->get('/checkout/card')
            ->assertOk()
            ->assertSeeInOrder(['3 x Paulownia - Small', '$59.85', 'Includes GST', '$5.44', 'Total to pay', '$59.85 AUD'])
            ->assertSee('Pay $59.85');
    }

    public function test_cart_says_prices_are_in_aud()
    {
        $this->addToCart($this->variation('Small', '19.95'));

        $this->get('/cart')->assertOk()->assertSee('All prices are in Australian dollars (AUD) and include GST.');
    }

    public function test_amounts_of_a_thousand_dollars_or_more_are_shown_the_same_way_everywhere()
    {
        $big = $this->variation('Big', '1234.56');

        $this->get('/product/paulownia')->assertSee('$1,234.56');

        $this->addToCart($big);
        $this->get('/cart')->assertSee('$1,234.56')->assertDontSee('$1234.56');

        $order = $this->checkout();
        $this->get('/checkout/card')->assertSee('$1,234.56 AUD')->assertDontSee('$1234.56');

        $this->payByCard();
        $this->get('/checkout/thankyou')->assertSee('Total: $1,234.56')->assertDontSee('$1234.56');

        $this->actingAs(User::factory()->admin()->create());
        $this->get(route('backend.orders.edit', $order))->assertSee('$1,234.56')->assertDontSee('$1234.56');
    }

    public function test_card_is_not_charged_when_the_cart_changed_after_the_order_was_made()
    {
        $this->addToCart($this->variation('Small', '35'));
        $order = $this->checkout();

        // e.g. in another tab, after reaching the payment page
        $this->addToCart($this->variation('Large', '59'));

        $this->payByCard()
            ->assertRedirect(route('checkout.index'))
            ->assertSessionHas('warning_message');

        Http::assertNothingSent();
        $this->assertSame(OrderStatus::InCart, $order->fresh()->order_status_id);
        $this->get('/cart')->assertSee('$94.00');
    }

    public function test_direct_deposit_order_is_not_placed_when_the_cart_changed_after_the_order_was_made()
    {
        $small = $this->variation('Small', '35');
        $this->addToCart($small, 2);
        $order = $this->checkout();

        $this->delete(route('cart.destroy', Cart::instance('cart')->content()->first()->rowId));
        $this->addToCart($small);

        $this->get('/checkout/directdeposit')
            ->assertRedirect(route('checkout.index'))
            ->assertSessionHas('warning_message');

        $this->assertSame(OrderStatus::InCart, $order->fresh()->order_status_id);
    }

    public function test_starting_checkout_again_after_the_cart_changed_charges_the_new_total()
    {
        $this->addToCart($this->variation('Small', '35'));
        $this->checkout();
        $this->addToCart($this->variation('Large', '59'));
        $this->payByCard();

        $this->checkout();
        $this->payByCard()->assertRedirect(route('checkout.thankyou'));

        Http::assertSentCount(1);
        Http::assertSent(fn (Request $request) => $request['amount'] === 9400 && $request['currency'] === 'AUD');
    }

    public function test_a_price_of_zero_is_refused()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->post(route('backend.variations.store'), [
            'title' => 'Free',
            'description' => 'A pack',
            'price' => '0.00',
            'product_id' => $this->product->id,
        ])->assertSessionHasErrors('price');

        $this->assertSame(0, Variation::count());
    }
}
