<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $roomId;
    public $date;

    public function __construct($roomId, $date)
    {
        $this->roomId = $roomId;
        $this->date = $date;
    }

    public function build()
    {
        return $this->subject('Бронирование номера')
            ->text('emails.booking_created_plain');
    }
} 