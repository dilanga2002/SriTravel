@extends('layouts.app')

@section('title', 'Available Vehicles - SriTravel')

@section('content')

    <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow p-8 mb-8">
            <h1 class="text-3xl font-semibold">Available Vehicles</h1>
            <p class="text-gray-600 mt-2">Browse and book from our wide selection of vehicles</p>
            
            <div class="mt-4 flex items-center gap-4">
                <span class="text-lg font-medium">{{ $vehicles->total() }} vehicles available</span>
                @auth
                    <a href="{{ route('bookings.index') }}" class="text-blue-600 hover:underline">My Bookings →</a>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign In to Book</a>
                @endauth
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl shadow p-6 mb-8">
            <form action="{{ route('vehicles.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">

                <!-- Vehicle Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Type</label>
                    <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        <option value="">All Types</option>
                        <option value="car" {{ request('type') == 'car' ? 'selected' : '' }}>Car</option>
                        <option value="cab" {{ request('type') == 'cab' ? 'selected' : '' }}>Cab</option>
                        <option value="van" {{ request('type') == 'van' ? 'selected' : '' }}>Van</option>
                        <option value="minibus" {{ request('type') == 'minibus' ? 'selected' : '' }}>MiniBus</option>
                        <option value="bus" {{ request('type') == 'bus' ? 'selected' : '' }}>Bus</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Range (per km)</label>
                    <div class="flex gap-3">
                        <input type="number" name="min_price" value="{{ request('min_price') }}" 
                               placeholder="Min" step="0.01"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        <input type="number" name="max_price" value="{{ request('max_price') }}" 
                               placeholder="Max" step="0.01"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3">
                    </div>
                </div>

                <!-- Start Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <!-- End Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                </div>

                <!-- Submit Button -->
                <div class="flex items-end">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg transition font-medium">
                        Apply Filters
                    </button>
                </div>

            </form>
        </div>

        <!-- Vehicles Grid -->
        @if($vehicles->isEmpty())
            <div class="bg-white rounded-xl shadow py-16 text-center">
                <i class="fas fa-car text-6xl text-gray-200 mb-4"></i>
                <h3 class="text-xl font-medium">No Vehicles Available</h3>
                <p class="text-gray-500 mt-2">No vehicles available for the selected dates. Please try different dates.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($vehicles as $vehicle)
                    <div class="bg-white rounded-xl shadow overflow-hidden hover:shadow-xl transition">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/'.$vehicle->image) }}" 
                                 class="w-full h-48 object-cover" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                        @endif
                        
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-3">
                                <span class="inline-block px-3 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded-full">
                                    {{ ucfirst($vehicle->type) }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-semibold">{{ $vehicle->make }} {{ $vehicle->model }}</h3>
                            <p class="text-gray-500">{{ $vehicle->year }} • {{ $vehicle->registration_number }}</p>
                            
                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <p class="text-2xl font-bold text-gray-800">
                                        Rs. {{ number_format($vehicle->price_per_km, 2) }}
                                    </p>
                                    <p class="text-xs text-gray-500">per km</p>
                                </div>
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" 
                                   class="px-6 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition">
                                    {{ auth()->check() ? 'Book Now' : 'View Details' }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8 flex justify-center">
                {{ $vehicles->links() }}
            </div>
        @endif
    </div>

@endsection