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
            'id' => '293ad',
            'name' => 'Product 1',
            'qty' => 1,
            'price' => 100,
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

    public function test_cart_can_remove_item()
    {
        // $this->withoutExceptionHandling();

        $this->createCartPage();

        // fake adding an item to the cart
        $response = $this->post('/cart', [
            'id' => '293ad',
            'name' => 'Product 1',
            'qty' => 1,
            'price' => 100,
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

}
