<?php

namespace App\Repositories;

use App\Contracts\RoomRepositoryInterface;
use App\Models\Room;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class RoomRepository extends BaseRepository implements RoomRepositoryInterface
{
    /**
     * BookingRepository constructor.
     */
    public function __construct()
    {
        $this->model = new Room();
    }

    /**
     * Get query builder
     *
     * @return Builder
     */
    public function getQuery(): Builder
    {
        return $this
            ->model
            ->newQuery();
    }

    /**
     * Get all Rooms where not equal ids
     *
     * @param Builder $query
     * @param Collection $bookedRoomIds
     * @return Collection
     */
    public function getRoomNotEqualIds(Builder $query, Collection $bookedRoomIds): Collection
    {
        return $query
            ->whereNotIn('id', $bookedRoomIds)
            ->get(['id', 'name', 'description']);
    }
}
