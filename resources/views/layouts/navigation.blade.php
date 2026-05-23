<!-- resources/views/layouts/navigation.blade.php -->
<nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2">
                    <i class="fas fa-car text-blue-600 text-3xl"></i>
                    <span class="font-bold text-2xl text-gray-800">SriTravel</span>
                </a>
            </div>

            <!-- Menu -->
            <div class="hidden md:flex items-center gap-8">
                @auth
                    @if(auth()->user()->isDriver())
                        <!-- Driver Menu -->
                        <a href="{{ route('driver.dashboard') }}" 
                           class="font-medium {{ request()->routeIs('driver.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('driver.bookings.index') }}" 
                           class="font-medium {{ request()->routeIs('driver.bookings.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">
                            My Assignments
                        </a>
                    @else
                        <!-- Customer & Admin Menu -->
                        <a href="{{ route('welcome') }}" class="font-medium {{ request()->routeIs('welcome') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">Home</a>
                        <a href="{{ route('vehicles.index') }}" class="font-medium {{ request()->routeIs('vehicles.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">Vehicles</a>
                        <a href="{{ route('about') }}" class="font-medium {{ request()->routeIs('about') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">About</a>
                        <a href="{{ route('contact') }}" class="font-medium {{ request()->routeIs('contact') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">Contact</a>
                    @endif
                @else
                    <!-- Guest Menu -->
                    <a href="{{ route('welcome') }}" class="font-medium {{ request()->routeIs('welcome') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">Home</a>
                    <a href="{{ route('vehicles.index') }}" class="font-medium {{ request()->routeIs('vehicles.*') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">Vehicles</a>
                    <a href="{{ route('about') }}" class="font-medium {{ request()->routeIs('about') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">About</a>
                    <a href="{{ route('contact') }}" class="font-medium {{ request()->routeIs('contact') ? 'text-blue-600 border-b-2 border-blue-600 pb-1' : 'text-gray-600 hover:text-gray-900' }}">Contact</a>
                @endauth
            </div>

            <!-- Right Side -->
            <div class="flex items-center gap-4">
                @auth
                    <div class="relative" id="profile-dropdown">
                        <button onclick="toggleDropdown()" class="flex items-center gap-2 focus:outline-none">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                     class="w-8 h-8 rounded-full object-cover border-2 border-white shadow-sm" alt="Profile">
                            @else
                                <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold text-sm border-2 border-white shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="hidden md:block font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>

                        <div id="dropdown-menu" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl py-2 z-50 border border-gray-100">
                            @if(auth()->user()->isDriver())
                                <a href="{{ route('driver.dashboard') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50">
                                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                                </a>
                                <a href="{{ route('driver.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50">
                                    <i class="fas fa-tasks"></i><span>My Assignments</span>
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50">
                                    <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
                                </a>
                            @endif

                            <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50">
                                <i class="fas fa-user"></i><span>My Profile</span>
                            </a>

                            <div class="border-t my-2"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center gap-3 w-full text-left px-4 py-3 text-red-600 hover:bg-red-50">
                                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="font-medium text-gray-700 hover:text-gray-900 px-4 py-2">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2 rounded-xl hover:bg-blue-700">Sign Up</a>
                @endauth

                <button id="mobile-menu-button" class="md:hidden text-gray-600 hover:text-gray-900">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t">
        <div class="px-4 py-6 space-y-4">
            @auth
                @if(auth()->user()->isDriver())
                    <a href="{{ route('driver.dashboard') }}" class="block font-medium">Dashboard</a>
                    <a href="{{ route('driver.bookings.index') }}" class="block font-medium">My Assignments</a>
                @else
                    <a href="{{ route('welcome') }}" class="block font-medium">Home</a>
                    <a href="{{ route('vehicles.index') }}" class="block font-medium">Vehicles</a>
                @endif
            @else
                <a href="{{ route('welcome') }}" class="block font-medium">Home</a>
                <a href="{{ route('vehicles.index') }}" class="block font-medium">Vehicles</a>
            @endauth
        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        document.getElementById('dropdown-menu').classList.toggle('hidden');
    }

    document.addEventListener('click', function(e) {
        if (!document.getElementById('profile-dropdown')?.contains(e.target)) {
            document.getElementById('dropdown-menu').classList.add('hidden');
        }
    });

    document.getElementById('mobile-menu-button').addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>