<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeviceTicketNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_my_device_page_links_to_the_create_ticket_route(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('devices.mine'))
            ->assertOk()
            ->assertSee('href="'.route('tickets.create').'"', false)
            ->assertDontSee('href="/tiket/buat"', false);
    }
}
