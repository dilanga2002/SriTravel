@extends('layouts.guest')

@section('title', 'Forgot Password - SriTravel')

@section('content')

    <div class="max-w-md mx-auto mt-10">
        <div class="bg-white rounded-2xl shadow p-8">

            <div class="text-center mb-8">
                <h2 class="text-3xl font-semibold">Forgot Password</h2>
                <p class="text-gray-600 mt-3">
                    No problem. Just let us know your email address and we will email you a password reset link.
                </p>
            </div>

            @if (session('status'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-center">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required
                           autofocus
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-blue-500 focus:border-blue-500">
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                        class="w-full bg-blue-600 text-white py-4 rounded-xl font-semibold hover:bg-blue-700 transition">
                    Email Password Reset Link
                </button>
            </form>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                    Remembered your password? Sign in
                </a>
            </div>

        </div>
    </div>

@endsection