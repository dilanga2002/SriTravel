@extends('layouts.admin')

@section('title', 'Customer Details - SriTravel Admin')
@section('page_title', 'Customer Details')

@section('content')

    <div class="max-w-4xl mx-auto">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.customers.index') }}" 
               class="inline-flex items-center px-5 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg transition">
                ← Back to Customers
            </a>
        </div>

        <div class="bg-white rounded-xl shadow overflow-hidden">

            <!-- Header -->
            <div class="px-8 py-6 border-b bg-gray-50">
                <div class="flex items-center gap-4">
                    <img class="w-16 h-16 rounded-2xl object-cover" 
                         src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=128' }}" 
                         alt="{{ $user->name }}">
                    <div>
                        <h2 class="text-3xl font-semibold">{{ $user->name }}</h2>
                        <p class="text-gray-600">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <div class="p-8">

                <!-- Customer Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Profile Information</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between py-3 border-b">
                                <span class="text-gray-600">Customer ID</span>
                                <span class="font-medium">Cus-{{ $user->id }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b">
                                <span class="text-gray-600">Registered On</span>
                                <span class="font-medium">{{ $user->created_at->format('M d, Y H:i:s') }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b">
                                <span class="text-gray-600">Last Updated</span>
                                <span class="font-medium">{{ $user->updated_at->format('M d, Y H:i:s') }}</span>
                            </div>
                            @if($user->phone)
                            <div class="flex justify-between py-3 border-b">
                                <span class="text-gray-600">Phone</span>
                                <span class="font-medium">{{ $user->phone }}</span>
                            </div>
                            @endif
                            @if($user->address)
                            <div class="flex justify-between py-3 border-b">
                                <span class="text-gray-600">Address</span>
                                <span class="font-medium text-right">{{ $user->address }}</span>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Account Summary -->
<div>
    <h3 class="text-lg font-semibold mb-4">Account Summary</h3>
    <div class="bg-gray-50 rounded-2xl p-6">
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500">Total Bookings</p>
                <p class="text-5xl font-bold text-gray-800 mt-2">{{ $user->bookings->count() }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Active Bookings</p>
                <p class="text-5xl font-bold text-blue-600 mt-2">
                    {{ $user->bookings->whereIn('status', ['pending', 'confirmed'])->count() }}
                </p>
            </div>
        </div>

        @if($user->bookings->isNotEmpty())
            <div class="mt-6 pt-6 border-t">
                <h4 class="font-medium mb-3">Recent Bookings</h4>
                <div class="space-y-3 max-h-64 overflow-y-auto">
                    @foreach($user->bookings->take(5) as $booking)
                        <div class="flex justify-between items-center text-sm">
                            <div>
                                <span class="font-medium">Bk{{ $booking->id }}</span> 
                                <span class="text-gray-600">{{ $booking->vehicle->make ?? '' }} {{ $booking->vehicle->model ?? '' }}</span>
                            </div>
                            <span class="text-gray-500">{{ $booking->start_date->format('M d, Y') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <p class="text-sm text-gray-500 mt-4">This customer has no bookings yet.</p>
        @endif
    </div>
</div>

                <!-- Danger Zone -->
                <div class="mt-12 border border-red-200 rounded-xl p-6 bg-red-50">
                    <h3 class="text-red-700 font-semibold mb-2">Danger Zone</h3>
                    <p class="text-red-600 text-sm mb-4">Once deleted, this customer and all associated data cannot be recovered.</p>
                    
                    <form action="{{ route('admin.customers.destroy', $user->id) }}" method="POST" 
                          onsubmit="return confirm('⚠️ Are you sure you want to permanently delete this customer?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                            <i class="fas fa-trash mr-2"></i> Delete Customer
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection