<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;
use App\Models\Page;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class ContactControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     *  @test
     */
    public function test_contact_us_page_loads()
    {

        $this->withoutExceptionHandling();

        // Page::factory()->create([
        //     'title' => 'Get In Touch',
        //     'slug' => 'get-in-touch',
        // ]);

        // $response = $this->get('/get-in-touch');
        Page::factory()->create([
            'title' => 'Get In Touch',
            'slug' => 'contact-us',
        ]);

        $response = $this->get('/get-in-touch');

        $response->assertStatus(200);
    }
}
