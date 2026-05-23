@extends('layouts.app')

@section('title', 'My Bookings - SriTravel')

@section('content')

    <div class="max-w-7xl mx-auto">

        <!-- Page Header -->
        <div class="bg-white rounded-xl shadow p-6 mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h1 class="text-3xl font-semibold">My Bookings</h1>
                <p class="text-gray-500">View and manage your vehicle bookings</p>
            </div>
            <a href="{{ route('bookings.create') }}" 
               class="mt-4 sm:mt-0 inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <i class="fas fa-plus mr-2"></i> Book New Vehicle
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter -->
<div class="bg-white rounded-xl shadow p-6 mb-6">
    <form action="{{ route('bookings.index') }}" method="GET" class="flex items-center gap-4">
        <select name="status" id="statusFilter" 
                class="border border-gray-300 rounded-lg px-5 py-3">
            <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
        </select>       
    </form>
</div>

        @if($bookings->isEmpty())
            <div class="bg-white rounded-xl shadow py-16 text-center">
                <i class="fas fa-calendar-times text-6xl text-gray-200 mb-4"></i>
                <h3 class="text-xl font-medium text-gray-700">No bookings found</h3>
                <p class="text-gray-500 mt-2">You haven't made any bookings yet.</p>
                <a href="{{ route('vehicles.index') }}" 
                   class="mt-6 inline-block px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Book a Vehicle Now
                </a>
            </div>
        @else
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Created Date</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Trip Date</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Driver</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $booking->vehicle->make }} {{ $booking->vehicle->model }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->vehicle->registration_number }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $booking->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $booking->start_date ? $booking->start_date->format('M d, Y') : 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    @if($booking->driver)
                                        {{ $booking->driver->name }}
                                    @else
                                        <span class="text-gray-400">No driver assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-semibold">
                                    Rs. {{ number_format($booking->total_amount, 2) }}
                                </td>
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
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('bookings.show', $booking->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                        View
                                    </a>
                                    
                                    @if($booking->status == 'pending')
                                        <a href="{{ route('bookings.edit', $booking->id) }}" 
                                           class="inline-flex items-center px-4 py-2 bg-amber-600 text-white text-sm rounded-lg hover:bg-amber-700">
                                            Edit
                                        </a>
                                        
                                        <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700"
                                                    onclick="return confirm('Cancel this booking?')">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
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
document.getElementById('statusFilter').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endsection