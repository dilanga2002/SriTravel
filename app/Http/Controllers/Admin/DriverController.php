<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HandlesImages;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DriverController extends Controller
{
    use HandlesImages;

    public function index()
    {
        $drivers = User::where('role', 'driver')->paginate(10);
        return view('admin.drivers.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.drivers.create');
    }

    public function store(StoreDriverRequest $request)
    {
        return $this->safeExecute(function () use ($request) {
            $validated = $request->validated();

            $data = [
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'],
                'address'        => $validated['address'] ?? null,
                'license_number' => $validated['license_number'],
                'role'           => 'driver',
                'status'         => $validated['status'],
                'password'       => Hash::make($validated['password']),
            ];

            // Handle Driver Photo
            if ($request->hasFile('driver_photo')) {
                $data['driver_photo'] = $this->handleImageUpload(
                    $request->file('driver_photo'), 
                    'driver-photos'
                );
            }

            User::create($data);

            return 'Driver created successfully';
        }, 'Driver created successfully');
    }

    public function edit(User $driver)
    {
        return view('admin.drivers.edit', compact('driver'));
    }

    public function update(UpdateDriverRequest $request, User $driver)
    {
        return $this->safeExecute(function () use ($request, $driver) {
            $validated = $request->validated();

            $data = [
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'],
                'address'        => $validated['address'] ?? null,
                'license_number' => $validated['license_number'],
                'status'         => $validated['status'],
            ];

            if (!empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }

            // Handle Driver Photo Update
            if ($request->hasFile('driver_photo')) {
                $data['driver_photo'] = $this->handleImageUpload(
                    $request->file('driver_photo'), 
                    'driver-photos',
                    $driver->driver_photo
                );
            }

            $driver->update($data);

            return 'Driver updated successfully';
        }, 'Driver updated successfully');
    }

    public function destroy(User $driver)
    {
        return $this->safeExecute(function () use ($driver) {
            if ($driver->driver_photo) {
                $this->imageService->delete($driver->driver_photo);
            }
            $driver->delete();
            return 'Driver deleted successfully';
        }, 'Driver deleted successfully');
    }
}