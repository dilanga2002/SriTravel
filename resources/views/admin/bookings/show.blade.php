@extends('layouts.admin')

@section('title', 'Booking Details - SriTravel Admin')
@section('page_title', 'Booking Bk-' . $booking->id)

@section('content')

    <div class="max-w-5xl mx-auto">

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-3 mb-6">
            <a href="{{ route('admin.bookings.index') }}" 
               class="inline-flex items-center px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                ← Back to Bookings
            </a>

            @if($booking->status == 'pending')
                <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-5 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Accept Booking
                    </button>
                </form>

                <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                        Reject Booking
                    </button>
                </form>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow">

            <!-- Booking Header -->
            <div class="px-6 py-5 border-b bg-gray-50 rounded-t-xl flex justify-between items-center">
                <h2 class="text-2xl font-semibold">Booking Information</h2>
                <div>
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
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                    <!-- Customer Details -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <i class="fas fa-user"></i> Customer Details
                        </h3>
                        <div class="bg-gray-50 rounded-xl p-5 space-y-3">
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
                                <span class="font-medium">{{ $booking->user->phone ?? 'No phone provided' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Details -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                            <i class="fas fa-car"></i> Vehicle Details
                        </h3>
                        <div class="bg-gray-50 rounded-xl p-5 space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Vehicle</span>
                                <span class="font-medium">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Registration</span>
                                <span class="font-medium">{{ $booking->vehicle->registration_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Type</span>
                                <span class="font-medium">{{ ucfirst($booking->vehicle->type) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Price per km</span>
                                <span class="font-medium">Rs. {{ number_format($booking->vehicle->price_per_km, 2) }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Rental Period -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Rental Period</h3>
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
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Pickup Location</h3>
                        <div class="bg-gray-50 rounded-xl p-5">{{ $booking->pickup_location }}</div>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Dropoff Location</h3>
                        <div class="bg-gray-50 rounded-xl p-5">{{ $booking->dropoff_location }}</div>
                    </div>
                </div>

                <!-- Assigned Driver -->
                @if($booking->driver)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Assigned Driver</h3>
                    <div class="bg-gray-50 rounded-xl p-5">
                        <p class="font-medium">{{ $booking->driver->name }}</p>
                        <p class="text-sm text-gray-600">License: {{ $booking->driver->license_number }}</p>
                    </div>
                </div>
                @endif

                <!-- Special Requests -->
                @if($booking->special_requests)
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Special Requests</h3>
                    <div class="bg-gray-50 rounded-xl p-5">{{ $booking->special_requests }}</div>
                </div>
                @endif

                <!-- Payment Summary -->
                <div class="mt-10 border-t pt-8">
                    <h3 class="text-lg font-semibold mb-4">Payment Summary</h3>
                    <div class="bg-gray-900 text-white rounded-2xl p-8">
                        <div class="flex justify-between text-xl">
                            <span>Total Amount</span>
                            <span class="font-bold">Rs. {{ number_format($booking->total_amount, 2) }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection