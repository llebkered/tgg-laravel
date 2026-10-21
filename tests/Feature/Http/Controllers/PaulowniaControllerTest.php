<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaulowniaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_paulownia_page_loads()
    {

        // $this->withoutExceptionHandling();
        Page::factory()->create([
            'title' => 'Paulownia',
            'slug' => 'paulownia',
        ]);

        $response = $this->get('/paulownia');

        $response->assertStatus(200);
    }
}
