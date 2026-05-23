<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UpdatesBookingStatus;
use App\Models\Booking;
use App\Notifications\BookingStatusChanged;
use App\Notifications\BookingConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    use UpdatesBookingStatus;

    public function index(Request $request)
    {
        $query = Booking::with(['vehicle', 'user', 'driver'])->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['vehicle', 'user', 'driver']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        try {
            $booking->update(['status' => 'confirmed']);

            $booking->user->notify(new BookingConfirmation($booking));
            $booking->user->notify(new BookingStatusChanged($booking, 'confirmed'));

            return redirect()->back()->with('success', 'Booking confirmed successfully');
        } catch (\Exception $e) {
            Log::error('Booking confirmation failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to confirm booking');
        }
    }

    public function cancel(Booking $booking)
    {
        return $this->updateBookingStatus($booking, 'cancelled', 'Booking cancelled successfully');
    }

    public function complete(Booking $booking)
    {
        return $this->updateBookingStatus($booking, 'completed', 'Booking marked as completed');
    }
}