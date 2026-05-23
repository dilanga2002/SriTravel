@extends('layouts.app')

@section('title', 'My Assignments - Driver Panel')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Page Header -->
    <div class="bg-white rounded-xl shadow p-6 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
        <div>
            <h1 class="text-3xl font-semibold">My Assignments</h1>
            <p class="text-gray-500">Manage your assigned bookings</p>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

        <!-- Filter (Auto Submit) -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <form action="{{ route('driver.bookings.index') }}" method="GET" id="filterForm" class="max-w-xs">
            <select name="status" id="statusFilter" 
                    class="border border-gray-300 rounded-lg px-5 py-4 ">
                <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </div>

    @if($bookings->isEmpty())
        <div class="bg-white rounded-xl shadow py-16 text-center">
            <i class="fas fa-calendar-times text-6xl text-gray-200 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-700">You don't have any assignments yet</h3>
        </div>
    @else
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Trip Dates</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Pickup Location</th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-medium">Bk-{{ $booking->id }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium">{{ $booking->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->user->phone ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</div>
                                <div class="text-sm text-gray-500">{{ $booking->vehicle->registration_number }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                {{ $booking->start_date->format('M d, Y') }}<br>
                                to {{ $booking->end_date->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">{{ $booking->pickup_location }}</td>
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
                                <a href="{{ route('driver.bookings.show', $booking) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                    <i class="fas fa-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t">
                {{ $bookings->links() }}
            </div>
        </div>
    @endif
</div>

<script>
    // Auto filter when status changes
    document.getElementById('statusFilter').addEventListener('change', function() {
        this.form.submit();
    });
</script>

@endsection