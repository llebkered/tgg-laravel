<?php

namespace Tests\Feature\Http;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_migrations_create_the_admin_and_user_roles()
    {
        $this->assertSame(['admin', 'user'], Role::orderBy('id')->pluck('name')->all());
    }

    public function test_migration_leaves_existing_roles_alone()
    {
        // As on the live database, which already has Voyager's roles
        $admin = User::factory()->admin()->create();

        $migration = require database_path('migrations/2026_10_23_060000_add_roles_to_users.php');
        $migration->up();

        $this->assertSame(['admin', 'user'], Role::orderBy('id')->pluck('name')->all());
        $this->assertSame('admin', $admin->fresh()->role->name);
    }

    public function test_admin_can_open_the_admin()
    {
        $this->actingAs(User::factory()->admin()->create());

        $this->get('/backend')->assertOk();
        $this->get('/backend/orders')->assertOk();
    }

    public function test_signed_in_user_without_the_admin_role_is_turned_away()
    {
        $this->actingAs(User::factory()->create());

        $this->get('/backend')->assertRedirect('/');
    }

    public function test_signed_out_visitor_is_sent_to_login()
    {
        $this->get('/backend')->assertRedirect('/login');
    }

    public function test_role_cannot_be_set_by_mass_assignment()
    {
        $user = User::factory()->create();

        $user->update(['role_id' => Role::where('name', 'admin')->value('id')]);

        $this->assertNull($user->fresh()->role_id);
    }

    public function test_command_gives_a_user_admin_access()
    {
        $user = User::factory()->create(['email' => 'staff@example.com']);

        $this->artisan('user:admin', ['email' => 'staff@example.com'])
            ->expectsOutputToContain('can now use the admin')
            ->assertSuccessful();

        $this->assertSame('admin', $user->fresh()->role->name);
    }

    public function test_command_reports_an_unknown_email()
    {
        $this->artisan('user:admin', ['email' => 'nobody@example.com'])
            ->expectsOutputToContain('No user has the email address nobody@example.com.')
            ->assertFailed();
    }
}
