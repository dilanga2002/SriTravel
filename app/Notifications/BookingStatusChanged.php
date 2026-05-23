<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    protected $booking;
    protected $status;

    public function __construct(Booking $booking, string $status)
    {
        $this->booking = $booking;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /*public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("Booking #{$this->booking->id} Status Update")
            ->greeting("Hello {$notifiable->name},")
            ->line("Your booking status has been updated to: {$this->status}")
            ->line("Booking Details:")
            ->line("- Booking ID: #{$this->booking->id}")
            ->line("- Vehicle: {$this->booking->vehicle->make} {$this->booking->vehicle->model}")
            ->line("- Status: " . ucfirst($this->status))
            ->line('Thank you for using our service!');
    }*/

    public function toDatabase($notifiable)
    {
        return [
            'booking_id' => $this->booking->id,
            'status' => $this->status,
            'message' => "Your booking #{$this->booking->id} has been {$this->status}",
            'url' => route('bookings.show', $this->booking->id),
            'vehicle_info' => "{$this->booking->vehicle->make} {$this->booking->vehicle->model}",
            'total_amount' => $this->booking->total_amount,
        ];
    }
}