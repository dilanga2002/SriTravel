@extends('layouts.app')

@section('title', 'SriTravel - Premium Vehicle Rentals in Sri Lanka')

@section('content')

    <!-- Hero Section with Slideshow -->
    <section class="relative h-screen flex items-center overflow-hidden">
        <!-- Slideshow -->
        <div id="slideshow" class="slideshow-container absolute inset-0">
            <div class="slide active" style="background-image: url('https://jetwingtravels.com/wp-content/uploads/2024/01/home-desctop.jpg');"></div>
            <div class="slide" style="background-image: url('https://jetwingtravels.com/wp-content/uploads/2024/01/2pic2.jpg');"></div>
            <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1544620347-c4fd70cbf54f?ixlib=rb-4.0.3&auto=format&fit=crop&q=80');"></div>
        </div>

        <div class="hero-overlay absolute inset-0 bg-black/60"></div>

        <div class="relative z-10 max-w-6xl mx-auto px-6 text-white text-center">
            <h1 class="text-5xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6">
                Explore Sri Lanka in <span class="text-blue-400">Confidence</span> & <span class="text-blue-400">Comfort</span>
            </h1>
            <p class="text-xl md:text-2xl mb-10 max-w-2xl mx-auto">
                Welcome to SriTravel Pvt Ltd – your trusted partner for trip-based vehicle rentals across Sri Lanka.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('vehicles.index') }}" 
                   class="btn-primary text-lg px-10 py-4 border-2 border-white rounded-2xl hover:bg-white hover:text-gray-900 transition">
                    <i class="fas fa-car mr-3"></i> Browse Vehicles
                </a>
                <a href="{{ route('about') }}" 
                   class="inline-flex items-center px-10 py-4 border-2 border-white hover:bg-white hover:text-gray-900 text-white font-semibold text-lg rounded-2xl transition">
                    Learn More
                </a>
            </div>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 text-white animate-bounce">
            <i class="fas fa-chevron-down text-4xl"></i>
        </div>
    </section>

    <!-- Welcome Message -->
    <section class="py-16 bg-white">
        <div class="max-w-5xl mx-auto px-6 text-center">
            <span class="uppercase tracking-widest text-blue-600 font-semibold">Welcome to SriTravel</span>
            <h2 class="text-4xl font-bold text-gray-800 mt-3">Your Journey, Our Passion</h2>
            
            <div class="prose prose-lg text-gray-600 max-w-3xl mx-auto mt-8">
                <p class="text-xl leading-relaxed">
                    SriTravel Pvt Ltd specializes in providing reliable and comfortable vehicle rentals 
                    exclusively for long-distance trips and tour-based travel across Sri Lanka.
                </p>
                <p class="text-xl leading-relaxed mt-6">
                    We <strong>do not</strong> provide vehicles for airport pickups or short-distance use. 
                    All bookings are personally managed for the best service experience.
                </p>
            </div>
        </div>
    </section>

    <!-- Featured Vehicles -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Featured Vehicles</h2>
                <p class="text-gray-600 mt-2">Choose from our well-maintained fleet</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($vehicles->take(6) as $vehicle)
                    <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/' . $vehicle->image) }}" 
                                 class="w-full h-56 object-cover" alt="{{ $vehicle->make }} {{ $vehicle->model }}">
                        @else
                            <div class="h-56 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-car text-6xl text-gray-300"></i>
                            </div>
                        @endif
                        <div class="p-6">
                            <h3 class="font-semibold text-xl">{{ $vehicle->make }} {{ $vehicle->model }}</h3>
                            <p class="text-gray-500">{{ $vehicle->year }} • {{ ucfirst($vehicle->type) }}</p>
                            
                            <div class="mt-4 flex justify-between items-end">
                                <div>
                                    <span class="text-2xl font-bold text-blue-600">Rs. {{ number_format($vehicle->price_per_km, 2) }}</span>
                                    <span class="text-xs text-gray-500">/km</span>
                                </div>
                                <a href="{{ route('vehicles.show', $vehicle) }}" 
                                   class="px-6 py-2 bg-blue-600 text-white text-sm rounded-xl hover:bg-blue-700 transition">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('vehicles.index') }}" 
                   class="inline-block bg-blue-600 text-white px-8 py-4 rounded-2xl hover:bg-blue-700 transition font-medium">
                    View All Vehicles →
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
// Simple Slideshow
let slideIndex = 0;
const slides = document.querySelectorAll('.slide');

function showSlides() {
    slides.forEach(slide => slide.classList.remove('active'));
    slideIndex = (slideIndex + 1) % slides.length;
    slides[slideIndex].classList.add('active');
}

setInterval(showSlides, 5000);
</script>
@endpush