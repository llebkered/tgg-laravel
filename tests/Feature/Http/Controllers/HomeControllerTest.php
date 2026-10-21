<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use App\Models\Block;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     *  @test
     */
    public function test_home_page_loads()
    {

        // $this->withoutExceptionHandling();
        $this->createPage();

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_home_page_loads_without_a_published_hero()
    {
        Block::factory()->create([
            'hero' => true,
            'published' => false,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    private function createPage()
    {
        // create a page for ferns and insert it into the test database
        Page::factory()->create([
            'title' => 'Home',
            'slug' => '/',
        ]);

        // hero section
        Block::factory()->create([
            'hero' => true,
            'published' => true,
        ]);

        // block section
        // create 3 blocks that not hero and published
        Block::factory()
            ->times(5)
            ->create(['hero' => false, 'published' => true]);
    }
}
