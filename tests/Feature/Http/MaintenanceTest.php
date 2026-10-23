<?php

namespace Tests\Feature\Http;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Page::factory()->create(['title' => 'Home', 'slug' => '/']);
    }

    public function test_site_is_open_when_maintenance_is_off()
    {
        $this->get('/')->assertOk()->assertDontSee('Back Soon');
    }

    public function test_visitors_see_the_maintenance_page()
    {
        option(['maintenance' => true]);

        $this->get('/')
            ->assertStatus(503)
            ->assertHeader('Retry-After', 3600)
            ->assertSee('Back Soon');
        $this->get('/cart')->assertStatus(503);
        $this->post('/cart', ['id' => 1])->assertStatus(503);
    }

    public function test_signed_in_user_without_the_admin_role_sees_the_maintenance_page()
    {
        option(['maintenance' => true]);
        $this->actingAs(User::factory()->create());

        $this->get('/')->assertStatus(503);
    }

    public function test_admin_sees_the_site_with_a_reminder()
    {
        option(['maintenance' => true]);
        $this->actingAs(User::factory()->admin()->create());

        $this->get('/')->assertOk()->assertSee('Maintenance is on');
    }

    public function test_login_and_password_reset_stay_open()
    {
        option(['maintenance' => true]);

        $this->get('/login')->assertOk();
        $this->get('/forgot-password')->assertOk();
        $this->get('/backend')->assertRedirect('/login');
    }

    public function test_admin_can_turn_maintenance_on_and_off()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get('/backend')->assertOk()->assertSee('Turn maintenance on');

        $this->from('/backend')->post('/backend/maintenance', ['on' => 1])->assertRedirect('/backend');
        $this->assertTrue(option('maintenance'));
        $this->get('/backend')->assertSee('Turn maintenance off');

        // Sent twice, as from a double click, it stays on
        $this->post('/backend/maintenance', ['on' => 1]);
        $this->assertTrue(option('maintenance'));

        $this->post('/backend/maintenance', ['on' => 0]);
        $this->assertFalse(option('maintenance'));
    }

    public function test_only_admins_can_turn_maintenance_on()
    {
        $this->post('/backend/maintenance', ['on' => 1])->assertRedirect('/login');

        $this->actingAs(User::factory()->create());
        $this->post('/backend/maintenance', ['on' => 1])->assertRedirect('/');

        $this->assertNull(option('maintenance'));
    }
}
