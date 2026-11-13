<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\Device;
use App\Models\DeviceCategory;
use App\Models\Ticket;
use App\Models\TicketImage;
use App\Models\User;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class TicketControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_open_create_ticket_form_with_only_accessible_devices(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $device = $this->createDevice($user, 'Perangkat Milik User');
        $otherDevice = $this->createDevice($otherUser, 'Perangkat User Lain');

        $this->actingAs($user)
            ->get(route('tickets.create'))
            ->assertOk()
            ->assertSee('Buat Tiket Kerusakan')
            ->assertSee($device->nama_device)
            ->assertDontSee($otherDevice->nama_device)
            ->assertSee('Kategori belum dapat disimpan');
    }

    public function test_user_creates_ticket_with_authenticated_reporter_and_default_status(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $device = $this->createDevice($user);
        $this->freezeTime();
        $createdAt = now();

        $response = $this->actingAs($user)->postJson(route('tickets.store'), [
            ...$this->validTicketPayload($device),
            'id_user' => $otherUser->getKey(),
            'id_teknisi' => $otherUser->getKey(),
        ]);

        $response->assertCreated()
            ->assertJsonPath('ticket.kode_ticket', Ticket::query()->value('kode_ticket'))
            ->assertJsonPath('redirect', route('tickets.mine'));

        $ticket = Ticket::query()->firstOrFail();
        $this->assertSame($user->getKey(), $ticket->id_user);
        $this->assertSame($device->getKey(), $ticket->id_device);
        $this->assertNull($ticket->id_teknisi);
        $this->assertSame('open', $ticket->status);
        $this->assertSame($createdAt->toDateTimeString(), $ticket->tanggal->toDateTimeString());
    }

    public function test_ticket_codes_are_generated_and_unique(): void
    {
        $user = User::factory()->create();
        $device = $this->createDevice($user);

        $firstResponse = $this->actingAs($user)->postJson(route('tickets.store'), $this->validTicketPayload($device));
        $secondResponse = $this->actingAs($user)->postJson(route('tickets.store'), $this->validTicketPayload($device));

        $firstResponse->assertCreated();
        $secondResponse->assertCreated();

        $codes = Ticket::query()->orderBy('id')->pluck('kode_ticket');
        $this->assertCount(2, $codes);
        $this->assertStringStartsWith('TKT-', $codes[0]);
        $this->assertStringStartsWith('TKT-', $codes[1]);
        $this->assertNotSame($codes[0], $codes[1]);
    }

    #[DataProvider('urgencyMappings')]
    public function test_ticket_urgency_is_mapped_to_database_priority(string $urgency, string $priority): void
    {
        $user = User::factory()->create();
        $device = $this->createDevice($user);

        $response = $this->actingAs($user)->postJson(route('tickets.store'), [
            ...$this->validTicketPayload($device),
            'urgency' => $urgency,
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('tickets', [
            'id_device' => $device->getKey(),
            'prioritas' => $priority,
        ]);
    }

    public static function urgencyMappings(): array
    {
        return [
            'rendah' => ['Rendah', 'rendah'],
            'sedang' => ['Sedang', 'sedang'],
            'mendesak' => ['Mendesak', 'tinggi'],
        ];
    }

    public function test_user_cannot_create_a_ticket_for_another_users_device(): void
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $otherDevice = $this->createDevice($otherUser);

        $this->actingAs($user)
            ->postJson(route('tickets.store'), $this->validTicketPayload($otherDevice))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('device_id');

        $this->assertDatabaseCount('tickets', 0);
    }

    public function test_ticket_photo_is_stored_on_public_disk_and_linked_to_ticket(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $device = $this->createDevice($user);

        $response = $this->actingAs($user)->postJson(route('tickets.store'), [
            ...$this->validTicketPayload($device),
            'photo' => UploadedFile::fake()->image('damage.jpg'),
        ]);

        $response->assertCreated();
        $ticket = Ticket::query()->firstOrFail();
        $image = TicketImage::query()->firstOrFail();

        $this->assertSame($ticket->getKey(), $image->id_ticket);
        $this->assertStringStartsWith('ticket-images/', $image->path);
        Storage::disk('public')->assertExists($image->path);
    }

    public function test_invalid_photo_format_is_rejected_without_creating_ticket_or_file(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $device = $this->createDevice($user);

        $this->actingAs($user)
            ->postJson(route('tickets.store'), [
                ...$this->validTicketPayload($device),
                'photo' => UploadedFile::fake()->create('payload.txt', 1, 'text/plain'),
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('photo');

        $this->assertDatabaseCount('tickets', 0);
        $this->assertDatabaseCount('ticket_images', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_photo_over_five_megabytes_is_rejected_without_creating_ticket_or_file(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $device = $this->createDevice($user);

        $this->actingAs($user)
            ->postJson(route('tickets.store'), [
                ...$this->validTicketPayload($device),
                'photo' => UploadedFile::fake()->create('large.jpg', 5121, 'image/jpeg'),
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('photo');

        $this->assertDatabaseCount('tickets', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_storage_failure_rolls_back_ticket_creation(): void
    {
        $user = User::factory()->create();
        $device = $this->createDevice($user);
        $disk = Mockery::mock(FilesystemAdapter::class);
        $disk->shouldReceive('putFileAs')->once()->andReturn(false);
        $disk->shouldReceive('delete')->once()->andReturn(true);
        Storage::shouldReceive('disk')->with('public')->twice()->andReturn($disk);

        $this->actingAs($user)
            ->postJson(route('tickets.store'), [
                ...$this->validTicketPayload($device),
                'photo' => UploadedFile::fake()->image('damage.png'),
            ])
            ->assertServerError();

        $this->assertDatabaseCount('tickets', 0);
        $this->assertDatabaseCount('ticket_images', 0);
    }

    public function test_guest_cannot_create_a_ticket(): void
    {
        $user = User::factory()->create();
        $device = $this->createDevice($user);

        $this->post(route('tickets.store'), $this->validTicketPayload($device))
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('tickets', 0);
    }

    /**
     * @return array{device_id: int, title: string, description: string, urgency: string}
     */
    private function validTicketPayload(Device $device): array
    {
        return [
            'device_id' => $device->getKey(),
            'title' => 'Layar laptop tidak menyala',
            'description' => 'Layar perangkat tetap mati setelah dinyalakan.',
            'urgency' => 'Sedang',
        ];
    }

    private function createDevice(User $owner, string $name = 'Laptop Pengujian'): Device
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

        return Device::query()->create([
            'kode_device' => 'DEV-'.Str::uuid(),
            'nama_device' => $name,
            'id_kategori' => $category->getKey(),
            'id_user' => $owner->getKey(),
            'id_departemen' => $department->getKey(),
        ]);
    }
}
