<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Booking;

class BookingConfirmation extends Notification implements ShouldQueue
{
    use Queueable;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Booking Confirmation #'.$this->booking->id)
                    ->greeting('Hello '.$notifiable->name.',')
                    ->line('Your booking has been successfully confirmed.')
                    ->line('Booking Details:')
                    ->line('Booking ID: #'.$this->booking->id)
                    ->line('Vehicle: '.$this->booking->vehicle->make.' '.$this->booking->vehicle->model)
                    ->line('Pickup Date: '.$this->booking->start_date->format('M d, Y'))
                    ->line('Return Date: '.$this->booking->end_date->format('M d, Y'))
                    ->line('Total Amount: Rs. '.number_format($this->booking->total_amount, 2))
                    ->line('Thank you for choosing our service!');
    }
}