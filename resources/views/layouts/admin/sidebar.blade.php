<div class="w-64 bg-blue-900 text-white flex flex-col h-full">
    <div class="p-6 border-b border-blue-800">
        <h1 class="text-2xl font-bold flex items-center">
            <i class="fas fa-car mr-3"></i> SriTravel
        </h1>
        <p class="text-blue-200 text-sm">Admin Panel</p>
    </div>

    <!-- Profile Section -->
    <div class="p-6 border-b border-blue-800 flex items-center gap-4">
        @if(auth()->user()->profile_photo)
            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                 class="w-12 h-12 rounded-2xl object-cover border-2 border-blue-700" 
                 alt="{{ auth()->user()->name }}">
        @else
            <div class="w-12 h-12 bg-white text-blue-900 rounded-2xl flex items-center justify-center text-2xl font-bold">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif
        
        <div>
            <p class="font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-xs text-blue-200">{{ auth()->user()->email }}</p>
        </div>
    </div>

    <nav class="flex-1 p-4 space-y-1">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.vehicles.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.vehicles.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
            <i class="fas fa-car"></i> Vehicles
        </a>
        <a href="{{ route('admin.drivers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.drivers.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
            <i class="fas fa-users"></i> Drivers
        </a>
        <a href="{{ route('admin.bookings.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.bookings.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
            <i class="fas fa-calendar-check"></i> Bookings
        </a>
        <a href="{{ route('admin.customers.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.customers.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
            <i class="fas fa-users"></i> Customers
        </a>
        <a href="{{ route('admin.reports.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
            <i class="fas fa-chart-bar"></i> Reports
        </a>
        
        <!-- Fixed Profile Link -->
        <a href="{{ route('profile.show') }}" 
           class="flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('profile.*') ? 'bg-blue-700' : 'hover:bg-blue-800' }}">
            <i class="fas fa-user"></i> Profile
        </a>
    </nav>

    <div class="p-4 border-t border-blue-800 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-lg flex items-center justify-center gap-2">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</div>