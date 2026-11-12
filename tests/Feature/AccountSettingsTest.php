<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class AccountSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_update_their_profile_without_changing_role_or_another_account(): void
    {
        $department = $this->createDepartment();
        $user = User::factory()->create(['email' => 'profile@example.com']);
        $otherUser = User::factory()->create();

        $this->actingAs($user)
            ->patchJson(route('account-settings.profile.update'), [
                'nama' => 'Updated Profile',
                'email' => 'UPDATED@example.com',
                'no_telp' => '08123456789',
                'id_departemen' => $department->id,
                'role' => 'admin',
            ])
            ->assertOk()
            ->assertJsonPath('message', 'Profil berhasil diperbarui.')
            ->assertJsonPath('user.nama', 'Updated Profile')
            ->assertJsonPath('user.email', 'updated@example.com')
            ->assertJsonPath('user.role', 'user')
            ->assertJsonPath('user.id_departemen', $department->id)
            ->assertJsonMissingPath('user.kata_sandi');

        $user->refresh();
        $this->assertSame('user', $user->role);
        $this->assertSame('08123456789', $user->no_telp);
        $this->assertSame($department->id, $user->id_departemen);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nama' => 'Updated Profile',
            'email' => 'updated@example.com',
            'no_telp' => '08123456789',
            'id_departemen' => $department->id,
        ]);
        $this->assertNotSame('Updated Profile', $otherUser->fresh()->nama);
    }

    public function test_account_settings_panels_follow_the_selected_tab(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSee("activeTab: 'profile'", false)
            ->assertSee("@click=\"selectTab('profile')\"", false)
            ->assertSee("@click=\"selectTab('notifications')\"", false)
            ->assertSee("@click=\"selectTab('security')\"", false)
            ->assertSee('<template x-if="activeTab === \'profile\'">', false)
            ->assertSee('<template x-if="activeTab === \'notifications\'">', false)
            ->assertSee('<template x-if="activeTab === \'security\'">', false);
    }

    public function test_profile_validation_rejects_nonexistent_department_and_duplicate_email(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $this->actingAs($user)
            ->patchJson(route('account-settings.profile.update'), [
                'nama' => 'Attempted Change',
                'email' => $otherUser->email,
                'id_departemen' => 99999,
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'id_departemen']);

        $this->assertNotSame('Attempted Change', $user->fresh()->nama);
        $this->assertNotSame('Attempted Change', $otherUser->fresh()->nama);
    }

    public function test_notification_preferences_are_saved_to_the_users_own_record(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherUser->preferences()->create([
            'ticket_updates' => true,
            'ticket_assignments' => false,
            'system_announcements' => true,
        ]);
        $preferences = [
            'ticket_updates' => false,
            'ticket_assignments' => true,
            'system_announcements' => false,
        ];

        $this->actingAs($user)
            ->patchJson(route('account-settings.notifications.update'), $preferences)
            ->assertOk()
            ->assertJsonPath('message', 'Preferensi notifikasi berhasil disimpan.')
            ->assertJsonPath('preferences.ticket_updates', false)
            ->assertJsonPath('preferences.ticket_assignments', true)
            ->assertJsonPath('preferences.system_announcements', false);

        $this->assertDatabaseHas('user_preferences', [
            'user_id' => $user->id,
            'ticket_updates' => 0,
            'ticket_assignments' => 1,
            'system_announcements' => 0,
        ]);
        $this->assertDatabaseHas('user_preferences', [
            'user_id' => $otherUser->id,
            'ticket_updates' => 1,
            'ticket_assignments' => 0,
            'system_announcements' => 1,
        ]);
    }

    public function test_password_changes_require_the_current_password_and_a_matching_strong_confirmation(): void
    {
        $user = User::factory()->create(['kata_sandi' => 'existing-password']);

        $this->actingAs($user)
            ->putJson(route('account-settings.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'New-password-123!',
                'password_confirmation' => 'New-password-123!',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('current_password');

        $this->assertTrue(Hash::check('existing-password', $user->fresh()->kata_sandi));

        $this->putJson(route('account-settings.password.update'), [
            'current_password' => 'existing-password',
            'password' => 'New-password-123!',
            'password_confirmation' => 'does-not-match',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('password');

        $this->putJson(route('account-settings.password.update'), [
            'current_password' => 'existing-password',
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('password');

        $this->assertTrue(Hash::check('existing-password', $user->fresh()->kata_sandi));
    }

    public function test_password_change_stores_a_hash_in_kata_sandi_and_preserves_login(): void
    {
        $user = User::factory()->create(['kata_sandi' => 'existing-password']);
        $this->actingAs($user)->get(route('dashboard'))->assertOk();

        $this->putJson(route('account-settings.password.update'), [
            'current_password' => 'existing-password',
            'password' => 'New-password-123!',
            'password_confirmation' => 'New-password-123!',
        ])
            ->assertOk()
            ->assertJsonPath('message', 'Kata sandi berhasil diperbarui.')
            ->assertJsonMissingPath('password');

        $this->assertTrue(Hash::check('New-password-123!', $user->fresh()->kata_sandi));
        $this->assertAuthenticatedAs($user);
        $this->get(route('dashboard'))->assertOk();
    }

    public function test_user_can_sign_out_other_devices_after_confirming_their_password(): void
    {
        $user = User::factory()->create(['kata_sandi' => 'existing-password']);
        $this->actingAs($user)->get(route('dashboard'))->assertOk();

        $this->postJson(route('account-settings.sessions.destroy-others'), [
            'current_password' => 'existing-password',
        ])
            ->assertOk()
            ->assertJsonMissingPath('current_password');

        $this->assertAuthenticatedAs($user);
    }

    public function test_session_listing_does_not_expose_session_identifiers(): void
    {
        $user = User::factory()->create();
        $sessionId = 'private-session-identifier';
        $sessionTable = config('session.table');

        DB::table($sessionTable)->insert([
            'id' => $sessionId,
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36',
            'payload' => 'session-payload',
            'last_activity' => now()->timestamp,
        ]);

        config(['session.driver' => 'database']);

        $response = $this->actingAs($user)->getJson(route('account-settings.sessions.index'));

        $response->assertOk()
            ->assertJsonPath('supported', true)
            ->assertJsonMissingPath('sessions.0.id')
            ->assertJsonPath('sessions.0.browser', 'Google Chrome')
            ->assertJsonPath('sessions.0.device', 'Desktop · Windows');

        $this->assertStringNotContainsString($sessionId, $response->getContent());
    }

    private function createDepartment(): Department
    {
        return Department::query()->create([
            'nama' => 'Profile Department',
            'slug' => Str::slug('Profile Department').'-'.Str::lower(Str::random(8)),
        ]);
    }
}
