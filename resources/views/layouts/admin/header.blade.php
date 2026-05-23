<header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-4">
        <!-- Mobile Sidebar Toggle -->
        <button id="sidebar-toggle" 
                class="lg:hidden text-gray-600 hover:text-blue-600 focus:outline-none">
            <i class="fas fa-bars text-2xl"></i>
        </button>
        
        <h1 class="text-2xl font-semibold text-gray-800">
            @yield('page_title', 'Dashboard')
        </h1>
    </div>
    
    <div class="flex items-center gap-6">
        <!-- Last Login -->
        <div class="hidden sm:flex items-center text-sm text-gray-500">
            <i class="fas fa-clock mr-2"></i>
            <span>Last login: {{ auth()->user()->last_login_at?->diffForHumans() ?? 'First time' }}</span>
        </div>

        <!-- User Info -->
        <div class="flex items-center gap-3">
            <div class="text-right hidden md:block">
                <p class="font-medium text-gray-800">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
            </div>
            
            <!-- Profile Photo -->
            <div>
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                         class="w-10 h-10 rounded-full object-cover border-2 border-gray-200"
                         alt="{{ auth()->user()->name }}">
                @else
                    <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-semibold text-lg border-2 border-white">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="ml-2">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="hidden sm:inline">Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>