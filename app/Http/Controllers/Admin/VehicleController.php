<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImages;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    use HandlesImages;

    /**
     * Display a listing of vehicles.
     */
    public function index()
    {
        $vehicles = Vehicle::paginate(10);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create()
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a newly created vehicle.
     */
    public function store(StoreVehicleRequest $request)
    {
        return $this->safeExecute(function () use ($request) {
            $validated = $request->validated();

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $this->handleImageUpload(
                    $request->file('image'), 
                    'vehicles'
                );
            }

            Vehicle::create([
                'make'                => $validated['make'],
                'model'               => $validated['model'],
                'year'                => (int)$validated['year'],
                'registration_number' => $validated['registration_number'],
                'type'                => $validated['type'],
                'price_per_km'        => (float)$validated['price_per_km'],
                'passengers'          => (int)$validated['passengers'],
                'description'         => $validated['description'] ?? null,
                'image'               => $imagePath,
                'features'            => $validated['features'] 
                                        ? array_map('trim', explode(',', $validated['features'])) 
                                        : [],
                'available'           => $request->boolean('available', false),
            ]);

            return 'Vehicle added successfully.';
        }, 'Vehicle added successfully.');
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(Vehicle $vehicle)
    {
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    /**
     * Update the specified vehicle.
     */
    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        return $this->safeExecute(function () use ($request, $vehicle) {
            $validated = $request->validated();

            $imagePath = $vehicle->image;

            if ($request->hasFile('image')) {
                $imagePath = $this->handleImageUpload(
                    $request->file('image'), 
                    'vehicles',
                    $vehicle->image
                );
            }

            $vehicle->update([
                'make'                => $validated['make'],
                'model'               => $validated['model'],
                'year'                => (int)$validated['year'],
                'registration_number' => $validated['registration_number'],
                'type'                => $validated['type'],
                'price_per_km'        => (float)$validated['price_per_km'],
                'passengers'          => (int)$validated['passengers'],
                'description'         => $validated['description'] ?? null,
                'image'               => $imagePath,
                'features'            => $validated['features'] 
                                        ? array_map('trim', explode(',', $validated['features'])) 
                                        : [],
                'available'           => $request->boolean('available', false),
            ]);

            return 'Vehicle updated successfully.';
        }, 'Vehicle updated successfully.');
    }
        public function show(Vehicle $vehicle)
    {
        $vehicle->load(['bookings' => function ($query) {
            $query->latest()->take(5);
        }]);

        return view('admin.vehicles.show', compact('vehicle'));
    }

    /**
     * Remove the specified vehicle.
     */
    public function destroy(Vehicle $vehicle)
    {
        return $this->safeExecute(function () use ($vehicle) {
            if ($vehicle->image) {
                $this->imageService->delete($vehicle->image);
            }

            $vehicle->delete();

            return 'Vehicle deleted successfully.';
        }, 'Vehicle deleted successfully.');
    }

    /**
     * Toggle vehicle availability.
     */
    public function toggleAvailability(Vehicle $vehicle)
    {
        return $this->safeExecute(function () use ($vehicle) {
            $vehicle->update(['available' => !$vehicle->available]);
            return 'Vehicle availability updated successfully.';
        }, 'Vehicle availability updated successfully.');
    }
}