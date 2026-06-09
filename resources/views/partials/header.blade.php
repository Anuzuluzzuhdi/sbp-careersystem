<header class="font-jakarta sticky top-0 z-50 flex items-center justify-between px-4 sm:px-6 h-16 bg-white/80 backdrop-blur-md border-b border-[#E5E7EB]/50 shadow-[0_4px_30px_rgba(0,0,0,0.03)] transition-all">
    {{-- Kiri: Hamburger + Logo --}}
    <div class="flex items-center gap-3">
        <button id="sidebar-toggle"
                class="p-2 rounded-xl text-[#6B7280] hover:bg-[#1A2B6B]/5 hover:text-[#1A2B6B] transition-all duration-300"
                aria-label="Toggle Sidebar">
            <svg id="icon-menu" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
            <img src="{{ asset('images/logo.png') }}" alt="SIREKA" class="h-8 w-auto group-hover:scale-105 transition-transform duration-300">
            <div class="hidden sm:block">
                <p class="font-extrabold text-sm text-[#1A2B6B] leading-none group-hover:text-[#2a4099] transition-colors">SIREKA</p>
                <p class="text-[0.65rem] text-[#6B7280] leading-none mt-0.5">Sistem Rekomendasi Karir</p>
            </div>
        </a>
    </div>

    {{-- Kanan: User info + Avatar --}}
    <div class="flex items-center gap-4">
        <div class="hidden sm:block text-right">
            <p class="text-sm font-bold text-[#111827] leading-none">{{ Auth::user()->name }}</p>
            <p class="text-xs text-[#6B7280] leading-none mt-1">{{ Auth::user()->email }}</p>
        </div>
        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#1A2B6B] to-[#3a58d6] flex items-center justify-center text-white text-sm font-bold select-none shadow-md shadow-[#1A2B6B]/20 ring-2 ring-white cursor-pointer hover:scale-105 transition-transform duration-300">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    </div>
</header>