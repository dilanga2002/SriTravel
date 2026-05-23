@extends('layouts.admin')

@section('title', 'Dashboard - SriTravel Admin')
@section('page_title', 'Dashboard')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto">
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            
            <!-- Total Vehicles -->
            <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Total Vehicles</p>
                        <p class="text-4xl font-bold text-gray-800 mt-3">{{ $vehicleCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-3xl">
                        <i class="fas fa-car"></i>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-4">{{ $vehiclePercentageChange ?? '0' }}% from last month</p>
            </div>

            <!-- Active Bookings -->
            <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Active Bookings</p>
                        <p class="text-4xl font-bold text-gray-800 mt-3">{{ $bookingCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center text-3xl">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-4">{{ $bookingPercentageChange ?? '0' }}% from last month</p>
            </div>

            <!-- Available Drivers -->
            <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-gray-500 text-sm">Available Drivers</p>
                        <p class="text-4xl font-bold text-gray-800 mt-3">{{ $driverCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center text-3xl">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-4">{{ $newDriversThisWeek ?? '0' }} new this week</p>
            </div>

        </div>

        <!-- Recent Bookings -->
        <div class="bg-white rounded-xl shadow">
            <div class="px-6 py-5 border-b flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-semibold">Recent Bookings</h2>
                    <p class="text-gray-500 text-sm">Latest customer bookings</p>
                </div>
                <a href="{{ route('admin.bookings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-eye mr-2"></i> View All
                </a>
            </div>

            @if($recentBookings->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-calendar-times text-6xl text-gray-200 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-700">No bookings found</h3>
                    <p class="text-gray-500 mt-1">There are no recent bookings to display.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($recentBookings as $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap font-medium">Bk-{{ $booking->id }}</td>
                                <td class="px-6 py-4">
    <div class="flex items-center">
        @php
            $user = $booking->user;
        @endphp
        <img class="h-8 w-8 rounded-full mr-3" 
             src="{{ $user && $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user?->name ?? 'Unknown') }}" 
             alt="">
        <div>
            <div class="font-medium">{{ $user?->name ?? 'Unknown User' }}</div>
            <div class="text-sm text-gray-500">{{ $user?->email ?? 'N/A' }}</div>
        </div>
    </div>
</td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->vehicle->registration_number }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $booking->start_date->format('M d, Y') }}<br>
                                    <span class="text-gray-500">to {{ $booking->end_date->format('M d, Y') }}</span>
                                </td>
                                <td class="px-6 py-4 font-medium">Rs. {{ number_format($booking->total_amount, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if($booking->status == 'confirmed')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Confirmed</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                    @elseif($booking->status == 'cancelled')
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Cancelled</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700">Completed</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-eye mr-1"></i> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

@endsection