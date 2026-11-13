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
use Tests\TestCase;

class UserTicketPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_my_tickets_only_displays_tickets_owned_by_the_authenticated_user(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $technician = User::factory()->create(['nama' => 'Teknisi Uji']);
        $ownedTicket = $this->createTicket($user, [
            'kode_ticket' => 'TKT-OWNED',
            'judul' => 'Tombol perangkat rusak',
            'prioritas' => 'tinggi',
            'id_teknisi' => $technician->getKey(),
        ]);
        $otherTicket = $this->createTicket($otherUser, ['kode_ticket' => 'TKT-OTHER']);

        $this->actingAs($user)
            ->get(route('tickets.mine'))
            ->assertOk()
            ->assertSee($ownedTicket->kode_ticket)
            ->assertSee('Keyboard Pengujian')
            ->assertSee('Tombol perangkat rusak')
            ->assertSee('Mendesak')
            ->assertSee('Pending')
            ->assertSee('Teknisi Uji')
            ->assertDontSee($otherTicket->kode_ticket);
    }

    public function test_user_can_open_their_ticket_detail_and_see_database_information(): void
    {
        $user = User::factory()->create();
        $ticket = $this->createTicket($user, [
            'judul' => 'Keyboard perangkat tidak merespons',
            'deskripsi' => 'Keyboard tidak merespons setelah perangkat dinyalakan.',
            'catatan' => 'Pengecekan awal sudah dilakukan.',
        ]);
        RepairHistory::query()->create([
            'id_ticket' => $ticket->getKey(),
            'tindakan' => 'Konektor keyboard dipasang ulang.',
            'tanggal_selesai' => now(),
        ]);

        $this->actingAs($user)
            ->get(route('tickets.mine.show', $ticket->getKey()))
            ->assertOk()
            ->assertSee('Keyboard Pengujian')
            ->assertSee('Keyboard perangkat tidak merespons')
            ->assertSee('Keyboard tidak merespons setelah perangkat dinyalakan.')
            ->assertSee('Pengecekan awal sudah dilakukan.')
            ->assertSee('Konektor keyboard dipasang ulang.')
            ->assertSee($user->nama);
    }

    public function test_user_receives_not_found_for_another_users_ticket_detail(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherTicket = $this->createTicket($otherUser);

        $this->actingAs($user)
            ->get(route('tickets.mine.show', $otherTicket->getKey()))
            ->assertNotFound();
    }

    public function test_ticket_photo_uses_its_public_storage_url_on_detail_page(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $ticket = $this->createTicket($user);
        $photoPath = 'ticket-images/ticket-photo.jpg';
        Storage::disk('public')->put($photoPath, 'photo-content');
        TicketImage::query()->create([
            'id_ticket' => $ticket->getKey(),
            'path' => $photoPath,
        ]);

        $photoUrl = Storage::disk('public')->url($photoPath);

        $this->actingAs($user)
            ->get(route('tickets.mine.show', $ticket->getKey()))
            ->assertOk()
            ->assertSee('href="'.$photoUrl.'"', false)
            ->assertSee('src="'.$photoUrl.'"', false);
    }

    public function test_guest_cannot_open_my_tickets_or_ticket_detail(): void
    {
        $ticket = $this->createTicket(User::factory()->create());

        $this->get(route('tickets.mine'))
            ->assertRedirect(route('login'));

        $this->get(route('tickets.mine.show', $ticket->getKey()))
            ->assertRedirect(route('login'));
    }

    public function test_my_tickets_uses_database_pagination(): void
    {
        $user = User::factory()->create();
        $tickets = [];

        for ($number = 1; $number <= 9; $number++) {
            $tickets[] = $this->createTicket($user, [
                'kode_ticket' => sprintf('TKT-PAGE-%02d', $number),
                'tanggal' => now()->subMinutes($number),
            ]);
        }

        $this->actingAs($user)
            ->get(route('tickets.mine'))
            ->assertOk()
            ->assertSee('TKT-PAGE-01')
            ->assertDontSee('TKT-PAGE-09')
            ->assertSee('page=2');

        $this->get(route('tickets.mine', ['page' => 2]))
            ->assertOk()
            ->assertSee('TKT-PAGE-09')
            ->assertDontSee('TKT-PAGE-01');
    }

    public function test_my_tickets_search_and_status_filters_query_database_records(): void
    {
        $user = User::factory()->create();
        $pendingTicket = $this->createTicket($user, [
            'kode_ticket' => 'TKT-KEYBOARD',
            'judul' => 'Keyboard bermasalah',
            'status' => 'open',
        ]);
        $this->createTicket($user, [
            'kode_ticket' => 'TKT-MONITOR',
            'judul' => 'Monitor bermasalah',
            'status' => 'process',
        ]);

        $response = $this->actingAs($user)
            ->get(route('tickets.mine', ['search' => 'Keyboard bermasalah']))
            ->assertOk()
            ->assertViewHas('search', 'Keyboard bermasalah');

        $this->assertSame(1, $response->viewData('tickets')->total());
        $response->assertSee($pendingTicket->kode_ticket)
            ->assertDontSee('TKT-MONITOR');

        $response = $this->get(route('tickets.mine', ['status' => 'Diproses']))
            ->assertOk()
            ->assertViewHas('selectedStatus', 'Diproses');

        $this->assertSame(1, $response->viewData('tickets')->total());
        $response
            ->assertSee('TKT-MONITOR')
            ->assertDontSee($pendingTicket->kode_ticket);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function createTicket(User $owner, array $attributes = []): Ticket
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
            'nama_device' => 'Keyboard Pengujian',
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
