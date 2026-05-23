<?php

namespace App\Http\Controllers\Traits;

use App\Models\Booking;
use App\Notifications\BookingStatusChanged;
use Illuminate\Support\Facades\Log;

trait UpdatesBookingStatus
{
    public function updateBookingStatus(Booking $booking, string $status, string $successMessage = 'Status updated successfully')
    {
        try {
            $booking->update(['status' => $status]);

            if ($booking->user) {
                $booking->user->notify(new BookingStatusChanged($booking, $status));
            }

            return redirect()->back()->with('success', $successMessage);
        } catch (\Exception $e) {
            Log::error('Booking status update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update booking status');
        }
    }
}