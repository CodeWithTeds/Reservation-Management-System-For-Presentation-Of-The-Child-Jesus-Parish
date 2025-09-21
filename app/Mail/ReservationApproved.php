<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ReservationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservation $reservation)
    {
        // Ensure relations are available for the view
        $this->reservation->loadMissing(['user', 'service']);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reservation Approved - #' . $this->reservation->reservation_id,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reservations.approved',
            with: [
                'reservation' => $this->reservation,
                'user' => $this->reservation->user,
                'service' => $this->reservation->service,
                'date' => optional($this->reservation->date_reserved)->format('Y-m-d'),
                'time_start' => optional($this->reservation->time_start)->format('H:i'),
                'time_end' => optional($this->reservation->time_end)->format('H:i'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}