<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get current bookings (confirmed and pending, with end_date >= now)
        $currentBookings = Booking::where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->where('end_date', '>=', now())
            ->with('vehicle')
            ->latest()
            ->take(5)
            ->get();

        // Get total bookings (all bookings for the user)
        $totalBookingsCount = Booking::where('user_id', $user->id)->count();

        // Get completed bookings
        $completedBookingsCount = Booking::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        // Get recommended vehicles (could be based on user's preferences or random)
        $recommendedVehicles = Vehicle::where('available', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('dashboard', [
            'activeBookingsCount' => $currentBookings->count(),
            'totalBookingsCount' => $totalBookingsCount,
            'completedBookingsCount' => $completedBookingsCount,
            'currentBookings' => $currentBookings,
            'recommendedVehicles' => $recommendedVehicles
        ]);
    }
}