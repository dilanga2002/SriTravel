@extends('layouts.app')

@section('title', 'Customer Dashboard - SriTravel')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Welcome Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-semibold text-gray-800">Welcome back, {{ auth()->user()->name }} 👋</h1>
        <p class="text-gray-600 mt-1">Here's what's happening with your bookings</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500 text-sm">Total Bookings</p>
            <p class="text-4xl font-bold text-gray-800 mt-2">{{ $totalBookingsCount }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500 text-sm">Active Bookings</p>
            <p class="text-4xl font-bold text-blue-600 mt-2">{{ $currentBookings->count() }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500 text-sm">Completed Trips</p>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $completedBookingsCount }}</p>
        </div>
    </div>

    <!-- Current Bookings -->
    <div class="mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Current Bookings</h2>
            <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:underline">View All →</a>
        </div>

        @if($currentBookings->isEmpty())
            <div class="bg-white rounded-2xl shadow p-12 text-center">
                <p class="text-gray-500">You don't have any active bookings.</p>
                <a href="{{ route('vehicles.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-3 rounded-xl">Book a Vehicle Now</a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($currentBookings as $booking)
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="flex justify-between">
                            <span class="px-3 py-1 text-xs rounded-full 
                                {{ $booking->status == 'confirmed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <h3 class="font-semibold mt-3">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</h3>
                        <p class="text-sm text-gray-500">{{ $booking->start_date->format('M d') }} - {{ $booking->end_date->format('M d, Y') }}</p>
                        <p class="text-lg font-bold mt-4">Rs. {{ number_format($booking->total_amount, 2) }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Recommended Vehicles -->
    <div>
        <h2 class="text-2xl font-semibold mb-4">Recommended for You</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($recommendedVehicles as $vehicle)
                <div class="bg-white rounded-2xl shadow overflow-hidden hover:shadow-xl transition">
                    @if($vehicle->image)
                        <img src="{{ asset('storage/'.$vehicle->image) }}" 
                             class="w-full h-48 object-cover" alt="{{ $vehicle->make }}">
                    @endif
                    <div class="p-5">
                        <h3 class="font-semibold">{{ $vehicle->make }} {{ $vehicle->model }}</h3>
                        <p class="text-sm text-gray-500">{{ $vehicle->year }} • {{ $vehicle->registration_number }}</p>
                        <p class="text-2xl font-bold mt-3">Rs. {{ number_format($vehicle->price_per_km, 2) }} <span class="text-sm font-normal">/km</span></p>
                        
                        <a href="{{ route('vehicles.show', $vehicle) }}" 
                           class="mt-4 block text-center bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700">
                            Book Now
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection