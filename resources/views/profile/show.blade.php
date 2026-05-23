@extends('layouts.app')

@section('title', 'My Profile - SriTravel')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">

        <!-- Header -->
        <div class="px-8 py-6 bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
            <h1 class="text-3xl font-semibold">My Profile</h1>
            <p class="text-blue-100 mt-1">Manage your account information</p>
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

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                <!-- Profile Information -->
                <div>
                    <h3 class="text-xl font-semibold mb-6 text-gray-800">Profile Information</h3>
                    
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Profile Photo -->
                        <div class="mb-8 flex flex-col items-center">
                            <div class="relative mb-4">
                                <img src="{{ auth()->user()->profile_photo ? asset('storage/'.auth()->user()->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&size=128&background=3b82f6&color=fff' }}" 
                                     class="w-32 h-32 rounded-2xl object-cover border-4 border-white shadow-md" alt="Profile Photo">
                            </div>
                            <input type="file" name="profile_photo" accept="image/*" 
                                   class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            @error('profile_photo')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500">
                                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500">
                                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}" 
                                       class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500">
                                @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea name="address" rows="3" 
                                          class="w-full border border-gray-300 rounded-xl px-5 py-3 focus:ring-2 focus:ring-blue-500">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                                @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" 
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-xl transition">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Update Password -->
                <div>
                    <h3 class="text-xl font-semibold mb-6 text-gray-800">Change Password</h3>
                    
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                <input type="password" name="current_password" 
                                       class="w-full border border-gray-300 rounded-xl px-5 py-3">
                                @error('current_password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" name="password" 
                                       class="w-full border border-gray-300 rounded-xl px-5 py-3">
                                @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                <input type="password" name="password_confirmation" 
                                       class="w-full border border-gray-300 rounded-xl px-5 py-3">
                                @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>

                            <button type="submit" 
                                    class="w-full bg-gray-800 hover:bg-gray-900 text-white font-semibold py-4 rounded-xl transition">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!-- Delete Account -->
            <div class="mt-12 pt-8 border-t border-red-100">
                <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                    <h3 class="text-red-700 font-semibold mb-2">Danger Zone</h3>
                    <p class="text-red-600 text-sm mb-5">Once your account is deleted, all of your data will be permanently deleted.</p>
                    
                    <form action="{{ route('profile.destroy') }}" method="POST" 
                          onsubmit="return confirm('⚠️ Are you sure? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white rounded-xl transition">
                            Delete My Account
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection