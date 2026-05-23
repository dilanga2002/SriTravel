@extends('layouts.app')

@section('title', 'Edit Booking - SriTravel')

@section('content')

    <div class="max-w-4xl mx-auto py-8">

        <div class="bg-white rounded-2xl shadow p-8">

            <!-- Page Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-semibold">Edit Booking #{{ $booking->id }}</h1>
                </div>
                <a href="{{ route('bookings.show', $booking->id) }}" 
                   class="inline-flex items-center px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                    ← Back to Details
                </a>
            </div>

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Booking Details -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold mb-4">Booking Details</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                            <input type="date" name="start_date" value="{{ old('start_date', $booking->start_date->format('Y-m-d')) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('start_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                            <input type="date" name="end_date" value="{{ old('end_date', $booking->end_date->format('Y-m-d')) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('end_date')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Time</label>
                            <input type="time" name="pickup_time" value="{{ old('pickup_time', $booking->pickup_time) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('pickup_time')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Location</label>
                            <input type="text" name="pickup_location" value="{{ old('pickup_location', $booking->pickup_location) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('pickup_location')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dropoff Location</label>
                            <input type="text" name="dropoff_location" value="{{ old('dropoff_location', $booking->dropoff_location) }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('dropoff_location')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Destination</label>
                            <input type="text" name="destination" value="{{ old('destination', $booking->destination ?? '') }}" required
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('destination')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-semibold mb-4">Additional Information</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Driver (Optional)</label>
                            <select name="driver_id" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                <option value="">No Driver</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id', $booking->driver_id) == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }} ({{ $driver->license_number }})
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Total Kilometers</label>
                            <input type="number" name="total_KiloMeter" value="{{ old('total_KiloMeter', $booking->total_KiloMeter ?? '') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('total_KiloMeter')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Special Requests</label>
                            <textarea name="special_requests" rows="4" 
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('special_requests', $booking->special_requests) }}</textarea>
                            @error('special_requests')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="mt-10">
                    <button type="submit" 
                            class="w-full bg-blue-600 text-white py-4 rounded-2xl font-semibold text-lg hover:bg-blue-700 transition">
                        Update Booking
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection