<header class="font-jakarta sticky top-0 z-50 flex items-center justify-between px-4 sm:px-6 h-16 bg-white border-b border-[#E5E7EB] shadow-sm">
    {{-- Kiri: Hamburger + Logo --}}
    <div class="flex items-center gap-3">
        <button id="sidebar-toggle"
                class="p-2 rounded-lg text-[#6B7280] hover:bg-[#EEF1FB] hover:text-[#1A2B6B] transition-all"
                aria-label="Toggle Sidebar">
            <svg id="icon-menu" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="SIREKA" class="h-8 w-auto">
            <div class="hidden sm:block">
                <p class="font-extrabold text-sm text-[#1A2B6B] leading-none">SIREKA</p>
                <p class="text-[0.65rem] text-[#6B7280] leading-none mt-0.5">Sistem Rekomendasi Karir</p>
            </div>
        </a>
    </div>

    {{-- Kanan: User info + Avatar --}}
    <div class="flex items-center gap-3">
        <div class="hidden sm:block text-right">
            <p class="text-sm font-semibold text-[#111827] leading-none">{{ Auth::user()->name }}</p>
            <p class="text-xs text-[#6B7280] leading-none mt-0.5">{{ Auth::user()->email }}</p>
        </div>
        <div class="w-9 h-9 rounded-full bg-[#1A2B6B] flex items-center justify-center text-white text-sm font-bold select-none">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
    </div>
</header>