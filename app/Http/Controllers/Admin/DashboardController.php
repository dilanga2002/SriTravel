<?php
// app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Vehicle statistics
        $vehicleCount = Vehicle::count();
        $vehicleLastMonthCount = Vehicle::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $vehiclePercentageChange = $vehicleLastMonthCount > 0 
            ? round(($vehicleCount - $vehicleLastMonthCount) / $vehicleLastMonthCount * 100, 2)
            : 100;

        // Booking statistics
        $bookingCount = Booking::whereIn('status', ['confirmed', 'pending'])->count();
        $bookingLastMonthCount = Booking::where('created_at', '>=', Carbon::now()->subMonth())
            ->whereIn('status', ['confirmed', 'pending'])
            ->count();
        $bookingPercentageChange = $bookingLastMonthCount > 0 
            ? round(($bookingCount - $bookingLastMonthCount) / $bookingLastMonthCount * 100, 2)
            : 100;

        // Driver statistics
        $driverCount = User::where('role', 'driver')->count();
        $newDriversThisWeek = User::where('role', 'driver')
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->count();

        // Revenue statistics
        $totalRevenue = Booking::where('status', 'confirmed')
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->sum('total_amount');
            
        $revenueLastMonth = Booking::where('status', 'confirmed')
            ->whereBetween('created_at', [
                Carbon::now()->subMonth()->startOfMonth(),
                Carbon::now()->subMonth()->endOfMonth()
            ])
            ->sum('total_amount');
            
        $revenuePercentageChange = $revenueLastMonth > 0 
            ? round(($totalRevenue - $revenueLastMonth) / $revenueLastMonth * 100, 2)
            : 100;

        // Recent bookings (last 5)
        $recentBookings = Booking::with(['user', 'vehicle'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'vehicleCount',
            'vehiclePercentageChange',
            'bookingCount',
            'bookingPercentageChange',
            'driverCount',
            'newDriversThisWeek',
            'totalRevenue',
            'revenuePercentageChange',
            'recentBookings'
        ));
    }
}