<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class RoomsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_can_get_free_rooms_without_dates()
    {
        $response = $this->getJson('/api/rooms');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['id', 'name', 'description']
        ]);
    }

    public function test_can_get_free_rooms_for_specific_date()
    {
        $date = Carbon::today()->addDays(2)->format('Y-m-d');
        $response = $this->getJson('/api/rooms?date=' . $date);
        $response->assertStatus(200);
        $response->assertJsonStructure([
            ['id', 'name', 'description']
        ]);
    }

    /**
     * @dataProvider datesProvider
     */
    public function test_room_not_returned_if_booked_on_various_dates($date)
    {
        $room = Room::first();
        $user = User::factory()->create();
        Booking::create([
            'room_id' => $room->id,
            'user_id' => $user->id,
            'date' => $date,
        ]);
        $response = $this->getJson('/api/rooms?date=' . $date);
        $response->assertStatus(200);
        $ids = collect($response->json())->pluck('id');
        $this->assertFalse($ids->contains($room->id));
    }

    public static function datesProvider()
    {
        return [
            [now()->addDays(1)->format('Y-m-d')],
            [now()->addDays(2)->format('Y-m-d')],
            [now()->addDays(3)->format('Y-m-d')],
        ];
    }
} 