@extends('layouts.app')

@section('title', 'Contact Us - SriTravel')

@section('content')

    <div class="max-w-6xl mx-auto px-4 py-12">

        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-gray-800">CONTACT US</h1>
            <p class="text-2xl text-gray-600 mt-4">Get in Touch</p>
            <p class="max-w-md mx-auto mt-6 text-gray-600">
                We'd love to hear from you! Fill out the form below, and our team will respond promptly.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow p-8">
                <h2 class="text-2xl font-semibold mb-6">Send Us a Message</h2>

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

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" 
                                   class="w-full border border-gray-300 rounded-lg px-4 py-3">
                            @error('subject')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                            <textarea name="message" rows="6" 
                                      class="w-full border border-gray-300 rounded-lg px-4 py-3">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 text-white py-4 rounded-xl font-semibold hover:bg-blue-700 transition">
                            Send Message
                        </button>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h3 class="text-xl font-semibold mb-4">Contact Information</h3>
                    <div class="space-y-6">
                        <div class="flex gap-4">
                            <i class="fas fa-map-marker-alt text-2xl text-gray-400 mt-1"></i>
                            <div>
                                <p class="font-medium">123 Galle Road, Colombo 03, Sri Lanka</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-phone text-2xl text-gray-400 mt-1"></i>
                            <div>
                                <p class="font-medium">+94 72 372 2421</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-envelope text-2xl text-gray-400 mt-1"></i>
                            <div>
                                <p class="font-medium">sritraveltrust@gmail.com</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-clock text-2xl text-gray-400 mt-1"></i>
                            <div>
                                <p class="font-medium">24/7 Service</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer / Quick Links (optional) -->
                <div class="pt-8 border-t">
                    <p class="text-sm text-gray-500">© 2025 SriTravel. All rights reserved.</p>
                </div>
            </div>
        </div>
    </div>

@endsection