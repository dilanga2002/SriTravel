<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use App\Notifications\BookingConfirmation;
use App\Http\Controllers\Traits\HandlesAvailability;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    use HandlesAvailability;

    /**
     * Display a listing of the user's bookings.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->bookings()->with(['vehicle', 'driver'])->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(10)->appends($request->only('status'));

        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Vehicle $vehicle = null)
    {
        if (!$vehicle && request()->has('vehicle_id')) {
            $vehicle = Vehicle::findOrFail(request()->query('vehicle_id'));
        }

        if (!$vehicle) {
            return redirect()->route('vehicles.index')
                             ->with('error', 'Please select a vehicle first.');
        }

        $drivers = User::where('role', 'driver')
                       ->where('status', 'active')
                       ->get();

        return view('bookings.create', compact('vehicle', 'drivers'));
    }

    /**
     * Store a newly created booking.
     */
    public function store(StoreBookingRequest $request)
    {
        $validated = $request->validated();

        $vehicle = Vehicle::findOrFail($validated['vehicle_id']);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        $totalAmount = $totalDays * $validated['total_KiloMeter'] * $vehicle->price_per_km;

        $booking = Booking::create([
            'user_id'          => auth()->id(),
            'vehicle_id'       => $vehicle->id,
            'driver_id'        => $validated['driver_id'] ?? null,
            'start_date'       => $validated['start_date'],
            'end_date'         => $validated['end_date'],
            'pickup_time'      => $validated['pickup_time'],
            'pickup_location'  => $validated['pickup_location'],
            'dropoff_location' => $validated['dropoff_location'],
            'destination'      => $validated['destination'],
            'total_KiloMeter'  => $validated['total_KiloMeter'],
            'total_amount'     => round($totalAmount, 2),
            'status'           => 'pending',
            'special_requests' => $validated['special_requests'] ?? null,
        ]);

        return redirect()->route('bookings.show', $booking)
                         ->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $booking->load(['vehicle', 'driver', 'user']);

        return view('bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $drivers = User::where('role', 'driver')
                       ->where('status', 'active')
                       ->get();

        return view('bookings.edit', compact('booking', 'drivers'));
    }

    /**
     * Update the specified booking.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return $this->safeExecute(function () use ($request, $booking) {
            $validated = $request->validated();

            if (!$this->isVehicleAvailable($booking->vehicle_id, $validated['start_date'], $validated['end_date'], $booking->id)) {
                return back()
                    ->withErrors(['start_date' => 'This vehicle is not available for the selected dates.'])
                    ->withInput();
            }

            if ($validated['driver_id'] && !$this->isDriverAvailable($validated['driver_id'], $validated['start_date'], $validated['end_date'], $booking->id)) {
                return back()
                    ->withErrors(['driver_id' => 'This driver is not available for the selected dates.'])
                    ->withInput();
            }

            $startDate = Carbon::parse($validated['start_date']);
            $endDate = Carbon::parse($validated['end_date']);
            $totalDays = $startDate->diffInDays($endDate) + 1;
            $pricePerKm = $booking->vehicle->price_per_km;
            $totalAmount = $totalDays * $validated['total_KiloMeter'] * $pricePerKm;

            $booking->update([
                'start_date'       => $validated['start_date'],
                'end_date'         => $validated['end_date'],
                'pickup_time'      => $validated['pickup_time'],
                'pickup_location'  => $validated['pickup_location'],
                'dropoff_location' => $validated['dropoff_location'],
                'destination'      => $validated['destination'],
                'total_KiloMeter'  => $validated['total_KiloMeter'],
                'total_amount'     => $totalAmount,
                'driver_id'        => $validated['driver_id'],
                'special_requests' => $validated['special_requests'],
            ]);

            return redirect()->route('bookings.show', $booking)
                             ->with('success', 'Booking updated successfully!');
        }, 'Booking updated successfully!');
    }

    /**
     * Cancel the booking.
     */
    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return $this->safeExecute(function () use ($booking) {
            $booking->update(['status' => 'cancelled']);
            return 'Booking cancelled successfully!';
        }, 'Booking cancelled successfully!');
    }

    /**
     * AJAX endpoint to check driver availability
     */
    public function checkDriverAvailability(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $drivers = User::where('role', 'driver')
            ->where('status', 'active')
            ->get()
            ->map(function ($driver) use ($validated) {
                $isAvailable = $this->isDriverAvailable(
                    $driver->id, 
                    $validated['start_date'], 
                    $validated['end_date']
                );

                return [
                    'id'              => $driver->id,
                    'name'            => $driver->name,
                    'license_number'  => $driver->license_number,
                    'is_available'    => $isAvailable,
                ];
            });

        return response()->json(['drivers' => $drivers]);
    }
}