<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UpdatesBookingStatus;
use App\Models\Booking;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    use UpdatesBookingStatus;

    /**
     * Driver Dashboard
     */
    public function dashboard()
    {
        $driver = auth()->user();

        $todayAssignments = Booking::where('driver_id', $driver->id)
            ->where('start_date', today())
            ->whereIn('status', ['pending', 'confirmed'])
            ->with(['vehicle', 'user'])
            ->latest()
            ->get();

        $todayAssignmentsCount = $todayAssignments->count();

        $completedTrips = Booking::where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->count();

        $upcomingAssignments = Booking::with(['user', 'vehicle'])
            ->where('driver_id', $driver->id)
            ->where('status', 'confirmed')
            ->where('start_date', '>', today())
            ->orderBy('start_date')
            ->take(5)
            ->get();

        $recentActivities = Booking::with(['user', 'vehicle'])
            ->where('driver_id', $driver->id)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->take(5)
            ->get();

        return view('driver.dashboard', compact(
            'todayAssignments',
            'todayAssignmentsCount',
            'completedTrips',
            'upcomingAssignments',
            'recentActivities'
        ));
    }

    /**
     * Show all bookings assigned to this driver
     */
    public function bookings(Request $request)
    {
        $driver = auth()->user();

        $query = Booking::where('driver_id', $driver->id)
                        ->with(['vehicle', 'user']);

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->latest()->paginate(10)->appends($request->only('status'));

        return view('driver.bookings.index', compact('bookings'));
    }

    /**
     * Show single booking details
     */
    public function showBooking(Booking $booking)
    {
        if ($booking->driver_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['vehicle', 'user']);

        return view('driver.bookings.show', compact('booking'));
    }

    /**
     * Mark booking as completed
     */
    public function markAsCompleted(Booking $booking)
    {
        if ($booking->driver_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($booking->status !== 'confirmed') {
            return back()->with('error', 'Only confirmed bookings can be marked as completed');
        }

        return $this->updateBookingStatus($booking, 'completed', 'Booking marked as completed successfully');
    }
}