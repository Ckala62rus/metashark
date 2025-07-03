<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

/**
 * Run tests
 * clear && vendor/bin/phpunit --filter=BookingTest
 *
 * Class BookingTest
 * @package Tests\Feature
 */
class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_successful_booking_by_authorized_user()
    {
        $user = User::first();
        Sanctum::actingAs($user);
        $room = Room::first();
        $date = Carbon::today()->addDays(3)->format('Y-m-d');
        $response = $this->postJson('/api/bookings', [
            'room_id' => $room->id,
            'date' => $date,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'room_id' => $room->id,
            'user_id' => $user->id,
            'date' => $date,
        ]);
    }

    public function test_cannot_book_already_booked_room()
    {
        $user = User::first();
        Sanctum::actingAs($user);
        $room = Room::first();
        $date = Carbon::today()->addDays(4)->format('Y-m-d');
        Booking::create([
            'room_id' => $room->id,
            'user_id' => $user->id,
            'date' => $date,
        ]);
        $response = $this->postJson('/api/bookings', [
            'room_id' => $room->id,
            'date' => $date,
        ]);
        $response->assertStatus(422);
    }

    public function test_cannot_book_without_auth()
    {
        $room = Room::first();
        $date = Carbon::today()->addDays(5)->format('Y-m-d');
        $response = $this->postJson('/api/bookings', [
            'room_id' => $room->id,
            'date' => $date,
        ]);
        $response->assertStatus(401);
    }
} 