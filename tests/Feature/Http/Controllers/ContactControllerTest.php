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

        // $this->withoutExceptionHandling();

        Page::factory()->create([
            'title' => 'Get In Touch',
            'slug' => 'contact-us',
        ]);

        $response = $this->get('/get-in-touch');

        $response->assertStatus(200);
    }

    /**
     *  @test
     *
     */
    public function test_contact_us_can_send_message()
    {
        // $this->withoutExceptionHandling();

        $response = $this->post('/get-in-touch', [
            'name' => 'John Doe',
            'email' => 'test@test.test',
            'phone' => '1234567890',
            'subject' => 'This is a test subject',
            'message' => 'This is a test message',
            'g-recaptcha-response' => '03AGdBq',
        ]);

        // assert that the message was sent
        $response->assertStatus(302);
        $response->assertSessionHas('success_message');
        $response->assertRedirect('/');

    }
}
