<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     *  @test
     */
    public function test_products_page_loads()
    {

        // $this->withoutExceptionHandling();
        Page::factory()->create([
            'title' => 'Products',
            'slug' => 'products',
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
    }
}
