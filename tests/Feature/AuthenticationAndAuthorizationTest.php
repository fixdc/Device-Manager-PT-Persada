<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationAndAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_log_in_using_the_kata_sandi_column_and_session_is_regenerated(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
            'kata_sandi' => 'secure-password',
        ]);
        $sessionId = $this->app['session.store']->getId();

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'secure-password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
        $this->assertNotSame($sessionId, $this->app['session.store']->getId());
        $this->get(route('admin.dashboard'))->assertOk();
    }

    public function test_user_can_log_in_and_is_redirected_to_the_user_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => 'user',
            'kata_sandi' => 'secure-password',
        ]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'secure-password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->get(route('dashboard'))->assertOk();
    }

    public function test_invalid_credentials_are_rejected_without_logging_in(): void
    {
        $user = User::factory()->create(['kata_sandi' => 'secure-password']);

        $this->from(route('login'))
            ->post(route('login.store'), [
                'email' => $user->email,
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_attempts_are_limited_per_email_and_ip(): void
    {
        $user = User::factory()->create(['kata_sandi' => 'secure-password']);
        $credentials = [
            'email' => $user->email,
            'password' => 'wrong-password',
        ];

        foreach (range(1, 5) as $attempt) {
            $this->post(route('login.store'), $credentials)->assertSessionHasErrors('email');
        }

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'secure-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_logout_invalidates_the_session_and_rotates_the_csrf_token(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->get(route('dashboard'))->assertOk();
        $sessionId = $this->app['session.store']->getId();
        $csrfToken = $this->app['session.store']->token();

        $this->post(route('logout'))->assertRedirect(route('login'));

        $this->assertGuest();
        $this->assertNotSame($sessionId, $this->app['session.store']->getId());
        $this->assertNotSame($csrfToken, $this->app['session.store']->token());
        $this->get(route('dashboard'))->assertRedirect(route('login'));
    }

    public function test_logout_is_not_available_over_get(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('logout'))
            ->assertStatus(405);
    }

    public function test_guests_cannot_open_protected_dashboards(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_only_admins_can_open_administrative_pages(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();

        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
        $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
    }

    public function test_admins_cannot_open_user_only_dashboards(): void
    {
        $this->actingAs(User::factory()->create(['role' => 'admin']))
            ->get(route('dashboard'))
            ->assertForbidden();
    }
}
