<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface RoomServiceInterface
{
    public function getFreeRooms(array $params): Collection;
}
