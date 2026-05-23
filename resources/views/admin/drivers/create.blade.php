@extends('layouts.admin')

@section('title', 'Add New Driver - SriTravel Admin')
@section('page_title', 'Add New Driver')

@section('content')

    <div class="max-w-4xl mx-auto">
        
        <div class="bg-white rounded-xl shadow">

            <!-- Form Header -->
            <div class="px-8 py-6 border-b">
                <h2 class="text-2xl font-semibold">Add New Driver</h2>
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

                <form action="{{ route('admin.drivers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                        <!-- Personal Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Personal Information</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" value="{{ old('name') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Enter full name">
                                    @error('name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                    <input type="email" name="email" value="{{ old('email') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('email')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone <span class="text-red-500">*</span></label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="0771234567">
                                    @error('phone')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <textarea name="address" rows="3" 
                                              class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Driver Information -->
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Driver Information</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">License Number <span class="text-red-500">*</span></label>
                                    <input type="text" name="license_number" value="{{ old('license_number') }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('license_number')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('password')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password <span class="text-red-500">*</span></label>
                                    <input type="password" name="password_confirmation" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                                    @error('password_confirmation')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Driver Photo</label>
                                    <input type="file" name="driver_photo" accept="image/*"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                    @error('driver_photo')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Buttons -->
                    <div class="mt-10 flex justify-end gap-4">
                        <a href="{{ route('admin.drivers.index') }}" 
                           class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition font-medium">
                            Save Driver
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection