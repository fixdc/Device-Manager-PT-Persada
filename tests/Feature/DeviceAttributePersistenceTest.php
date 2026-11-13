<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceAttributePersistenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_brand_model_and_acquisition_date_persist_and_are_returned_for_detail_and_edit(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = DeviceCategory::query()->create(['nama' => 'Laptop / Komputer', 'slug' => 'laptop-komputer']);
        $department = Department::query()->create([
            'nama' => 'PPDB',
            'lantai' => 'Lantai 6',
            'slug' => 'ppdb-lantai-6',
        ]);

        Device::query()->create([
            'kode_device' => 'SEED-DEVICE-001',
            'nama_device' => 'Perangkat Sebelumnya',
            'id_kategori' => $category->id,
            'id_departemen' => $department->id,
            'status' => 'aktif',
        ]);

        $this->actingAs($admin);
        $created = $this->postJson(route('admin.device.store'), [
            'kode_device' => 'LAP-PTAMS-001',
            'nama_device' => 'Laptop Lenovo ThinkPad E14',
            'id_kategori' => $category->id,
            'merek' => 'Lenovo',
            'model' => 'ThinkPad E14',
            'tanggal_pengadaan' => '2024-10-12',
            'nomor_seri' => 'DEMO-PTAMS-PPDB-001',
            'id_departemen' => $department->id,
            'status' => 'aktif',
        ])->assertCreated()
            ->assertJsonPath('device.merek', 'Lenovo')
            ->assertJsonPath('device.model', 'ThinkPad E14')
            ->assertJsonPath('device.tanggal_raw', '2024-10-12')
            ->assertJsonPath('device.lokasi', 'PPDB — Lantai 6');

        $deviceId = $created->json('device.id');
        $this->assertSame(2, $deviceId, 'Tes edit harus menargetkan perangkat dengan ID 2.');
        $this->assertDatabaseHas('devices', [
            'id' => $deviceId,
            'merek' => 'Lenovo',
            'model' => 'ThinkPad E14',
            'tanggal_pengadaan' => '2024-10-12 00:00:00',
            'id_departemen' => $department->id,
        ]);

        $this->get(route('admin.device.index'))
            ->assertOk()
            ->assertSee('Lenovo', false)
            ->assertSee('ThinkPad E14', false)
            ->assertSee('2024-10-12', false)
            ->assertSee('merek: device.merek', false)
            ->assertSee('model: device.model', false)
            ->assertSee('tanggal_pengadaan: device.tanggal_raw', false)
            ->assertSee('id="device-merek" name="merek"', false)
            ->assertSee('id="device-model" name="model"', false)
            ->assertSee('id="device-tanggal-pengadaan" name="tanggal_pengadaan"', false)
            ->assertSee('body: JSON.stringify(payload)', false);

        $updated = $this->putJson('/admin/device/2', [
            'id' => 2,
            'kode_device' => 'LAP-PTAMS-001',
            'nama_device' => 'Laptop Lenovo ThinkPad E14 Gen 2',
            'id_kategori' => $category->id,
            'merek' => 'Lenovo',
            'model' => 'ThinkPad E14 Gen 5',
            'tanggal_pengadaan' => '2026-11-13',
            'nomor_seri' => 'DEMO-PTAMS-PPDB-001',
            'id_departemen' => $department->id,
            'status' => 'aktif',
        ])->assertOk()
            ->assertJsonPath('device.merek', 'Lenovo')
            ->assertJsonPath('device.model', 'ThinkPad E14 Gen 5')
            ->assertJsonPath('device.tanggal_raw', '2026-11-13');

        $this->assertDatabaseHas('devices', [
            'id' => $deviceId,
            'merek' => 'Lenovo',
            'model' => 'ThinkPad E14 Gen 5',
            'tanggal_pengadaan' => '2026-11-13 00:00:00',
        ]);

        $freshDevice = Device::query()->findOrFail($deviceId)->fresh();
        $this->assertSame('Lenovo', $freshDevice->merek);
        $this->assertSame('ThinkPad E14 Gen 5', $freshDevice->model);
        $this->assertSame('2026-11-13', $freshDevice->tanggal_pengadaan->format('Y-m-d'));

        Device::saving(function (Device $device) {
            return $device->getKey() === 2 ? false : null;
        });

        $this->putJson('/admin/device/2', [
            'id' => 2,
            'kode_device' => 'LAP-PTAMS-001',
            'nama_device' => 'Laptop Lenovo ThinkPad E14 Gen 2',
            'id_kategori' => $category->id,
            'merek' => 'Lenovo',
            'model' => 'ThinkPad E14 Gen 5',
            'tanggal_pengadaan' => '2026-11-13',
            'nomor_seri' => 'DEMO-PTAMS-PPDB-001',
            'id_departemen' => $department->id,
            'status' => 'aktif',
        ])->assertInternalServerError()
            ->assertDontSee('Perubahan perangkat berhasil disimpan.');

        $this->assertDatabaseHas('devices', [
            'id' => 2,
            'merek' => 'Lenovo',
            'model' => 'ThinkPad E14 Gen 5',
            'tanggal_pengadaan' => '2026-11-13 00:00:00',
        ]);
    }
}
