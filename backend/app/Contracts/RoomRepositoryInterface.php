<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

interface RoomRepositoryInterface
{
    public function getQuery(): Builder;
    public function getRoomNotEqualIds(Builder $query, Collection $bookedRoomIds): Collection;
}
