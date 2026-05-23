@extends('layouts.admin')

@section('title', 'Add New Vehicle - SriTravel Admin')
@section('page_title', 'Add New Vehicle')

@section('content')

    <div class="max-w-4xl mx-auto">
        
        <div class="bg-white rounded-xl shadow">

            <!-- Form Header -->
            <div class="px-8 py-6 border-b">
                <h2 class="text-2xl font-semibold">Add New Vehicle</h2>
            </div>

            <div class="p-8">

                @if ($errors->any())
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-lg">
                        <strong>Whoops! Something went wrong.</strong>
                        <ul class="list-disc list-inside mt-2 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('admin.vehicles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- Basic Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Make <span class="text-red-500">*</span></label>
                                    <input type="text" name="make" value="{{ old('make') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('make')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Model <span class="text-red-500">*</span></label>
                                    <input type="text" name="model" value="{{ old('model') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('model')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Year <span class="text-red-500">*</span></label>
                                    <input type="number" name="year" value="{{ old('year') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('year')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Registration Number <span class="text-red-500">*</span></label>
                                    <input type="text" name="registration_number" value="{{ old('registration_number') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('registration_number')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Details -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Vehicle Details</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Type <span class="text-red-500">*</span></label>
                                    <select name="type" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                        <option value="">Select Type</option>
                                        <option value="car" {{ old('type') == 'car' ? 'selected' : '' }}>Car</option>
                                        <option value="cab" {{ old('type') == 'cab' ? 'selected' : '' }}>Cab</option>
                                        <option value="van" {{ old('type') == 'van' ? 'selected' : '' }}>Van</option>
                                        <option value="minibus" {{ old('type') == 'minibus' ? 'selected' : '' }}>MiniBus</option>
                                        <option value="bus" {{ old('type') == 'bus' ? 'selected' : '' }}>Bus</option>
                                    </select>
                                    @error('type')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Price Per km (LKR) <span class="text-red-500">*</span></label>
                                    <input type="number" name="price_per_km" value="{{ old('price_per_km') }}" step="0.01"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('price_per_km')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Passengers <span class="text-red-500">*</span></label>
                                    <input type="number" name="passengers" value="{{ old('passengers') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('passengers')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Features (comma separated)</label>
                                    <input type="text" name="features" value="{{ old('features') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3"
                                           placeholder="AC, GPS, WiFi, etc.">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description & Availability -->
                    <div class="mt-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="4" 
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('description') }}</textarea>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <input type="checkbox" name="available" id="available" value="1" {{ old('available', 1) ? 'checked' : '' }}>
                        <label for="available" class="text-sm font-medium text-gray-700">Available for booking</label>
                    </div>

                    <!-- Vehicle Image -->
                    <div class="mt-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Vehicle Image</label>
                        <input type="file" name="image" accept="image/*" 
                               class="w-full border border-gray-300 rounded-lg px-4 py-3">
                        @error('image')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Form Buttons -->
                    <div class="mt-10 flex justify-end gap-4">
                        <a href="{{ route('admin.vehicles.index') }}" 
                           class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Add Vehicle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection