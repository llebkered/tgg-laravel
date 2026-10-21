<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private function setupProductPage($stock = false)
    {
        Page::factory()->create([
            'title' => 'Products',
            'slug' => 'products',
        ]);

        Page::factory()->create([
            'title' => 'Cart',
            'slug' => 'cart',
        ]);


        // create products
        $product = Product::factory()->create([
            'title' => 'Product 1',
            'slug' => 'product-1',
            'code' => 'PROD1',
            'image' => 'https://via.placeholder.com/150',
            'description' => 'This is a test product',
            'published' => true,
            'stocked' => $stock,
        ]);

        if ($stock === true) {
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

            // dump($product->variations);
        }
    }


    public function test_products_load()
    {
        $this->withoutExceptionHandling();

        $this->setupProductPage(false);

        $response = $this->get('/products');

        // check that the products are loaded
        $response->assertSee('Product 1');

        $response->assertStatus(200);
    }

    public function test_product_link_directs_to_product_page()
    {
        // $this->withoutExceptionHandling();

        $this->setupProductPage(false);

        $response = $this->get('/product/product-1');

        // check that the product page is loaded
        $response->assertSee('Product 1');
        $response->assertSee('This is a test product');

        $response->assertStatus(200);
    }


    public function test_individual_product_page_displays_out_of_stock()
    {
        // $this->withoutExceptionHandling();

        $this->setupProductPage(false);

        $response = $this->get('/product/product-1');

        // check that the product page is loaded
        $response->assertSee('Product 1');
        $response->assertSee('This is a test product');
        $response->assertSee('Out of Stock');

        $response->assertStatus(200);
    }

    public function test_individual_product_page_displays_in_stock()
    {
        // $this->withoutExceptionHandling();

        $this->setupProductPage(true);

        $response = $this->get('/product/product-1');

        // check that the product page is loaded
        $response->assertSee('Product 1');
        $response->assertSee('This is a test product');
        $response->assertSee('Large Pack');
        // dump($response->getContent());

        $response->assertStatus(200);
    }

    public function test_product_can_be_placed_in_cart()
    {
        $this->withoutExceptionHandling();

        $this->setupProductPage(true);

        $response = $this->post('/cart', [
            'id' => '293ad',
            'name' => 'Product 1',
            'qty' => 1,
            'price' => 100,
        ]);

        // $response->dumpHeaders();
        // $response->dumpSession();
        // $response->dump();

        // assert that the product was added to the cart
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

    }
}
