<?php

namespace App\Services;

use App\Contracts\BookingRepositoryInterface;
use App\Contracts\BookingServiceInterface;
use App\Models\Booking;
use Exception;
use App\Mail\BookingCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class BookingService implements BookingServiceInterface
{
    /**
     * BookingService constructor.
     * @param BookingRepositoryInterface $bookingRepository
     */
    public function __construct(
        public BookingRepositoryInterface $bookingRepository
    ){}

    /**
     * Забронировать номер для пользователя
     *
     * @param $user
     * @param int $room_id
     * @param string $date
     * @return Booking
     * @throws Exception
     */
    public function bookRoom($user, int $room_id, string $date): Model
    {
        // Проверка, не занят ли номер на эту дату
        $exists = Booking::where('room_id', $room_id)
            ->where('date', $date)
            ->exists();
        if ($exists) {
            throw new Exception('Room already booked for this date', 422);
        }

        $queryBooking = $this
            ->bookingRepository
            ->getQuery();

        // Создание брони
        $booking = $this->bookingRepository->createBooking($queryBooking, [
            'room_id' => $room_id,
            'user_id' => $user->id,
            'date' => $date,
        ]);

        // Отправка email через Mailable
        Mail::to($user->email)
            ->send(new BookingCreated($booking->room_id, $booking->date));

        return $booking;
    }
}
