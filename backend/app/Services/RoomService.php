<?php

namespace App\Services;

use App\Contracts\BookingRepositoryInterface;
use App\Contracts\RoomRepositoryInterface;
use App\Contracts\RoomServiceInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class RoomService implements RoomServiceInterface
{
    /**
     * RoomService constructor.
     * @param BookingRepositoryInterface $bookingRepository
     * @param RoomRepositoryInterface $roomRepository
     */
    public function __construct(
        public BookingRepositoryInterface $bookingRepository,
        public RoomRepositoryInterface $roomRepository,
    ){}

    /**
     * Получить список свободных номеров на указанные даты или на неделю вперед.
     *
     * @param array $params
     * @return Collection
     */
    public function getFreeRooms(array $params): Collection
    {
        $cacheKey = 'free_rooms_' . md5(json_encode($params));
        return Cache::remember($cacheKey, 60, function () use ($params) {
            $date = $params['date'] ?? null;
            $dates = $params['dates'] ?? null;
            $start = $params['start'] ?? null;
            $end = $params['end'] ?? null;

            if ($start && $end) {
                // example ['2025-07-01', '2025-07-02', '2025-07-03']
                $period = collect(range(0, Carbon::parse($end)->diffInDays(Carbon::parse($start))))
                    ->map(fn($i) => Carbon::parse($start)->copy()->addDays($i)->format('Y-m-d'));

            } elseif ($dates && is_array($dates)) {
                // example ['2025-07-01', '2025-07-03']
                $period = collect($dates);

            } elseif ($date) {
                // example ['2025-07-01']
                $period = collect([$date]);

            } else {
                // get free Rooms for 7 days
                $today = Carbon::today();
                $period = collect(range(0, 6))->map(fn($i) => $today->copy()->addDays($i)->format('Y-m-d'));
            }

            $queryBooking = $this
                ->bookingRepository
                ->getQuery();

            $bookedRoomIds = $this
                ->bookingRepository
                ->getBookingUniqueId($queryBooking, $period);

            $queryRoom = $this->roomRepository->getQuery();

            return $this
                ->roomRepository
                ->getRoomNotEqualIds($queryRoom, $bookedRoomIds);
        });
    }
}
