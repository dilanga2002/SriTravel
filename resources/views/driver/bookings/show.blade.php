@extends('layouts.app')

@section('title', 'Assignment Details - Driver Panel')

@section('content')

    <div class="max-w-5xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-xl shadow p-6 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h1 class="text-3xl font-semibold">Assignment Bk-{{ $booking->id }}</h1>
            </div>
            <div class="flex gap-3 mt-4 sm:mt-0">
                <a href="{{ route('driver.bookings.index') }}" 
                   class="inline-flex items-center px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                    ← Back
                </a>
                
                @if($booking->status == 'confirmed')
                    <form action="{{ route('driver.bookings.complete', $booking->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Mark as Completed
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-8">

            <!-- Status -->
            <div class="mb-8">
                @if($booking->status == 'confirmed')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-700">Confirmed</span>
                @elseif($booking->status == 'pending')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                @elseif($booking->status == 'cancelled')
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-700">Cancelled</span>
                @else
                    <span class="px-4 py-2 text-sm font-semibold rounded-full bg-purple-100 text-purple-700">Completed</span>
                @endif
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <!-- Customer Details -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-user"></i> Customer Details
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Name</span>
                            <span class="font-medium">{{ $booking->user->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Email</span>
                            <span class="font-medium">{{ $booking->user->email }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phone</span>
                            <span class="font-medium">{{ $booking->user->phone ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Details -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <i class="fas fa-car"></i> Vehicle Details
                    </h3>
                    <div class="bg-gray-50 rounded-xl p-6 space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Vehicle</span>
                            <span class="font-medium">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Registration</span>
                            <span class="font-medium">{{ $booking->vehicle->registration_number }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Trip Details -->
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-4">Trip Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 rounded-xl p-5">
                        <p class="text-gray-500 text-sm">Start Date</p>
                        <p class="text-xl font-medium">{{ $booking->start_date->format('M d, Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5">
                        <p class="text-gray-500 text-sm">End Date</p>
                        <p class="text-xl font-medium">{{ $booking->end_date->format('M d, Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-5">
                        <p class="text-gray-500 text-sm">Total Days</p>
                        <p class="text-xl font-medium">{{ $booking->total_days }} day{{ $booking->total_days > 1 ? 's' : '' }}</p>
                    </div>
                </div>
            </div>

            <!-- Pickup & Dropoff -->
            <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold mb-3">Pickup Location</h3>
                    <div class="bg-gray-50 rounded-xl p-5">{{ $booking->pickup_location }}</div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-3">Dropoff Location</h3>
                    <div class="bg-gray-50 rounded-xl p-5">{{ $booking->dropoff_location }}</div>
                </div>
            </div>

            <!-- Special Requests -->
            @if($booking->special_requests)
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-4">Special Requests</h3>
                <div class="bg-gray-50 rounded-xl p-6">{{ $booking->special_requests }}</div>
            </div>
            @endif

        </div>
    </div>

@endsection