{{-- Overlay untuk mobile (ditambahkan efek blur) --}}
<div id="sidebar-overlay"
     class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm z-30 hidden md:hidden transition-opacity duration-300"
     onclick="closeSidebar()"></div>

<aside id="sidebar"
       class="font-jakarta w-64 bg-white border-r border-gray-100 flex flex-col shrink-0
              fixed top-0 left-0 h-full z-40 -translate-x-full transition-transform duration-300 ease-in-out
              md:sticky md:top-16 md:h-[calc(100vh-4rem)] md:translate-x-0 md:z-auto overflow-y-auto shadow-[4px_0_24px_rgba(0,0,0,0.02)]">

    {{-- Logo Mobile --}}
    <div class="p-6 border-b border-gray-100 flex items-center gap-3 md:hidden">
        <img src="{{ asset('images/logo3.png') }}" alt="Logo" class="h-8 w-auto object-contain">
        <div>
            <h2 class="text-sm font-extrabold text-[#111827] tracking-tight leading-none">
                SI<span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1A2B6B] to-[#4F46E5]">REKA</span>
            </h2>
            <p class="text-[0.65rem] text-[#6B7280] mt-1 font-medium">Sistem Rekomendasi Karir</p>
        </div>
    </div>

    <nav class="p-4 flex flex-col gap-1.5 flex-1">
        <p class="px-3 text-[0.65rem] font-bold tracking-widest text-gray-400 uppercase mb-2 mt-2">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-[#1A2B6B] to-[#2a4099] text-white shadow-md shadow-[#1A2B6B]/20' : 'text-gray-500 hover:text-[#1A2B6B] hover:bg-[#1A2B6B]/5' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>

        {{-- Analisis Karir --}}
        <a href="{{ route('analysis.form') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('analysis.form') ? 'bg-gradient-to-r from-[#1A2B6B] to-[#2a4099] text-white shadow-md shadow-[#1A2B6B]/20' : 'text-gray-500 hover:text-[#1A2B6B] hover:bg-[#1A2B6B]/5' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Analisis Karir
        </a>

        {{-- Hasil Rekomendasi --}}
        <a href="{{ route('recommendation') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('recommendation') ? 'bg-gradient-to-r from-[#1A2B6B] to-[#2a4099] text-white shadow-md shadow-[#1A2B6B]/20' : 'text-gray-500 hover:text-[#1A2B6B] hover:bg-[#1A2B6B]/5' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
            </svg>
            Hasil Rekomendasi
        </a>

        {{-- Daftar Karir --}}
        <a href="{{ route('careers.index') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('careers.index') ? 'bg-gradient-to-r from-[#1A2B6B] to-[#2a4099] text-white shadow-md shadow-[#1A2B6B]/20' : 'text-gray-500 hover:text-[#1A2B6B] hover:bg-[#1A2B6B]/5' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Daftar Karir
        </a>

        <div class="my-4 border-t border-gray-100"></div>
        <p class="px-3 text-[0.65rem] font-bold tracking-widest text-gray-400 uppercase mb-2">Akun</p>

        {{-- Profil Saya --}}
        <a href="{{ route('profile.edit') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 {{ request()->routeIs('profile.edit') ? 'bg-gradient-to-r from-[#1A2B6B] to-[#2a4099] text-white shadow-md shadow-[#1A2B6B]/20' : 'text-gray-500 hover:text-[#1A2B6B] hover:bg-[#1A2B6B]/5' }}">
            <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Profil Saya
        </a>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-auto pt-4 pb-2">
            @csrf
            <button type="submit"
                class="group w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 hover:text-red-600 transition-all duration-300">
                <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Keluar
            </button>
        </form>
    </nav>
</aside>