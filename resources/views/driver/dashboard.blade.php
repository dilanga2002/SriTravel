@extends('layouts.app')

@section('title', 'Driver Dashboard - SriTravel')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-3xl font-semibold mb-2">Welcome, {{ auth()->user()->name }} 👋</h1>
    <p class="text-gray-600 mb-8">Driver Dashboard</p>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Today's Assignments</p>
            <p class="text-5xl font-bold text-blue-600 mt-3">{{ $todayAssignmentsCount }}</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Completed Trips</p>
            <p class="text-5xl font-bold text-green-600 mt-3">{{ $completedTrips }}</p>
        </div>
        
        <div class="bg-white rounded-2xl shadow p-6">
            <p class="text-gray-500">Upcoming Trips</p>
            <p class="text-5xl font-bold text-amber-600 mt-3">{{ $upcomingAssignments->count() }}</p>
        </div>
    </div>

    <!-- Today's Assignments -->
    <div class="mb-10">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Today's Assignments ({{ $todayAssignmentsCount }})</h2>
        </div>

        @if($todayAssignments->isEmpty())
            <div class="bg-white rounded-2xl shadow p-10 text-center">
                <p class="text-gray-500">No assignments for today.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($todayAssignments as $booking)
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="font-semibold">{{ $booking->vehicle->make ?? '' }} {{ $booking->vehicle->model ?? '' }}</p>
                                <p class="text-sm text-gray-500">{{ $booking->user->name ?? 'Unknown' }}</p>
                            </div>
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700">Today</span>
                        </div>
                        <p class="text-sm mt-4">{{ $booking->pickup_location }} → {{ $booking->dropoff_location }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Upcoming Assignments -->
    <div>
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold">Upcoming Assignments ({{ $upcomingAssignments->count() }})</h2>
        </div>
        
        @if($upcomingAssignments->isEmpty())
            <div class="bg-white rounded-2xl shadow p-10 text-center">
                <p class="text-gray-500">No upcoming assignments.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($upcomingAssignments as $booking)
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div>
                            <p class="font-semibold">{{ $booking->vehicle->make ?? '' }} {{ $booking->vehicle->model ?? '' }}</p>
                            <p class="text-sm text-gray-500">{{ $booking->start_date->format('M d, Y') }}</p>
                            <p class="text-sm text-gray-600">{{ $booking->user->name ?? 'Unknown' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>
@endsection