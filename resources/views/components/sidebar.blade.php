<aside class="w-64 bg-gradient-to-b from-orange-800 to-orange-900 text-white flex-shrink-0 rounded-r-2xl shadow-2xl flex flex-col">
    
    {{-- Header / Profil --}}
    <div class="p-6 border-b border-orange-700/50">
        <div class="flex flex-col items-center text-center">
            <h1 class="text-2xl font-extrabold tracking-tight">POS Native</h1>
            <div class="mt-2 px-3 py-1 bg-orange-700/50 backdrop-blur-sm rounded-full text-xs font-medium text-orange-200 border border-orange-600/50 flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                </svg>
                Administrator
            </div>
        </div>
    </div>

    <nav class="flex-1 px-3 py-6 space-y-1.5">
        {{-- Dashboard --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.dashboard') ? 'bg-orange-700/80 text-white shadow-lg ring-1 ring-orange-500/50' : 'hover:bg-orange-700/40 text-orange-100' }}">
            <div class="w-8 flex justify-center">
                <img src="{{ asset('images/dashboard.png') }}" alt="Dashboard" class="w-5 h-5 brightness-0 invert opacity-90 group-hover:opacity-100 transition-opacity">
            </div>
            <span class="font-medium">Dashboard</span>
            @if(request()->routeIs('admin.dashboard'))
                <span class="ml-auto w-1.5 h-6 bg-yellow-400 rounded-full shadow-[0_0_8px_#facc15]"></span>
            @endif
        </a>
        
        {{-- Produk --}}
        <a href="{{ route('admin.products') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.products*') ? 'bg-orange-700/80 text-white shadow-lg ring-1 ring-orange-500/50' : 'hover:bg-orange-700/40 text-orange-100' }}">
            <div class="w-8 flex justify-center">
                <img src="{{ asset('images/box.png') }}" alt="Products" class="w-5 h-5 brightness-0 invert opacity-90 group-hover:opacity-100 transition-opacity">
            </div>
            <span class="font-medium">Produk</span>
            @if(request()->routeIs('admin.products*'))
                <span class="ml-auto w-1.5 h-6 bg-yellow-400 rounded-full shadow-[0_0_8px_#facc15]"></span>
            @endif
        </a>

        {{-- Inventaris --}}
        <a href="{{ route('admin.inventory') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.inventory*') ? 'bg-orange-700/80 text-white shadow-lg ring-1 ring-orange-500/50' : 'hover:bg-orange-700/40 text-orange-100' }}">
            <div class="w-8 flex justify-center">
                <img src="{{ asset('images/shipping.png') }}" alt="Inventory" class="w-5 h-5 brightness-0 invert opacity-90 group-hover:opacity-100 transition-opacity">
            </div>
            <span class="font-medium">Inventaris</span>
            @if(request()->routeIs('admin.inventory*'))
                <span class="ml-auto w-1.5 h-6 bg-yellow-400 rounded-full shadow-[0_0_8px_#facc15]"></span>
            @endif
        </a>

        {{-- Laporan --}}
        <a href="{{ route('admin.laporan') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.laporan*') ? 'bg-orange-700/80 text-white shadow-lg ring-1 ring-orange-500/50' : 'hover:bg-orange-700/40 text-orange-100' }}">
            <div class="w-8 flex justify-center">
                <img src="{{ asset('images/report.png') }}" alt="Laporan" class="w-5 h-5 brightness-0 invert opacity-90 group-hover:opacity-100 transition-opacity">
            </div>
            <span class="font-medium">Laporan</span>
            @if(request()->routeIs('admin.laporan*'))
                <span class="ml-auto w-1.5 h-6 bg-yellow-400 rounded-full shadow-[0_0_8px_#facc15]"></span>
            @endif
        </a>
    </nav>
    
    {{-- Footer / Logout untuk Admin (khusus) --}}
    <div class="p-4 border-t border-orange-700/50">
        <form action="{{ route('admin.auth.logoutAdmin') }}" method="POST">
            @csrf
            <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl transition-all duration-200 group text-orange-200 hover:bg-red-800/30 hover:text-white">
                <div class="w-8 flex justify-center">
                    <img src="{{ asset('images/power.png') }}" alt="Logout" class="w-5 h-5 brightness-0 invert opacity-80 group-hover:opacity-100 transition-opacity">
                </div>
                <span class="font-medium">Keluar</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-auto opacity-60 group-hover:opacity-100 group-hover:translate-x-0.5 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
        </form>
        <p class="text-center text-[10px] text-orange-400/60 mt-3 tracking-wider">v2.0.1 • POS</p>
    </div>
</aside>