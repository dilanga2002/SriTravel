@extends('layouts.admin')

@section('title', 'Vehicles - SriTravel Admin')
@section('page_title', 'Vehicle Management')

@section('content')

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto">
        
        <div class="bg-white rounded-xl shadow overflow-hidden">
            
            <!-- Page Header -->
            <div class="px-6 py-5 border-b flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-800">All Vehicles</h2>
                    <p class="text-gray-500">Manage your vehicle fleet</p>
                </div>
                
                <a href="{{ route('admin.vehicles.create') }}" 
                   class="inline-flex items-center px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> Add New Vehicle
                </a>
            </div>

            @if($vehicles->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-car text-6xl text-gray-200 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-700">No vehicles found</h3>
                    <p class="text-gray-500 mt-2">There are no vehicles to display.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Vehicle</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Registration</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Price / km</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($vehicles as $vehicle)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($vehicle->image)
                                            <img src="{{ asset('storage/'.$vehicle->image) }}" 
                                                 class="w-12 h-12 rounded-lg object-cover mr-4" alt="">
                                        @endif
                                        <div>
                                            <div class="font-medium">{{ $vehicle->make }} {{ $vehicle->model }}</div>
                                            <div class="text-sm text-gray-500">{{ $vehicle->year }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex px-3 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                        {{ ucfirst($vehicle->type) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 font-medium">{{ $vehicle->registration_number }}</td>
                                <td class="px-6 py-4 font-semibold">
                                    Rs. {{ number_format($vehicle->price_per_km, 2) }}
                                </td>
                                <td class="px-6 py-4">
                                    @if($vehicle->available)
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Available</span>
                                    @else
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-700">Not Available</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.vehicles.show', $vehicle->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.vehicles.edit', $vehicle->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-amber-600 text-white text-sm rounded-lg hover:bg-amber-700">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this vehicle?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t">
                    {{ $vehicles->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection