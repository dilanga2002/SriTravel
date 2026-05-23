@extends('layouts.app')

@section('title', 'About Us - SriTravel')

@section('content')

    <div class="max-w-6xl mx-auto px-4 py-12">

        <!-- Hero Section -->
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-gray-800">ABOUT US</h1>
            <p class="text-2xl text-gray-600 mt-4">Discover SriTravel</p>
        </div>

        <!-- Main Content -->
        <div class="prose prose-lg max-w-none">
            <p class="text-lg leading-relaxed">
                SriTravel Pvt Ltd is a trusted and locally established travel agency in Sri Lanka, dedicated to providing reliable and comfortable vehicle rentals exclusively for long-distance trips and tour-based travel. We proudly serve both local and international travelers who wish to explore the beauty of Sri Lanka with ease, safety, and flexibility.
            </p>

            <p class="text-lg leading-relaxed">
                Our vehicle fleet includes well-maintained cars, vans, and minibuses suited for a variety of travel needs—whether it's a family vacation, group tour, or a customized island-wide journey. What sets SriTravel apart is our clear and simple policy: we provide vehicles only for trip purposes—not for airport pickups, personal transport, or short-distance errands.
            </p>

            <p class="text-lg leading-relaxed">
                All bookings, vehicle assignments, and travel arrangements are handled personally by the owner, ensuring a hands-on, personalized approach for each customer. We take pride in offering a dependable, no-hassle service where communication is direct and customer expectations are clearly met.
            </p>

            <p class="text-lg leading-relaxed">
                At this time, SriTravel does not support online payment systems. Instead, we operate through manual bookings, allowing travelers to finalize their trips by directly contacting the owner. This helps us maintain close relationships with our customers and provide better assistance tailored to each journey.
            </p>

            <p class="text-lg leading-relaxed">
                With years of experience in Sri Lanka’s travel and tourism sector, SriTravel Pvt Ltd continues to grow as a dependable name known for its trip-only focus, customer care, and honest service. Whether you're planning a day tour or a long-distance trip around the island, we’re here to help you travel comfortably and confidently.
            </p>
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center">
            <a href="{{ route('vehicles.index') }}" 
               class="inline-block px-10 py-4 bg-blue-600 text-white text-xl font-semibold rounded-2xl hover:bg-blue-700 transition">
                Explore Our Fleet
            </a>
        </div>

    </div>

@endsection