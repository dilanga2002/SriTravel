@extends('layouts.admin')

@section('title', 'Bookings - SriTravel Admin')
@section('page_title', 'Booking Management')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            
            <!-- Page Header -->
            <div class="px-6 py-5 border-b flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">All Bookings</h2>
                    <p class="text-gray-500">Manage customer bookings</p>
                </div>
                
                <!-- Status Filter -->
                <div class="mt-4 sm:mt-0">
                    <select id="statusFilter" 
                            class="border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            </div>

            @if($bookings->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-calendar-times text-6xl text-gray-200 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-700">No bookings found</h3>
                    <p class="text-gray-500 mt-2">There are no bookings to display.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Booking ID</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Dates</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">Bk-{{ $booking->id }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @php $user = $booking->user; @endphp
                                        <img class="h-9 w-9 rounded-full mr-3 object-cover" 
                                             src="{{ $user && $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user?->name ?? 'Unknown') }}" 
                                             alt="">
                                        <div>
                                            <div class="font-medium">{{ $user?->name ?? 'Unknown User' }}</div>
                                            <div class="text-sm text-gray-500">{{ $user?->email ?? 'N/A' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $booking->vehicle?->make ?? 'N/A' }} {{ $booking->vehicle?->model ?? '' }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->vehicle?->registration_number ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    {{ $booking->start_date?->format('M d, Y') ?? 'N/A' }}<br>
                                    <span class="text-gray-500">to {{ $booking->end_date?->format('M d, Y') ?? 'N/A' }}</span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900">
                                    Rs. {{ number_format($booking->total_amount ?? 0, 2) }}
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
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($booking->status == 'pending')
                                        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">Confirm</button>
                                        </form>

                                        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">Cancel</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection

@push('scripts')
<script>
function filterBookings(status) {
    let url = "{{ route('admin.bookings.index') }}";
    
    if (status) {
        url += "?status=" + encodeURIComponent(status);
    }
    
    window.location.href = url;
}
</script>
@endpush