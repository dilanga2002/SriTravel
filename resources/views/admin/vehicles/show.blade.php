@extends('layouts.admin')

@section('title', 'Vehicle Details - SriTravel Admin')
@section('page_title', '{{ $vehicle->make }} {{ $vehicle->model }}')

@section('content')

    <div class="max-w-5xl mx-auto">

        <!-- Action Buttons -->
        <div class="flex gap-3 mb-6">
            <a href="{{ route('admin.vehicles.index') }}" 
               class="inline-flex items-center px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                ← Back to Vehicles
            </a>
            
            <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" 
               class="inline-flex items-center px-5 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition">
                <i class="fas fa-edit mr-2"></i> Edit Vehicle
            </a>

            <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                    <i class="fas fa-trash mr-2"></i> Delete
                </button>
            </form>
        </div>

        <div class="bg-white rounded-xl shadow">

            <!-- Vehicle Header -->
            <div class="px-8 py-6 border-b bg-gray-50 rounded-t-xl flex justify-between items-center">
                <div>
                    <h2 class="text-3xl font-semibold">{{ $vehicle->make }} {{ $vehicle->model }}</h2>
                    <p class="text-gray-600">{{ $vehicle->registration_number }} • {{ ucfirst($vehicle->type) }}</p>
                </div>
                <div>
                    @if($vehicle->available)
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-green-100 text-green-700">Available</span>
                    @else
                        <span class="px-4 py-2 text-sm font-semibold rounded-full bg-red-100 text-red-700">Not Available</span>
                    @endif
                </div>
            </div>

            <div class="p-8">

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                    <!-- Image -->
                    <div>
                        @if($vehicle->image)
                            <img src="{{ asset('storage/'.$vehicle->image) }}" 
                                 class="w-full rounded-xl shadow-md" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                        @else
                            <div class="w-full h-80 bg-gray-200 rounded-xl flex items-center justify-center">
                                <i class="fas fa-car text-6xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Vehicle Info -->
                    <div class="space-y-8">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Vehicle Specifications</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <span class="text-gray-500">Make</span>
                                    <p class="font-medium">{{ $vehicle->make }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <span class="text-gray-500">Model</span>
                                    <p class="font-medium">{{ $vehicle->model }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <span class="text-gray-500">Year</span>
                                    <p class="font-medium">{{ $vehicle->year }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <span class="text-gray-500">Type</span>
                                    <p class="font-medium">{{ ucfirst($vehicle->type) }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <span class="text-gray-500">Registration</span>
                                    <p class="font-medium">{{ $vehicle->registration_number }}</p>
                                </div>
                                <div class="bg-gray-50 p-4 rounded-xl">
                                    <span class="text-gray-500">Price per km</span>
                                    <p class="font-medium">Rs. {{ number_format($vehicle->price_per_km, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        @if($vehicle->description)
                        <div>
                            <h3 class="text-lg font-semibold mb-3">Description</h3>
                            <div class="bg-gray-50 p-5 rounded-xl leading-relaxed">
                                {{ $vehicle->description }}
                            </div>
                        </div>
                        @endif

                        <!-- Availability Toggle -->
                        <div>
                            <form action="{{ route('admin.vehicles.toggle', $vehicle->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="available" value="1" 
                                           {{ $vehicle->available ? 'checked' : '' }} 
                                           onchange="this.form.submit()" 
                                           class="w-5 h-5 text-blue-600">
                                    <span class="ml-3 text-sm font-medium text-gray-700">
                                        Available for booking
                                    </span>
                                </label>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="mt-12">
                    <h3 class="text-lg font-semibold mb-4">Recent Bookings for this Vehicle</h3>
                    
                    @if($vehicle->bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($vehicle->bookings->sortByDesc('created_at')->take(5) as $booking)
                                    <tr>
                                        <td class="px-6 py-4">#BK-{{ $booking->id }}</td>
                                        <td class="px-6 py-4">{{ $booking->user->name }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 font-medium">Rs. {{ number_format($booking->total_amount, 2) }}</td>
                                        <td class="px-6 py-4">
                                            @if($booking->status == 'confirmed')
                                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">Confirmed</span>
                                            @elseif($booking->status == 'pending')
                                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">Pending</span>
                                            @else
                                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700">Cancelled</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-xl">
                            <p class="text-gray-500">No recent bookings for this vehicle.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

@endsection