<aside class="w-full md:w-64 bg-white border-r border-[#E5E7EB] shrink-0 md:sticky top-0 md:h-screen overflow-y-auto">
    <div class="p-6 border-b border-[#E5E7EB] flex items-center gap-3">
        <div class="w-8 h-8 rounded-lg overflow-hidden border border-[#E5E7EB] shrink-0">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover">
        </div>
        <div>
            <h2 class="text-base font-extrabold text-[#111827] tracking-tight leading-none">
                SI<span class="text-[#1A2B6B]">REKA</span>
            </h2>
            <p class="text-[0.65rem] text-[#6B7280] mt-0.5 font-medium">Navigasi Sistem Karir</p>
        </div>
    </div>

    <nav class="p-4 flex flex-col gap-1">
        <p class="px-3 text-[0.65rem] font-bold tracking-wider text-[#6B7280] uppercase mb-1 mt-2">Menu Utama</p>

        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg class="w-5 h-5 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        <a href="{{ route('analysis.form') }}"
           class="sidebar-link {{ request()->routeIs('analysis.form') ? 'active' : '' }}">
            <svg class="w-5 h-5 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Analisis Karir
        </a>

        <a href="{{ route('recommendation') }}"
           class="sidebar-link {{ request()->routeIs('recommendation') ? 'active' : '' }}">
            <svg class="w-5 h-5 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            Hasil Rekomendasi
        </a>

        <a href="{{ route('careers.index') }}"
           class="sidebar-link {{ request()->routeIs('careers.index') ? 'active' : '' }}">
            <svg class="w-5 h-5 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Daftar Karir
        </a>

        <div class="my-3 border-t border-[#E5E7EB]"></div>
        <p class="px-3 text-[0.65rem] font-bold tracking-wider text-[#6B7280] uppercase mb-1">Akun</p>

        <a href="{{ route('profile.edit') }}"
           class="sidebar-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <svg class="w-5 h-5 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Profil Saya
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="sidebar-link w-full text-left text-red-500 hover:bg-red-50 hover:text-red-600 border-l-transparent">
                <svg class="w-5 h-5 opacity-70 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>
    </nav>
</aside>