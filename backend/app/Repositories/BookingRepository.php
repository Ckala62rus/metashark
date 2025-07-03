<?php

namespace App\Repositories;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\BookingRepositoryInterface;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BookingRepository extends BaseRepository implements BaseRepositoryInterface, BookingRepositoryInterface
{
    /**
     * BookingRepository constructor.
     */
    public function __construct()
    {
        $this->model = new Booking();
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
     * Return collection unique Room ids
     *
     * @param Builder $query
     * @param Collection $period
     * @return Collection
     */
    public function getBookingUniqueId(Builder $query, Collection $period): Collection
    {
        return $query
            ->whereIn('date', $period)
            ->pluck('room_id')
            ->unique();
    }

    /**
     * Create new Booking model
     *
     * @param Builder $query
     * @param array $data
     * @return Model
     */
    public function createBooking(Builder $query, array $data): Model
    {
        return $query->create($data);
    }
}
