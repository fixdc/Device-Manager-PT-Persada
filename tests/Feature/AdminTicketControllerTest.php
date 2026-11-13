<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\RepairHistory;
use App\Models\Ticket;
use App\Models\TicketImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminTicketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_all_database_tickets_and_their_details_link_to_real_ids(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create(), [
            'kode_ticket' => 'TKT-ADMIN-001',
            'judul' => 'Keyboard perlu diperiksa',
        ]);
        $otherTicket = $this->createTicket(User::factory()->create(), [
            'kode_ticket' => 'TKT-ADMIN-002',
            'judul' => 'Perangkat milik pengguna lain',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.tickets.index'))
            ->assertOk()
            ->assertSee('TKT-ADMIN-001')
            ->assertSee($otherTicket->kode_ticket)
            ->assertSee('Keyboard Pengujian')
            ->assertSee('Keyboard perlu diperiksa')
            ->assertSee($ticket->reporter->nama)
            ->assertSee(route('admin.tickets.show', $ticket));
    }

    public function test_admin_can_search_by_ticket_code_subject_device_and_reporter(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $reporter = User::factory()->create(['nama' => 'Pelapor Khusus']);
        $ticket = $this->createTicket($reporter, [
            'kode_ticket' => 'TKT-SEARCH-001',
            'judul' => 'Layar perlu diperbaiki',
        ]);
        $this->createTicket(User::factory()->create(), [
            'kode_ticket' => 'TKT-OTHER-002',
            'judul' => 'Tiket lain',
        ], 'Mouse Pengujian');

        foreach (['TKT-SEARCH-001', 'Layar perlu diperbaiki', 'Keyboard Pengujian', 'Pelapor Khusus'] as $term) {
            $this->actingAs($admin)
                ->get(route('admin.tickets.index', ['search' => $term]))
                ->assertOk()
                ->assertSee($ticket->kode_ticket)
                ->assertDontSee('TKT-OTHER-002');
        }
    }

    public function test_admin_can_filter_tickets_by_priority_and_date_range(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $urgent = $this->createTicket(User::factory()->create(), [
            'kode_ticket' => 'TKT-HIGH-001',
            'prioritas' => 'tinggi',
            'tanggal' => '2026-02-10 10:00:00',
        ]);
        $this->createTicket(User::factory()->create(), [
            'kode_ticket' => 'TKT-LOW-001',
            'prioritas' => 'rendah',
            'tanggal' => '2026-02-11 10:00:00',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.tickets.index', [
            'priority' => 'tinggi',
            'date_from' => '2026-02-10',
            'date_to' => '2026-02-10',
        ]))->assertOk()->assertSee($urgent->kode_ticket)->assertDontSee('TKT-LOW-001');

        $this->assertSame(1, $response->viewData('tickets')->total());
    }

    public function test_admin_ticket_list_uses_database_pagination(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $tickets = [];

        for ($number = 1; $number <= 11; $number++) {
            $tickets[] = $this->createTicket(User::factory()->create(), [
                'kode_ticket' => sprintf('TKT-ADMIN-PAGE-%02d', $number),
                'tanggal' => now()->addSeconds($number),
            ]);
        }

        $this->actingAs($admin)
            ->get(route('admin.tickets.index'))
            ->assertOk()
            ->assertSee('TKT-ADMIN-PAGE-11')
            ->assertDontSee('TKT-ADMIN-PAGE-01')
            ->assertSee('page=2');

        $this->get(route('admin.tickets.index', ['page' => 2]))
            ->assertOk()
            ->assertSee('TKT-ADMIN-PAGE-01')
            ->assertDontSee('TKT-ADMIN-PAGE-11');
    }

    public function test_admin_can_open_the_ticket_detail_selected_from_the_list(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create(), [
            'kode_ticket' => 'TKT-DETAIL-REAL',
            'judul' => 'Monitor tidak menyala',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.tickets.show', $ticket))
            ->assertOk()
            ->assertSee('TKT-DETAIL-REAL')
            ->assertSee('Monitor tidak menyala')
            ->assertSee('Keyboard Pengujian')
            ->assertSee($ticket->reporter->nama);
    }

    public function test_admin_who_approves_an_open_ticket_becomes_its_technician(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create());

        $this->actingAs($admin)
            ->patch(route('admin.tickets.update', $ticket), ['status' => 'confirmed'])
            ->assertRedirect(route('admin.tickets.show', $ticket))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->getKey(),
            'status' => 'confirmed',
            'id_teknisi' => $admin->getKey(),
            'catatan' => null,
        ]);
        $this->assertDatabaseMissing('repair_histories', ['id_ticket' => $ticket->getKey()]);

        $this->actingAs($admin)
            ->get(route('admin.tickets.show', $ticket))
            ->assertOk()
            ->assertSee($admin->nama)
            ->assertSee('Admin Penanggung Jawab')
            ->assertDontSee('Simpan Penugasan');
    }

    public function test_another_admin_does_not_replace_the_approver_while_updating_the_ticket(): void
    {
        $approvingAdmin = User::factory()->create(['role' => 'admin']);
        $handlingAdmin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create());

        $this->actingAs($approvingAdmin)->patch(route('admin.tickets.update', $ticket), [
            'status' => 'confirmed',
        ])->assertRedirect(route('admin.tickets.show', $ticket));

        $this->actingAs($handlingAdmin)->patch(route('admin.tickets.update', $ticket), [
            'status' => 'confirmed',
        ])->assertRedirect(route('admin.tickets.show', $ticket));

        $this->actingAs($handlingAdmin)->patch(route('admin.tickets.update', $ticket), [
            'status' => 'process',
        ])->assertRedirect(route('admin.tickets.show', $ticket));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->getKey(),
            'status' => 'process',
            'id_teknisi' => $approvingAdmin->getKey(),
            'catatan' => null,
        ]);
        $this->assertDatabaseMissing('repair_histories', ['id_ticket' => $ticket->getKey()]);

        $this->actingAs($handlingAdmin)
            ->get(route('admin.tickets.show', $ticket))
            ->assertOk()
            ->assertSee($approvingAdmin->nama)
            ->assertSee('Admin Penanggung Jawab')
            ->assertDontSee('Simpan Penugasan');
    }

    public function test_regular_user_cannot_approve_a_ticket(): void
    {
        $user = User::factory()->create(['role' => 'user']);
        $ticket = $this->createTicket(User::factory()->create());

        $this->actingAs($user)
            ->patch(route('admin.tickets.update', $ticket), ['status' => 'confirmed'])
            ->assertForbidden();

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->getKey(),
            'status' => 'open',
            'id_teknisi' => null,
        ]);
    }

    public function test_admin_can_update_ticket_status_and_handling_notes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create(), ['status' => 'confirmed']);

        $this->actingAs($admin)
            ->patch(route('admin.tickets.update', $ticket), [
                'status' => 'process',
                'catatan' => 'Pemeriksaan komponen sedang dilakukan.',
            ])
            ->assertRedirect(route('admin.tickets.show', $ticket))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->getKey(),
            'status' => 'process',
            'catatan' => 'Pemeriksaan komponen sedang dilakukan.',
        ]);
    }

    public function test_admin_cannot_save_a_status_outside_the_database_enum(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create());

        $this->actingAs($admin)
            ->from(route('admin.tickets.show', $ticket))
            ->patch(route('admin.tickets.update', $ticket), [
                'status' => 'in_progress',
                'catatan' => 'Catatan tidak disimpan.',
            ])
            ->assertRedirect(route('admin.tickets.show', $ticket))
            ->assertSessionHasErrors('status');

        $this->assertSame('open', $ticket->fresh()->status);
    }

    public function test_ticket_updates_its_single_repair_history_record_instead_of_duplicating_it(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create(), [
            'status' => 'completed',
            'catatan' => 'Catatan hasil sebelumnya.',
        ]);
        $existingHistory = RepairHistory::query()->create([
            'id_ticket' => $ticket->getKey(),
            'tindakan' => 'Catatan sebelumnya.',
            'tanggal_selesai' => now()->subDay(),
        ]);

        $this->actingAs($admin)->patch(route('admin.tickets.update', $ticket), [
            'status' => 'failed',
            'catatan' => 'Perangkat masih rusak setelah penanganan.',
        ])->assertRedirect(route('admin.tickets.show', $ticket));

        $this->assertDatabaseCount('repair_histories', 1);
        $this->assertDatabaseHas('repair_histories', [
            'id' => $existingHistory->getKey(),
            'id_ticket' => $ticket->getKey(),
            'tindakan' => 'Perangkat masih rusak setelah penanganan.',
        ]);
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->getKey(),
            'status' => 'failed',
            'catatan' => 'Perangkat masih rusak setelah penanganan.',
        ]);
    }

    #[DataProvider('finalStatuses')]
    public function test_final_status_sets_repair_history_completion_date(string $status): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create(), ['status' => 'process']);
        $notes = $status === 'completed'
            ? 'Perangkat telah diuji dan berfungsi normal.'
            : 'Perangkat masih rusak setelah penanganan.';

        $this->actingAs($admin)->patch(route('admin.tickets.update', $ticket), [
            'status' => $status,
            'catatan' => $notes,
        ])->assertRedirect(route('admin.tickets.show', $ticket));

        $this->assertDatabaseHas('repair_histories', [
            'id_ticket' => $ticket->getKey(),
            'tindakan' => $notes,
        ]);
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->getKey(),
            'status' => $status,
            'catatan' => $notes,
        ]);
        $this->assertNotNull(RepairHistory::query()->where('id_ticket', $ticket->getKey())->value('tanggal_selesai'));
    }

    public static function finalStatuses(): array
    {
        return [
            'completed' => ['completed'],
            'failed' => ['failed'],
        ];
    }

    public function test_non_final_status_removes_stale_repair_history_and_outcome_notes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create(), [
            'status' => 'completed',
            'catatan' => 'Hasil final lama.',
        ]);
        RepairHistory::query()->create([
            'id_ticket' => $ticket->getKey(),
            'tindakan' => 'Hasil final lama.',
            'tanggal_selesai' => now()->subDay(),
        ]);

        $this->actingAs($admin)->patch(route('admin.tickets.update', $ticket), [
            'status' => 'process',
        ])->assertRedirect(route('admin.tickets.show', $ticket));

        $this->assertDatabaseMissing('repair_histories', ['id_ticket' => $ticket->getKey()]);
        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->getKey(),
            'status' => 'process',
            'catatan' => null,
        ]);
    }

    #[DataProvider('finalStatuses')]
    public function test_final_statuses_require_handling_notes(string $status): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create(), ['status' => 'process']);

        $this->actingAs($admin)
            ->from(route('admin.tickets.show', $ticket))
            ->patch(route('admin.tickets.update', $ticket), ['status' => $status, 'catatan' => ''])
            ->assertRedirect(route('admin.tickets.show', $ticket))
            ->assertSessionHasErrors([
                'catatan' => 'Catatan penanganan wajib diisi untuk hasil akhir Normal/Berhasil atau Rusak.',
            ]);

        $this->assertSame('process', $ticket->fresh()->status);
        $this->assertDatabaseMissing('repair_histories', ['id_ticket' => $ticket->getKey()]);
    }

    public function test_admin_can_cancel_an_open_ticket_without_creating_repair_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create());

        $this->actingAs($admin)
            ->patch(route('admin.tickets.update', $ticket), ['status' => 'canceled'])
            ->assertRedirect(route('admin.tickets.show', $ticket));

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->getKey(),
            'status' => 'canceled',
            'id_teknisi' => null,
        ]);
        $this->assertDatabaseMissing('repair_histories', ['id_ticket' => $ticket->getKey()]);
    }

    public function test_status_transition_must_follow_the_ticket_workflow(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create());

        $this->actingAs($admin)
            ->from(route('admin.tickets.show', $ticket))
            ->patch(route('admin.tickets.update', $ticket), [
                'status' => 'completed',
                'catatan' => 'Langsung diselesaikan.',
            ])
            ->assertRedirect(route('admin.tickets.show', $ticket))
            ->assertSessionHasErrors('status');

        $this->assertSame('open', $ticket->fresh()->status);
        $this->assertDatabaseMissing('repair_histories', ['id_ticket' => $ticket->getKey()]);
    }

    public function test_admin_history_displays_real_repair_history_and_related_ticket_data(): void
    {
        $admin = User::factory()->create(['role' => 'admin', 'nama' => 'Admin Penguji']);
        $technician = User::factory()->create(['role' => 'admin', 'nama' => 'Teknisi Riwayat']);
        $ticket = $this->createTicket(User::factory()->create(['nama' => 'Pelapor Riwayat']), [
            'kode_ticket' => 'TKT-HISTORY-REAL',
            'judul' => 'Perangkat perlu tindakan',
            'id_teknisi' => $technician->getKey(),
            'status' => 'completed',
        ]);
        RepairHistory::query()->create([
            'id_ticket' => $ticket->getKey(),
            'tindakan' => 'Komponen sudah diperbaiki.',
            'tanggal_selesai' => now(),
        ]);
        $failedTicket = $this->createTicket(User::factory()->create(), [
            'kode_ticket' => 'TKT-HISTORY-FAILED',
            'status' => 'failed',
            'catatan' => 'Perangkat masih rusak.',
        ]);
        RepairHistory::query()->create([
            'id_ticket' => $failedTicket->getKey(),
            'tindakan' => 'Perangkat masih rusak.',
            'tanggal_selesai' => now(),
        ]);

        foreach (['open', 'confirmed', 'process', 'canceled'] as $status) {
            $nonFinalTicket = $this->createTicket(User::factory()->create(), [
                'kode_ticket' => 'TKT-HISTORY-'.strtoupper($status),
                'status' => $status,
            ]);
            RepairHistory::query()->create([
                'id_ticket' => $nonFinalTicket->getKey(),
                'tindakan' => 'Riwayat lama yang tidak boleh ditampilkan.',
            ]);
        }

        $this->actingAs($admin)
            ->get(route('admin.history.index'))
            ->assertOk()
            ->assertSee('TKT-HISTORY-REAL')
            ->assertSee('TKT-HISTORY-FAILED')
            ->assertSee('Perangkat perlu tindakan')
            ->assertSee('Komponen sudah diperbaiki.')
            ->assertSee('Normal/Berhasil')
            ->assertSee('Rusak')
            ->assertDontSee('TKT-HISTORY-OPEN')
            ->assertDontSee('TKT-HISTORY-CONFIRMED')
            ->assertDontSee('TKT-HISTORY-PROCESS')
            ->assertDontSee('TKT-HISTORY-CANCELED')
            ->assertDontSee('Riwayat lama yang tidak boleh ditampilkan.')
            ->assertSee('Teknisi Riwayat');
    }

    public function test_admin_detail_shows_the_official_final_outcome_labels(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create(), ['status' => 'process']);

        $this->actingAs($admin)
            ->get(route('admin.tickets.show', $ticket))
            ->assertOk()
            ->assertSee('Normal/Berhasil')
            ->assertSee('Rusak')
            ->assertSee('Catatan wajib diisi untuk hasil akhir.');
    }

    public function test_admin_detail_displays_public_ticket_photo_url(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $ticket = $this->createTicket(User::factory()->create());
        $path = 'ticket-images/admin-detail.jpg';
        Storage::disk('public')->put($path, 'photo-content');
        TicketImage::query()->create(['id_ticket' => $ticket->getKey(), 'path' => $path]);
        $url = Storage::disk('public')->url($path);

        $this->actingAs($admin)
            ->get(route('admin.tickets.show', $ticket))
            ->assertOk()
            ->assertSee('href="'.$url.'"', false)
            ->assertSee('src="'.$url.'"', false);
    }

    public function test_regular_user_and_guest_cannot_access_admin_ticket_pages(): void
    {
        $ticket = $this->createTicket(User::factory()->create());
        $urls = [
            route('admin.tickets.index'),
            route('admin.tickets.show', $ticket),
            route('admin.history.index'),
        ];

        foreach ($urls as $url) {
            $this->get($url)->assertRedirect(route('login'));
        }

        $user = User::factory()->create(['role' => 'user']);
        foreach ($urls as $url) {
            $this->actingAs($user)->get($url)->assertForbidden();
        }
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createTicket(User $owner, array $attributes = [], string $deviceName = 'Keyboard Pengujian'): Ticket
    {
        $category = DeviceCategory::query()->create([
            'nama' => 'Laptop',
            'slug' => 'laptop-'.Str::uuid(),
        ]);
        $department = Department::query()->create([
            'nama' => 'IT',
            'lantai' => '1',
            'slug' => 'it-'.Str::uuid(),
        ]);
        $device = Device::query()->create([
            'kode_device' => 'DEV-'.Str::uuid(),
            'nama_device' => $deviceName,
            'id_kategori' => $category->getKey(),
            'id_user' => $owner->getKey(),
            'id_departemen' => $department->getKey(),
        ]);

        return Ticket::query()->create(array_merge([
            'kode_ticket' => 'TKT-'.Str::upper(Str::random(10)),
            'id_device' => $device->getKey(),
            'id_user' => $owner->getKey(),
            'judul' => 'Perangkat perlu diperiksa',
            'deskripsi' => 'Perangkat mengalami gangguan saat digunakan.',
            'prioritas' => 'sedang',
            'status' => 'open',
            'catatan' => null,
            'tanggal' => now(),
        ], $attributes));
    }
}
