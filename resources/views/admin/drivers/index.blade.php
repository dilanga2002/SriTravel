@extends('layouts.admin')

@section('title', 'Drivers - SriTravel Admin')
@section('page_title', 'Drivers Management')

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
                    <h2 class="text-2xl font-semibold text-gray-800">All Drivers</h2>
                    <p class="text-gray-500">Manage your driver roster</p>
                </div>
                
                <a href="{{ route('admin.drivers.create') }}" 
                   class="inline-flex items-center px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    <i class="fas fa-plus mr-2"></i> Add New Driver
                </a>
            </div>

            @if($drivers->isEmpty())
                <div class="text-center py-16">
                    <i class="fas fa-users text-6xl text-gray-200 mb-4"></i>
                    <h3 class="text-xl font-medium text-gray-700">No drivers found</h3>
                    <p class="text-gray-500 mt-2">There are no drivers to display. Add a new driver to get started.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Photo</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">License</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($drivers as $driver)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    @if($driver->driver_photo)
                                        <img src="{{ asset('storage/'.$driver->driver_photo) }}" 
                                             class="w-12 h-12 rounded-full object-cover" alt="">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400 text-2xl"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium">{{ $driver->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $driver->email }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $driver->phone ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 font-medium">
                                    {{ $driver->license_number ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        {{ $driver->status == 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($driver->status ?? 'inactive') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.drivers.edit', $driver->id) }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.drivers.destroy', $driver->id) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Are you sure you want to delete this driver?')">
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
                    {{ $drivers->links() }}
                </div>
            @endif
        </div>
    </div>

@endsection