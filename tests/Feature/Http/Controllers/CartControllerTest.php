<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use App\Models\Product;
use App\Models\Variation;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createCartPage()
    {
        Page::factory()->create([
            'title' => 'Cart',
            'slug' => 'cart',
        ]);
        Page::factory()->create([
            'title' => 'Products',
            'slug' => 'products',
        ]);

        // create products
        $product = Product::factory()->create([
            'title' => 'Product 1',
            'slug' => 'product-1',
            'code' => 'PROD1',
            'image' => 'https://via.placeholder.com/150',
            'description' => 'This is a test product',
            'published' => true,
            'stocked' => true,
        ]);

        // create variations
        $data = [
            [

                'title' => 'Small Pack',
                'slug' => 'small',
                'image' => 'https://via.placeholder.com/150',
                'description' => 'This is a small product',
                'price' => 100,
                'is_published' => true,
            ],
            [

                'title' => 'Medium Pack',
                'slug' => 'medium',
                'image' => 'https://via.placeholder.com/150',
                'description' => 'This is a medium product',
                'price' => 200,
                'is_published' => true,
            ],
            [

                'title' => 'Large Pack',
                'slug' => 'large',
                'image' => 'https://via.placeholder.com/150',
                'description' => 'This is a large product',
                'price' => 300,
                'is_published' => true,
            ],
        ];

        $product->variations()->createMany($data);

    }

    public function test_cart_page_loads()
    {

        //$this->withoutExceptionHandling();
        $this->createCartPage();

        $response = $this->get('/cart');

        $response->assertStatus(200);
    }

    public function test_full_cart_should_display_items()
    {
        $this->withoutExceptionHandling();

        $this->createCartPage();

        // fake adding an item to the cart
        $response = $this->post('/cart', [
            'id' => Variation::where('slug', 'small')->value('id'),
        ]);

        // check if the cart page loads
        $response->assertStatus(302);
    }

    public function test_cart_shows_the_gst_included_in_the_total()
    {
        $this->createCartPage();
        $variation = Variation::where('slug', 'small')->first();
        $this->post('/cart', ['id' => $variation->id, 'name' => 'Small Pack', 'qty' => 1, 'price' => 100]);

        $this->get('/cart')->assertOk()->assertSeeInOrder(['Includes GST', '$9.09']);
    }

    public function test_cart_shows_each_items_own_product_code()
    {
        $this->createCartPage();
        $other = Product::factory()->create([
            'title' => 'Product 2',
            'slug' => 'product-2',
            'code' => 'PROD2',
            'image' => 'https://via.placeholder.com/150',
            'description' => 'Another product',
            'published' => true,
            'stocked' => true,
        ]);
        $big = $other->variations()->create([
            'title' => 'Big Pack',
            'slug' => 'big',
            'image' => 'https://via.placeholder.com/150',
            'description' => 'A big pack',
            'price' => 500,
            'is_published' => true,
        ]);
        $small = Variation::where('slug', 'small')->first();

        // Add the newer variation first, so cart order differs from id order
        $this->post('/cart', ['id' => $big->id, 'name' => 'Product 2 - Big Pack', 'qty' => 1, 'price' => 500]);
        $this->post('/cart', ['id' => $small->id, 'name' => 'Product 1 - Small Pack', 'qty' => 1, 'price' => 100]);

        $this->get('/cart')->assertOk()->assertSeeInOrder([
            'PROD2', 'Product 2 - Big Pack',
            'PROD1', 'Product 1 - Small Pack',
        ]);
    }

    public function test_cart_removes_an_item_whose_variation_was_deleted()
    {
        $this->createCartPage();
        $small = Variation::where('slug', 'small')->first();
        $this->post('/cart', ['id' => $small->id]);

        $small->delete();

        $this->get('/cart')->assertOk()
            ->assertSee('Product 1 - Small Pack is no longer available and has been removed.');
        $this->assertSame(0, Cart::instance('cart')->count());
    }

    public function test_cart_removes_items_that_are_no_longer_available()
    {
        $this->createCartPage();
        $small = Variation::where('slug', 'small')->first();
        $medium = Variation::where('slug', 'medium')->first();
        $large = Variation::where('slug', 'large')->first();
        $this->post('/cart', ['id' => $small->id]);
        $this->post('/cart', ['id' => $medium->id]);
        $this->post('/cart', ['id' => $large->id]);

        $medium->update(['is_published' => false]);

        $this->get('/cart')->assertOk()
            ->assertSee('Product 1 - Medium Pack is no longer available');
        $this->assertSame(2, Cart::instance('cart')->count());
        $this->assertSame('400.00', Cart::instance('cart')->total(2, '.', ''));

        $small->product->update(['stocked' => false]);

        $this->get('/cart')->assertOk();
        $this->assertSame(0, Cart::instance('cart')->count());
    }

    public function test_cart_updates_a_changed_price_and_tells_the_customer()
    {
        $this->createCartPage();
        $small = Variation::where('slug', 'small')->first();
        $this->post('/cart', ['id' => $small->id]);

        $small->update(['price' => 120]);

        $this->get('/cart')->assertOk()
            ->assertSee('Product 1 - Small Pack has changed price from $100.00 to $120.00.');
        $this->assertSame('120.00', Cart::instance('cart')->total(2, '.', ''));

        // Told once, not on every visit
        $this->get('/cart')->assertOk()->assertDontSee('has changed price');
    }

    public function test_cart_updates_a_changed_name_without_a_message()
    {
        $this->createCartPage();
        $small = Variation::where('slug', 'small')->first();
        $this->post('/cart', ['id' => $small->id]);

        $small->update(['title' => 'Mini Pack']);

        $this->get('/cart')->assertOk()
            ->assertSee('Product 1 - Mini Pack')
            ->assertDontSee('has changed price');
        $this->assertSame('Product 1 - Mini Pack', Cart::instance('cart')->content()->first()->name);
    }

    public function test_price_and_name_come_from_the_product_not_the_form()
    {
        $this->createCartPage();
        $small = Variation::where('slug', 'small')->first();

        $this->post('/cart', ['id' => $small->id, 'name' => 'Free stuff', 'price' => 0.01]);

        $item = Cart::instance('cart')->content()->first();
        $this->assertSame('Product 1 - Small Pack', $item->name);
        $this->assertEquals(100, $item->price);
        $this->assertSame('100.00', Cart::instance('cart')->total(2, '.', ''));
    }

    public function test_unavailable_items_cannot_be_added()
    {
        $this->createCartPage();
        $small = Variation::where('slug', 'small')->first();
        $medium = Variation::where('slug', 'medium')->first();
        $medium->update(['is_published' => false]);

        // Unknown variation, unpublished variation
        $this->post('/cart', ['id' => 99999])->assertSessionHas('danger_message');
        $this->post('/cart', ['id' => $medium->id])->assertSessionHas('danger_message');

        // Out of stock product
        $small->product->update(['stocked' => false]);
        $this->post('/cart', ['id' => $small->id])->assertSessionHas('danger_message');

        // Unpublished product
        $small->product->update(['stocked' => true, 'published' => false]);
        $this->post('/cart', ['id' => $small->id])->assertSessionHas('danger_message');

        $this->assertSame(0, Cart::instance('cart')->count());
    }

    public function test_cart_can_remove_item()
    {
        // $this->withoutExceptionHandling();

        $this->createCartPage();

        // fake adding an item to the cart
        $response = $this->post('/cart', [
            'id' => Variation::where('slug', 'small')->value('id'),
        ]);

        // check if the cart page loads
        $response->assertStatus(302);

        // get cart first row id
        $cart = Cart::instance('cart')->content()->first()->rowId;

        // remove the item from the cart
        $response = $this->delete('/cart/' . $cart);

        // check if the cart page loads
        $response->assertStatus(302);
    }

    public function test_removing_an_item_that_is_already_gone_goes_back_to_the_cart()
    {
        $this->createCartPage();
        $this->post('/cart', ['id' => Variation::where('slug', 'small')->value('id')]);
        $rowId = Cart::instance('cart')->content()->first()->rowId;

        // A double click sends the same removal twice
        $this->from('/cart')->delete('/cart/' . $rowId)->assertRedirect('/cart');
        $this->from('/cart')->delete('/cart/' . $rowId)->assertRedirect('/cart');
        $this->from('/cart')->delete('/cart/not-a-row-id')->assertRedirect('/cart');

        $this->assertSame(0, Cart::instance('cart')->count());
    }

}
