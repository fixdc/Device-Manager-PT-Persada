<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_user_with_official_columns_and_a_hashed_password(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment();

        $this->actingAs($admin)
            ->postJson(route('admin.users.store'), [
                'nama' => 'Test Account',
                'email' => 'new-user@example.com',
                'role' => 'user',
                'id_departemen' => $department->id,
                'no_telp' => '08123456789',
                'kata_sandi' => 'Strong-password-123!',
                'kata_sandi_confirmation' => 'Strong-password-123!',
            ])
            ->assertCreated()
            ->assertJsonPath('user.role', 'user')
            ->assertJsonPath('user.nama', 'Test Account')
            ->assertJsonPath('user.id_departemen', $department->id)
            ->assertJsonMissingPath('user.kata_sandi');

        $user = User::query()->where('email', 'new-user@example.com')->firstOrFail();
        $this->assertTrue(Hash::check('Strong-password-123!', $user->kata_sandi));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'nama' => 'Test Account',
            'id_departemen' => $department->id,
        ]);
    }

    public function test_admin_can_update_user_details_and_leave_password_unchanged(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $department = $this->createDepartment('Operasional');
        $user = User::factory()->create([
            'role' => 'user',
            'kata_sandi' => 'existing-password',
        ]);

        $this->actingAs($admin)
            ->putJson(route('admin.users.update', $user), [
                'nama' => 'Updated Account',
                'email' => $user->email,
                'role' => 'user',
                'id_departemen' => $department->id,
                'no_telp' => '08129876543',
                'kata_sandi' => '',
                'kata_sandi_confirmation' => '',
            ])
            ->assertOk()
            ->assertJsonPath('user.nama', 'Updated Account')
            ->assertJsonPath('user.departemen_nama', 'Operasional')
            ->assertJsonMissingPath('user.kata_sandi');

        $user->refresh();
        $this->assertSame('08129876543', $user->no_telp);
        $this->assertSame($department->id, $user->id_departemen);
        $this->assertTrue(Hash::check('existing-password', $user->kata_sandi));
    }

    public function test_duplicate_email_addresses_are_rejected_when_creating_or_updating(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $existing = User::factory()->create();
        $target = User::factory()->create();

        $this->actingAs($admin)
            ->postJson(route('admin.users.store'), [
                'nama' => 'Duplicate Account',
                'email' => $existing->email,
                'role' => 'user',
                'kata_sandi' => 'Strong-password-123!',
                'kata_sandi_confirmation' => 'Strong-password-123!',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('email');

        $this->putJson(route('admin.users.update', $target), [
            'nama' => $target->nama,
            'email' => $existing->email,
            'role' => $target->role,
        ])->assertUnprocessable()
            ->assertJsonValidationErrors('email');

        $this->assertSame($target->email, $target->fresh()->email);
    }

    public function test_department_must_exist_and_can_be_omitted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $payload = [
            'nama' => 'Department Test',
            'email' => 'department-test@example.com',
            'role' => 'user',
            'kata_sandi' => 'Strong-password-123!',
            'kata_sandi_confirmation' => 'Strong-password-123!',
        ];

        $this->actingAs($admin)
            ->postJson(route('admin.users.store'), [...$payload, 'id_departemen' => 99999])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('id_departemen');

        $this->postJson(route('admin.users.store'), $payload)->assertCreated();
        $this->assertDatabaseHas('users', [
            'email' => $payload['email'],
            'id_departemen' => null,
        ]);
    }

    public function test_only_official_roles_can_be_assigned(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->postJson(route('admin.users.store'), [
                'nama' => 'Unsupported Role',
                'email' => 'unsupported-role@example.com',
                'role' => 'operator',
                'kata_sandi' => 'Strong-password-123!',
                'kata_sandi_confirmation' => 'Strong-password-123!',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('role');

        $this->assertDatabaseMissing('users', ['email' => 'unsupported-role@example.com']);
    }

    public function test_admin_listing_searches_department_and_paginates_database_results(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        User::factory(11)->create(['role' => 'user']);

        $department = $this->createDepartment('Searchable Department');

        $target = User::factory()->create([
            'nama' => 'Find This Account',
            'id_departemen' => $department->id,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.users.index', [
                'search' => 'Searchable Department',
                'role' => 'user',
            ]))
            ->assertOk()
            ->assertSee($target->nama);

        $response->assertViewHas('users', function ($users) use ($admin, $target): bool {
            $userIds = collect($users->items())->pluck('id');

            return $users->total() === 1
                && $userIds->contains($target->id)
                && ! $userIds->contains($admin->id);
        });

        $this->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee('page=2');
    }

    public function test_non_admins_cannot_access_user_management_routes(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $target = User::factory()->create();

        $this->actingAs($user)->get(route('admin.users.index'))->assertForbidden();
        $this->postJson(route('admin.users.store'), [])->assertForbidden();
        $this->putJson(route('admin.users.update', $target), [])->assertForbidden();
        $this->deleteJson(route('admin.users.destroy', $target))->assertForbidden();
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->deleteJson(route('admin.users.destroy', $admin))
            ->assertForbidden();

        $this->assertDatabaseHas('users', ['id' => $admin->id, 'role' => 'admin']);
    }

    public function test_last_administrator_cannot_be_demoted_or_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->putJson(route('admin.users.update', $admin), [
                'nama' => $admin->nama,
                'email' => $admin->email,
                'role' => 'user',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('role');

        $otherAdmin = User::factory()->create(['role' => 'admin']);
        $this->deleteJson(route('admin.users.destroy', $otherAdmin))
            ->assertOk();

        $this->assertDatabaseHas('users', ['id' => $admin->id, 'role' => 'admin']);
    }

    public function test_admin_can_permanently_delete_another_user(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($admin)
            ->deleteJson(route('admin.users.destroy', $user))
            ->assertOk()
            ->assertJsonPath('user.id', $user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_password_is_validated_when_creating_users(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->postJson(route('admin.users.store'), [
                'nama' => 'Weak Password',
                'email' => 'weak-password@example.com',
                'role' => 'user',
                'kata_sandi' => 'weak',
                'kata_sandi_confirmation' => 'weak',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('kata_sandi');

        $this->assertDatabaseMissing('users', ['email' => 'weak-password@example.com']);
    }

    private function createDepartment(string $nama = 'Teknik'): Department
    {
        return Department::query()->create([
            'nama' => $nama,
            'slug' => Str::slug($nama).'-'.Str::lower(Str::random(8)),
        ]);
    }
}
