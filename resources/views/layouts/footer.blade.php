<footer class="bg-gray-900 text-gray-300">
    <div class="max-w-6xl mx-auto px-4 py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
            
            <!-- Brand -->
            <div>
                <h3 class="text-2xl font-bold text-white flex items-center">
                    <i class="fas fa-car mr-3"></i> SriTravel
                </h3>
                <p class="mt-4 text-gray-400">
                    Premium vehicle rental service for tours and long-distance travel in Sri Lanka.
                </p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2">
                    <li><a href="{{ route('welcome') }}" class="hover:text-white">Home</a></li>
                    <li><a href="{{ route('vehicles.index') }}" class="hover:text-white">Vehicles</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white">About Us</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-white font-semibold mb-4">Contact Us</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex gap-3">
                        <i class="fas fa-map-marker-alt mt-1"></i>
                        <span>123 Galle Road, Colombo 03, Sri Lanka</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-phone mt-1"></i>
                        <span>+94 72 372 2421</span>
                    </li>
                    <li class="flex gap-3">
                        <i class="fas fa-envelope mt-1"></i>
                        <span>sritraveltrust@gmail.com</span>
                    </li>
                </ul>
            </div>

            <!-- Service Info -->
            <div>
                <h4 class="text-white font-semibold mb-4">Service</h4>
                <p class="text-sm text-gray-400">
                    24/7 Support<br>
                    Trip-Only Rentals<br>
                    Professional Drivers
                </p>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 mt-12 pt-8 text-center text-sm">
            <p>© 2025 SriTravel. All rights reserved.</p>
            <div class="flex justify-center gap-6 mt-4 text-xs">
                <a href="#" class="hover:text-white">Privacy Policy</a>
                <a href="#" class="hover:text-white">Terms of Service</a>
                <a href="#" class="hover:text-white">Sitemap</a>
            </div>
        </div>
    </div>
</footer>