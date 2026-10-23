<?php

namespace Tests\Feature\Http;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads()
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertViewIs('auth.login');
        $response->assertSee(route('password.request'));
    }

    public function test_user_can_login_and_is_sent_to_the_backend()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/backend');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_shows_errors_for_wrong_password()
    {
        $user = User::factory()->create();

        $response = $this->from('/login')->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->get('/login')->assertSee('These credentials do not match our records.');
    }

    public function test_signed_out_admin_page_goes_to_login_and_back_after_signing_in()
    {
        $user = User::factory()->create();

        $this->get('/backend/orders')->assertRedirect('/login');

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertRedirect('/backend/orders');
    }

    public function test_old_admin_login_address_redirects_to_login()
    {
        $this->get('/backend/login')->assertRedirect('/login');
    }

    public function test_user_can_log_out()
    {
        $this->actingAs(User::factory()->create());

        $this->post('/logout')->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_repeated_wrong_passwords_are_slowed_down()
    {
        $user = User::factory()->create();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', ['email' => $user->email, 'password' => 'wrong-password']);
        }

        $this->post('/login', ['email' => $user->email, 'password' => 'password'])
            ->assertStatus(429);
        $this->assertGuest();
    }

    public function test_logged_in_user_visiting_login_is_sent_to_the_backend()
    {
        $this->actingAs(User::factory()->create());

        $this->get('/login')->assertRedirect('/backend');
    }

    public function test_forgot_password_page_loads()
    {
        $response = $this->get('/forgot-password');

        $response->assertOk();
        $response->assertViewIs('auth.forgot-password');
    }

    public function test_reset_link_can_be_requested()
    {
        Notification::fake();
        $user = User::factory()->create();

        $response = $this->from('/forgot-password')->post('/forgot-password', ['email' => $user->email]);

        $response->assertRedirect('/forgot-password');
        $response->assertSessionHas('status');
        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_password_can_be_reset_with_the_emailed_link()
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $this->get('/reset-password/'.$notification->token.'?email='.urlencode($user->email))
                ->assertOk()
                ->assertViewIs('auth.reset-password')
                ->assertSee($notification->token);

            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'new-password-123',
                'password_confirmation' => 'new-password-123',
            ]);

            $response->assertRedirect('/login');
            $response->assertSessionHasNoErrors();

            return true;
        });

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
    }
}
