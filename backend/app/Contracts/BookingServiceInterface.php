<?php

namespace App\Contracts;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Model;

interface BookingServiceInterface
{
    /**
     * Return all free hotel room without busy room
     *
     * @param $user
     * @param int $room_id
     * @param string $date
     * @return Booking
     */
    public function bookRoom($user, int $room_id, string $date): Model;
}
