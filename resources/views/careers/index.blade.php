<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-jakarta { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        :root {
            --blue:#1A2B6B; --blue-dark:#0D1B4B; --blue-light:#EEF1FB;
            --blue-mid:#C7D0EE; --ink:#111827; --body:#374151;
            --muted:#6B7280; --border:#E5E7EB; --bg:#F5F7FA;
            --orange:#F5A524; --orange-dark:#D98D0F;
        }
        .sidebar-link {
            display:flex; align-items:center; gap:0.75rem;
            padding:0.65rem 0.85rem; border-radius:0.5rem;
            font-weight:600; font-size:0.875rem; color:var(--body);
            transition:all 0.2s; border-left:3px solid transparent;
            text-decoration:none;
        }
        .sidebar-link:hover { background:var(--blue-light); color:var(--blue); }
        .sidebar-link.active { background:var(--blue-light); color:var(--blue); border-left-color:var(--blue); }
        #sidebar.desktop-collapsed { width:0 !important; overflow:hidden; border-right:none; }
    </style>

    <div class="font-jakarta flex flex-col min-h-screen bg-[#F5F7FA]">

        {{-- HEADER --}}
        <header class="font-jakarta sticky top-0 z-50 flex items-center justify-between px-4 sm:px-6 h-16 bg-white border-b border-[#E5E7EB] shadow-sm shrink-0">
            <div class="flex items-center gap-3">
                <button id="sidebar-toggle"
                        class="p-2 rounded-lg text-[#6B7280] hover:bg-[#EEF1FB] hover:text-[#1A2B6B] transition-all"
                        aria-label="Toggle Sidebar">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                    <div class="w-auto h-8 overflow-hidden shrink-0">
                        <img src="{{ asset('images/logo3.png') }}" alt="Logo" class="h-full w-auto object-contain">
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-extrabold text-[#111827] tracking-tight leading-none">SI<span class="text-[#1A2B6B]">REKA</span></p>
                        <p class="text-[0.65rem] text-[#6B7280] mt-0.5 font-medium leading-none">Sistem Rekomendasi Karir</p>
                    </div>
                </a>
            </div>
            <div class="flex items-center gap-3">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-semibold text-[#111827] leading-none">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-[#6B7280] leading-none mt-0.5">{{ Auth::user()->email }}</p>
                </div>
                <div class="w-9 h-9 rounded-full bg-[#1A2B6B] flex items-center justify-center text-white text-sm font-bold select-none shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- BODY --}}
        <div class="flex flex-1">
            @include('partials.sidebar')

            <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-8 py-10 min-w-0">

                <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <div class="inline-flex items-center gap-1.5 bg-[#EEF1FB] text-[#1A2B6B] text-[0.72rem] font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-[#C7D0EE] mb-3">
                            ✦ Daftar Karir
                        </div>
                        <h2 class="text-2xl font-extrabold text-[#111827]">Eksplorasi Karir IT</h2>
                        <p class="mt-1 text-sm text-[#6B7280]">Temukan detail setiap peran dan skill yang dibutuhkan di industri.</p>
                    </div>
                    <a href="{{ route('analysis.form') }}"
                       class="inline-flex items-center gap-2 bg-[#F5A524] hover:bg-[#D98D0F] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shrink-0">
                        Analisis Karir Saya
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>

                @if (count((array) $careers) > 0)
                    <div class="grid gap-5 lg:grid-cols-3 md:grid-cols-2">
                        @foreach ($careers as $career)
                            <div class="group bg-white rounded-2xl border border-[#E5E7EB] p-6 shadow-sm transition hover:-translate-y-1 hover:border-[#C7D0EE] hover:shadow-md relative overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1A2B6B] to-[#F5A524] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="flex items-start justify-between gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-[#EEF1FB] flex items-center justify-center text-lg shrink-0">💻</div>
                                    <span class="text-[0.68rem] font-bold uppercase tracking-wider text-[#6B7280] bg-[#F5F7FA] border border-[#E5E7EB] px-2 py-0.5 rounded-full">
                                        IT Career
                                    </span>
                                </div>
                                <h3 class="text-base font-bold text-[#111827] mb-2">{{ $career->career_name }}</h3>
                                <p class="text-sm leading-relaxed text-[#6B7280]">
                                    Jelajahi karir ini dan temukan persyaratan skill serta spesialisasi yang dibutuhkan.
                                </p>
                                <div class="mt-5 pt-4 border-t border-[#F5F7FA]">
                                    <a href="{{ route('analysis.form') }}"
                                       class="text-xs font-bold text-[#1A2B6B] hover:underline flex items-center gap-1">
                                        Cek kecocokan saya
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-2xl border-2 border-dashed border-[#E5E7EB] bg-white p-10 text-center">
                        <div class="w-16 h-16 mx-auto bg-[#F5F7FA] border border-[#E5E7EB] rounded-2xl flex items-center justify-center text-2xl mb-4">💼</div>
                        <p class="font-bold text-[#111827]">Belum ada data karir</p>
                    </div>
                @endif

            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const MOBILE_BP = 768;
        function isMobile() { return window.innerWidth < MOBILE_BP; }
        function openMobile() {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            overlay.classList.remove('hidden');
        }
        function closeSidebar() {
            if (isMobile()) {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
            }
        }
        function toggleDesktop() { sidebar.classList.toggle('desktop-collapsed'); }
        document.getElementById('sidebar-toggle').addEventListener('click', () => {
            if (isMobile()) {
                sidebar.classList.contains('-translate-x-full') ? openMobile() : closeSidebar();
            } else { toggleDesktop(); }
        });
        window.addEventListener('resize', () => {
            if (!isMobile()) {
                overlay.classList.add('hidden');
                sidebar.classList.remove('translate-x-0', '-translate-x-full');
            }
        });
    </script>
</x-app-layout>