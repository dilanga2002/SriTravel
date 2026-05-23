@extends('layouts.admin')

@section('title', 'Admin Profile - SriTravel')
@section('page_title', 'My Profile')

@section('content')
    <div class="max-w-4xl mx-auto">

        <div class="bg-white rounded-xl shadow">

            <!-- Header -->
            <div class="px-8 py-6 border-b bg-gray-50 rounded-t-xl">
                <h2 class="text-2xl font-semibold">My Profile</h2>
            </div>

            <div class="p-8">

                @if (session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">

                    <!-- Profile Information -->
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Profile Information</h3>
                        
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Profile Photo -->
                            <div class="mb-8">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Profile Photo</label>
                                <div class="flex items-center gap-6">
                                    <img src="{{ $user->profile_photo ? asset('storage/'.$user->profile_photo) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&size=128' }}" 
                                         class="w-24 h-24 rounded-2xl object-cover border" alt="Profile Photo">
                                    <input type="file" name="profile_photo" accept="image/*" 
                                           class="border border-gray-300 rounded-lg px-4 py-2">
                                </div>
                                @error('profile_photo')
                                    <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                    @error('name')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                    @error('email')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone</label>
                                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                    @error('phone')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                    <textarea name="address" rows="3" 
                                              class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('address', $user->address) }}</textarea>
                                    @error('address')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="pt-4">
                                    <button type="submit" 
                                            class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        Save Changes
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Update Password -->
                    <div>
                        <h3 class="text-lg font-semibold mb-6">Update Password</h3>
                        
                        <!-- Fixed: Now uses the same route as profile update -->
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Password</label>
                                    <input type="password" name="current_password" required
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                    @error('current_password')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                    <input type="password" name="password" required
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                    @error('password')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" required
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3">
                                    @error('password_confirmation')
                                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <button type="submit" 
                                            class="px-8 py-3 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition">
                                        Update Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection