@extends('layouts.app')

@section('title', 'Driver Profile - SriTravel')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

        <!-- Header -->
        <div class="px-8 py-6 bg-gradient-to-r from-blue-700 to-indigo-700 text-white">
            <h1 class="text-3xl font-semibold">Driver Profile</h1>
            <p class="text-blue-100 mt-1">Manage your personal & driving information</p>
        </div>

        <div class="p-8">

            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-5 py-4 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-5 py-4 rounded-xl">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                    <!-- Left Column -->
                    <div>
                        <h3 class="text-xl font-semibold mb-6">Personal Information</h3>

                        <!-- Profile Photo -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Profile Photo</label>
                            <div class="flex items-center gap-6">
                                @if($user->profile_photo)
                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                                         class="w-24 h-24 rounded-2xl object-cover border-4 border-white shadow">
                                @else
                                    <div class="w-24 h-24 bg-gray-200 rounded-2xl flex items-center justify-center text-4xl font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <input type="file" name="profile_photo" accept="image/*" 
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div>
                        <h3 class="text-xl font-semibold mb-6">Driving Information</h3>

                        <div class="space-y-6">
                            <!-- License Number - Read Only -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">License Number</label>
                                <input type="text" value="{{ $user->license_number }}" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-100 cursor-not-allowed" 
                                       readonly>
                                <p class="text-xs text-gray-500 mt-1">License number cannot be changed.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea name="address" rows="4" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <!-- Password Change -->
                            <div class="pt-6 border-t">
                                <h4 class="font-medium mb-4">Change Password</h4>
                                <input type="password" name="current_password" placeholder="Current Password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl mb-3">
                                <input type="password" name="password" placeholder="New Password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl mb-3">
                                <input type="password" name="password_confirmation" placeholder="Confirm New Password" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-2xl transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection