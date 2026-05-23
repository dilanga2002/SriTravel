<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class VehicleController extends Controller
{
    /**
     * Display all available vehicles with filters.
     */
    public function index(Request $request)
    {
        $query = Vehicle::where('available', true);

        // Filter by Type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('price_per_km', '>=', (float)$request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_km', '<=', (float)$request->max_price);
        }

        // Date Availability Filter (Most Important)
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->start_date;
            $endDate   = $request->end_date;

            $query->whereDoesntHave('bookings', function ($q) use ($startDate, $endDate) {
                $q->where('status', '!=', 'cancelled')
                  ->where(function ($q) use ($startDate, $endDate) {
                      $q->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('start_date', '<=', $startDate)
                              ->where('end_date', '>=', $endDate);
                        });
                  });
            });
        }

        $vehicles = $query->paginate(12)->appends($request->query());

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show single vehicle details.
     */
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if (!$vehicle->available) {
            return redirect()->route('vehicles.index')
                             ->with('error', 'This vehicle is currently unavailable.');
        }

        return view('vehicles.show', compact('vehicle'));
    }

}