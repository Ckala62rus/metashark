<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BookingRepositoryInterface extends BaseRepositoryInterface
{
    public function getBookingUniqueId(Builder $query, Collection $period): Collection;
    public function createBooking(Builder $query, array $data): Model;
}
