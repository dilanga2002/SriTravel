@extends('layouts.app')

@section('title', $vehicle->make . ' ' . $vehicle->model . ' - SriTravel')
@section('content')

    <div class="max-w-6xl mx-auto">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('vehicles.index') }}" 
               class="inline-flex items-center px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                ← Back to Vehicles
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

            <!-- Vehicle Image -->
            <div class="bg-white rounded-2xl shadow overflow-hidden">
                @if($vehicle->image)
                    <img src="{{ asset('storage/'.$vehicle->image) }}" 
                         class="w-full h-full object-cover" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                @else
                    <div class="h-96 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-car text-8xl text-gray-300"></i>
                    </div>
                @endif
            </div>

            <!-- Vehicle Information -->
            <div class="bg-white rounded-2xl shadow p-8">

                <h1 class="text-4xl font-bold">{{ $vehicle->make }} {{ $vehicle->model }}</h1>
                <p class="text-gray-600 text-xl mt-1">{{ ucfirst($vehicle->type) }} • {{ $vehicle->year }}</p>

                <div class="mt-6 flex items-baseline gap-2">
                    <span class="text-4xl font-bold">Rs. {{ number_format($vehicle->price_per_km, 2) }}</span>
                    <span class="text-gray-500">/ per km</span>
                </div>

                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Description</h3>
                    <p class="text-gray-600 leading-relaxed">
                        {{ $vehicle->description ?? 'This vehicle offers comfort, reliability, and style for your journey across Sri Lanka.' }}
                    </p>
                </div>

                <!-- Features -->
                @if(!empty($vehicle->features))
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Key Features</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($vehicle->features as $feature)
                            <div class="flex items-center gap-2 text-sm">
                                <i class="fas fa-check text-green-500"></i>
                                <span>{{ $feature }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Book Now Section -->
                <div class="mt-10 pt-8 border-t">
                    @auth
                        <a href="{{ route('bookings.create', ['vehicle_id' => $vehicle->id]) }}" 
                           class="block w-full text-center py-4 bg-blue-600 text-white text-lg font-semibold rounded-2xl hover:bg-blue-700 transition">
                            Book This Vehicle
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="block w-full text-center py-4 bg-blue-600 text-white text-lg font-semibold rounded-2xl hover:bg-blue-700 transition">
                            Sign In to Book
                        </a>
                    @endauth
                </div>

            </div>
        </div>

    </div>

@endsection