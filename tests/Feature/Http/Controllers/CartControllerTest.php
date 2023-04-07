<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *  @test
     */
    public function test_cart_page_loads()
    {

        //$this->withoutExceptionHandling();

        Page::factory()->create([
            'title' => 'Cart',
            'slug' => 'cart',
        ]);

        $response = $this->get('/cart');

        $response->assertStatus(200);
    }
}
