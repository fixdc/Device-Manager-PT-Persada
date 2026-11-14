<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_categories_from_database(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = $this->createCategory('Komputer & Laptop', 'komputer-laptop');

        $this->actingAs($admin)
            ->get(route('admin.categories.index'))
            ->assertOk()
            ->assertSee('Komputer')
            ->assertSee($category->slug)
            ->assertSee('Kelola Kategori');
    }

    public function test_admin_can_add_a_category_with_an_automatically_generated_slug(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from(route('admin.categories.index'))
            ->post(route('admin.categories.store'), ['nama' => 'Printer & Scanner'])
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Kategori perangkat berhasil ditambahkan.');

        $this->assertDatabaseHas('device_categories', [
            'nama' => 'Printer & Scanner',
            'slug' => 'printer-scanner',
        ]);
    }

    public function test_category_name_is_required_and_message_is_clear(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->from(route('admin.categories.index'))
            ->post(route('admin.categories.store'), ['nama' => ''])
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHasErrors([
                'nama' => 'Nama kategori wajib diisi.',
            ]);

        $this->assertDatabaseCount('device_categories', 0);
    }

    public function test_generated_slug_must_be_unique(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->createCategory('Printer Scanner', 'printer-scanner');

        $this->actingAs($admin)
            ->from(route('admin.categories.index'))
            ->post(route('admin.categories.store'), ['nama' => 'Printer & Scanner'])
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHasErrors([
                'slug' => 'Nama kategori menghasilkan slug yang sudah digunakan. Pilih nama kategori lain.',
            ]);

        $this->assertDatabaseCount('device_categories', 1);
    }

    public function test_admin_can_edit_category_and_slug_is_regenerated(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = $this->createCategory('Komputer', 'komputer');

        $this->actingAs($admin)
            ->from(route('admin.categories.index'))
            ->put(route('admin.categories.update', $category), ['nama' => 'Komputer & Laptop'])
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Kategori perangkat berhasil diperbarui.');

        $this->assertDatabaseHas('device_categories', [
            'id' => $category->getKey(),
            'nama' => 'Komputer & Laptop',
            'slug' => 'komputer-laptop',
        ]);
    }

    public function test_category_can_keep_its_own_slug_when_edited(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = $this->createCategory('Printer & Scanner', 'printer-scanner');

        $this->actingAs($admin)
            ->put(route('admin.categories.update', $category), ['nama' => 'Printer & Scanner'])
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('device_categories', [
            'id' => $category->getKey(),
            'slug' => 'printer-scanner',
        ]);
    }

    public function test_admin_cannot_edit_category_to_a_slug_used_by_another_category(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->createCategory('Printer Scanner', 'printer-scanner');
        $category = $this->createCategory('Komputer', 'komputer');

        $this->actingAs($admin)
            ->from(route('admin.categories.index'))
            ->put(route('admin.categories.update', $category), ['nama' => 'Printer & Scanner'])
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHasErrors([
                'slug' => 'Nama kategori menghasilkan slug yang sudah digunakan. Pilih nama kategori lain.',
            ]);

        $this->assertDatabaseHas('device_categories', [
            'id' => $category->getKey(),
            'nama' => 'Komputer',
            'slug' => 'komputer',
        ]);
    }

    public function test_admin_can_delete_a_category_that_is_not_used_by_a_device(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = $this->createCategory('Kategori Kosong', 'kategori-kosong');

        $this->actingAs($admin)
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHas('success', 'Kategori perangkat berhasil dihapus.');

        $this->assertModelMissing($category);
    }

    public function test_category_in_use_by_a_device_cannot_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = $this->createCategory('Perangkat Jaringan', 'perangkat-jaringan');
        $this->createDevice($category);

        $this->actingAs($admin)
            ->from(route('admin.categories.index'))
            ->delete(route('admin.categories.destroy', $category))
            ->assertRedirect(route('admin.categories.index'))
            ->assertSessionHasErrors([
                'category' => 'Kategori tidak dapat dihapus karena masih digunakan oleh perangkat.',
            ]);

        $this->assertModelExists($category);
    }

    public function test_regular_user_cannot_access_category_crud_routes(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $category = $this->createCategory('Komputer', 'komputer');

        $this->actingAs($user)->get(route('admin.categories.index'))->assertForbidden();
        $this->post(route('admin.categories.store'), ['nama' => 'Baru'])->assertForbidden();
        $this->put(route('admin.categories.update', $category), ['nama' => 'Diubah'])->assertForbidden();
        $this->patch(route('admin.categories.update', $category), ['nama' => 'Diubah'])->assertForbidden();
        $this->delete(route('admin.categories.destroy', $category))->assertForbidden();

        $this->assertSame('Komputer', $category->fresh()->nama);
    }

    public function test_guest_cannot_access_category_crud_routes(): void
    {
        $category = $this->createCategory('Komputer', 'komputer');

        $this->get(route('admin.categories.index'))->assertRedirect(route('login'));
        $this->post(route('admin.categories.store'), ['nama' => 'Baru'])->assertRedirect(route('login'));
        $this->put(route('admin.categories.update', $category), ['nama' => 'Diubah'])->assertRedirect(route('login'));
        $this->delete(route('admin.categories.destroy', $category))->assertRedirect(route('login'));
    }

    private function createCategory(string $name, string $slug): DeviceCategory
    {
        return DeviceCategory::query()->create([
            'nama' => $name,
            'slug' => $slug,
        ]);
    }

    private function createDevice(DeviceCategory $category): Device
    {
        $owner = User::factory()->create(['role' => 'user']);
        $department = Department::query()->create([
            'nama' => 'IT',
            'lantai' => '1',
            'slug' => 'it-'.Str::uuid(),
        ]);

        return Device::query()->create([
            'kode_device' => 'DEV-'.Str::uuid(),
            'nama_device' => 'Perangkat Pengujian',
            'id_kategori' => $category->getKey(),
            'id_user' => $owner->getKey(),
            'id_departemen' => $department->getKey(),
        ]);
    }
}
