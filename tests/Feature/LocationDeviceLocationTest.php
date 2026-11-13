<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class LocationDeviceLocationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_edit_locations_with_department_and_floor(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)
            ->postJson(route('admin.location.store'), ['nama' => 'PPDB', 'lantai' => 'Lantai 6'])
            ->assertCreated()
            ->assertJsonPath('location.label', 'PPDB — Lantai 6');

        $location = Department::query()->firstOrFail();
        $this->assertSame('ppdb-lantai-6', $location->slug);

        $this->putJson(route('admin.location.update', $location), ['nama' => 'PPDB', 'lantai' => 'Lantai 7'])
            ->assertOk()
            ->assertJsonPath('location.label', 'PPDB — Lantai 7');
    }

    public function test_same_department_name_on_different_floors_gets_unique_slugs(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->postJson(route('admin.location.store'), ['nama' => 'PPDB', 'lantai' => 'Lantai 6'])->assertCreated();
        $this->postJson(route('admin.location.store'), ['nama' => 'PPDB', 'lantai' => 'Lantai 7'])->assertCreated();

        $this->assertDatabaseCount('departments', 2);
        $this->assertDatabaseHas('departments', ['nama' => 'PPDB', 'lantai' => 'Lantai 6', 'slug' => 'ppdb-lantai-6']);
        $this->assertDatabaseHas('departments', ['nama' => 'PPDB', 'lantai' => 'Lantai 7', 'slug' => 'ppdb-lantai-7']);
    }

    public function test_location_page_shows_combined_label_and_device_count(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $location = $this->createLocation('PPDB', 'Lantai 6');
        $category = DeviceCategory::query()->create(['nama' => 'Laptop', 'slug' => 'laptop']);
        Device::query()->create([
            'kode_device' => 'LAP-001', 'nama_device' => 'Laptop 1', 'id_kategori' => $category->id,
            'id_departemen' => $location->id, 'status' => 'aktif',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.location.index'));
        $response->assertOk()
            ->assertSee('PPDB — Lantai 6')
            ->assertSee('\\u0022devices_count\\u0022:1', false);
    }

    public function test_location_in_use_by_a_device_cannot_be_deleted(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $location = $this->createLocation();
        $category = DeviceCategory::query()->create(['nama' => 'Laptop', 'slug' => 'laptop']);
        Device::query()->create([
            'kode_device' => 'LAP-002', 'nama_device' => 'Laptop 2', 'id_kategori' => $category->id,
            'id_departemen' => $location->id, 'status' => 'aktif',
        ]);

        $this->actingAs($admin)->deleteJson(route('admin.location.destroy', $location))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('location');
    }

    public function test_device_form_uses_category_and_combined_location_options(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        DeviceCategory::query()->create(['nama' => 'Laptop', 'slug' => 'laptop']);
        $this->createLocation('PPDB', 'Lantai 6');

        $this->actingAs($admin)->get(route('admin.device.index'))
            ->assertOk()
            ->assertSee('Laptop')
            ->assertSee('PPDB — Lantai 6');
    }

    public function test_device_create_and_edit_store_location_in_id_departemen(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = DeviceCategory::query()->create(['nama' => 'Laptop', 'slug' => 'laptop']);
        $firstLocation = $this->createLocation('PPDB', 'Lantai 6');
        $nextLocation = $this->createLocation('PPDB', 'Lantai 7');
        $this->actingAs($admin);

        $response = $this->postJson(route('admin.device.store'), [
            'kode_device' => 'LAP-003', 'nama_device' => 'Laptop 3', 'id_kategori' => $category->id,
            'id_departemen' => $firstLocation->id, 'status' => 'aktif',
        ])->assertCreated()->assertJsonPath('device.lokasi', 'PPDB — Lantai 6');
        $deviceId = $response->json('device.id');
        $this->assertDatabaseHas('devices', ['id' => $deviceId, 'id_departemen' => $firstLocation->id]);

        $this->putJson(route('admin.device.update', $deviceId), [
            'kode_device' => 'LAP-003', 'nama_device' => 'Laptop 3 Diperbarui', 'id_kategori' => $category->id,
            'id_departemen' => $nextLocation->id, 'status' => 'aktif',
        ])->assertOk()->assertJsonPath('device.lokasi', 'PPDB — Lantai 7');

        $this->assertDatabaseHas('devices', [
            'id' => $deviceId, 'nama_device' => 'Laptop 3 Diperbarui', 'id_departemen' => $nextLocation->id,
        ]);
    }

    public function test_device_rejects_unknown_category_and_location_ids(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->postJson(route('admin.device.store'), [
            'kode_device' => 'LAP-004', 'nama_device' => 'Laptop 4', 'id_kategori' => 999,
            'id_departemen' => 999, 'status' => 'aktif',
        ])->assertUnprocessable()->assertJsonValidationErrors(['id_kategori', 'id_departemen']);
    }

    public function test_regular_users_cannot_access_location_and_device_admin_pages(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->get(route('admin.location.index'))->assertForbidden();
        $this->get(route('admin.device.index'))->assertForbidden();
    }

    private function createLocation(string $nama = 'Teknik', string $lantai = 'Lantai 1'): Department
    {
        return Department::query()->create([
            'nama' => $nama,
            'lantai' => $lantai,
            'slug' => Str::slug($nama.' '.$lantai),
        ]);
    }
}
