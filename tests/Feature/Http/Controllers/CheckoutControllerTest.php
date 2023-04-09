<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createCheckoutPage($stock = false)
    {
        Page::factory()->create([
            'title' => 'Checkout',
            'slug' => 'checkout',
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
        }
    }

    /**
     * @test
     */
    public function test_empty_cart_should_return_a_200_status_code()
    {
        $this->createCheckoutPage();
        $response = $this->get('/checkout');
        $response->assertSee('Checkout');
        $response->assertSee('Cart empty');
        $response->assertStatus(200);
    }


}
