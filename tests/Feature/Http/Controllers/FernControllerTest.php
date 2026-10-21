<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FernControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */

    public function test_can_see_ferns_page()
    {
        // $this->withoutExceptionHandling();

        // create a page for ferns and insert it into the test database
        $page = Page::factory()->create([
            'title' => 'Ferns',
            'slug' => 'ferns',
        ]);
        $page->save();

        $response = $this->get('/ferns');

        $response->assertStatus(200);
        $response->assertViewIs('ferns');
        $response->assertViewHas('ferns');
    }

    public function test_ferns_page_is_not_found_without_its_page_content()
    {
        $response = $this->get('/ferns');

        $response->assertNotFound();
    }
}
