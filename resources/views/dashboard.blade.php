<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-jakarta { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        :root {
            --blue: #1A2B6B; --blue-dark: #0D1B4B; --blue-light: #EEF1FB;
            --blue-mid: #C7D0EE; --ink: #111827; --body: #374151;
            --muted: #6B7280; --border: #E5E7EB; --bg: #F5F7FA;
            --orange: #F5A524; --orange-dark: #D98D0F;
            --glass-border: rgba(229, 231, 235, 0.7);
        }

        /* ===== BACKGROUND MESH ===== */
        .main-workspace {
            position: relative;
            z-index: 1;
        }
        .main-workspace::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 60% 60% at 85% 10%, rgba(26,43,107,0.06) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 15% 80%, rgba(245,165,36,0.05) 0%, transparent 60%);
            z-index: -1;
            pointer-events: none;
        }

        /* ===== GLASS CARD ===== */
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(26, 43, 107, 0.05);
        }

        .sidebar-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.75rem 1rem; border-radius: 0.75rem;
            font-weight: 600; font-size: 0.875rem; color: var(--body);
            transition: all 0.2s; border-left: 3px solid transparent;
            text-decoration: none;
        }
        .sidebar-link:hover { background: var(--blue-light); color: var(--blue); }
        .sidebar-link.active { background: var(--blue-light); color: var(--blue); border-left-color: var(--blue); }
        
        .btn-orange { 
            background: var(--orange); color: white; font-weight: 700; 
            transition: all 0.2s; box-shadow: 0 4px 14px rgba(245, 165, 36, 0.35);
        }
        .btn-orange:hover { 
            background: var(--orange-dark); transform: translateY(-2px); 
            box-shadow: 0 6px 20px rgba(245, 165, 36, 0.45); 
        }

        /* Sidebar desktop collapse via width */
        #sidebar.desktop-collapsed { width: 0 !important; overflow: hidden; border-right: none; }
    </style>

    <div class="font-jakarta flex flex-col min-h-screen bg-[#F5F7FA]">

        {{-- ===== TOP HEADER (TIDAK DIUBAH SAMA SEKALI) ===== --}}
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
                        <p class="text-sm font-extrabold text-[#111827] tracking-tight leading-none">
                            SI<span class="text-[#1A2B6B]">REKA</span>
                        </p>
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

        {{-- ===== BODY ===== --}}
        <div class="flex flex-1">

            @include('partials.sidebar')

            <main class="main-workspace flex-1 w-full px-6 sm:px-10 lg:px-12 pt-8 pb-12 space-y-8 min-w-0">

                {{-- Hero Section --}}
                <div class="glass-card flex flex-col md:flex-row items-center justify-between gap-8 p-8 md:p-10 relative overflow-hidden bg-gradient-to-br from-white to-[#F8FAFC]">
                    
                    {{-- Kiri: Teks & CTA --}}
                    <div class="relative z-10 w-full md:w-3/5">
                        <div class="inline-flex items-center gap-2 bg-[#EEF1FB] text-[#1A2B6B] text-[0.75rem] font-bold uppercase tracking-wider px-4 py-1.5 rounded-full border border-[#C7D0EE] mb-4">
                            <span class="text-[#F5A524]">✨</span> Dashboard
                        </div>
                        <h2 class="font-extrabold text-2xl md:text-3xl lg:text-4xl text-[#111827] tracking-tight leading-tight">
                            Halo, <span class="text-[#1A2B6B]">{{ Auth::user()->name }}</span> 👋
                        </h2>
                        <p class="mt-3 text-[0.95rem] text-[#6B7280] max-w-xl leading-relaxed">
                            Selamat datang di SIREKA. Algoritma kami siap memetakan masa depanmu dengan mencocokkan profil akademikmu melawan basis data industri secara komprehensif.
                        </p>
                        
                        <div class="mt-5 mb-7 flex flex-wrap items-center gap-3">
                        </div>
                        
                        <div class="flex gap-4 flex-wrap">
                            <a href="{{ route('analysis.form') }}"
                               class="btn-orange px-6 py-3 rounded-xl text-[0.9rem] flex items-center gap-2">
                                <span>Mulai Analisis Karir</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('careers.index') }}"
                               class="px-6 py-3 rounded-xl text-[0.9rem] flex items-center gap-2 bg-white border border-[#E5E7EB] font-bold text-[#374151] hover:border-[#1A2B6B] hover:text-[#1A2B6B] transition-all shadow-sm">
                                Eksplorasi Karir
                            </a>
                        </div>
                    </div>

                    <div class="relative z-10 w-full md:w-2/5 flex justify-center md:justify-end opacity-90">
                        <div class="w-full max-w-[260px]">
                            <svg viewBox="0 0 300 280" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto drop-shadow-md">
                                <circle cx="150" cy="140" r="110" stroke="#EEF1FB" stroke-width="2" stroke-dasharray="6 6"/>
                                <circle cx="150" cy="140" r="65" stroke="#EEF1FB" stroke-width="2" stroke-dasharray="4 4"/>
                                
                                <path d="M150 140 L70 80" stroke="#C7D0EE" stroke-width="2" stroke-linecap="round"/>
                                <path d="M150 140 L240 70" stroke="#C7D0EE" stroke-width="2" stroke-linecap="round"/>
                                <path d="M150 140 L230 210" stroke="#C7D0EE" stroke-width="2" stroke-linecap="round"/>
                                <path d="M150 140 L80 200" stroke="#C7D0EE" stroke-width="2" stroke-linecap="round"/>
                                
                                <circle cx="150" cy="140" r="28" fill="#1A2B6B"/>
                                <circle cx="150" cy="140" r="10" fill="#F5A524"/>
                                
                                <circle cx="70" cy="80" r="16" fill="white" stroke="#1A2B6B" stroke-width="4"/>
                                <circle cx="70" cy="80" r="5" fill="#1A2B6B"/>
                                <circle cx="240" cy="70" r="20" fill="white" stroke="#F5A524" stroke-width="4"/>
                                <circle cx="240" cy="70" r="6" fill="#F5A524"/>
                                <circle cx="230" cy="210" r="14" fill="white" stroke="#10B981" stroke-width="4"/>
                                <circle cx="230" cy="210" r="4" fill="#10B981"/>
                                <circle cx="80" cy="200" r="18" fill="white" stroke="#C7D0EE" stroke-width="4"/>
                                <circle cx="80" cy="200" r="6" fill="#C7D0EE"/>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Cards Grid --}}
                <div class="grid gap-5 xl:grid-cols-4 lg:grid-cols-2 sm:grid-cols-2">
                    <div class="glass-card p-6 flex items-center gap-4 transition-all hover:-translate-y-1 hover:border-[#C7D0EE] hover:shadow-lg group">
                        <div class="w-12 h-12 rounded-xl bg-[#EEF1FB] flex items-center justify-center text-[#1A2B6B] shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[0.7rem] font-extrabold text-[#6B7280] uppercase tracking-wider">Total Karir IT</p>
                            <p class="mt-0.5 text-2xl font-extrabold text-[#111827]">{{ $careers->count() }}</p>
                        </div>
                    </div>
                    <div class="glass-card p-6 flex items-center gap-4 transition-all hover:-translate-y-1 hover:border-[#C7D0EE] hover:shadow-lg group">
                        <div class="w-12 h-12 rounded-xl bg-[#FFF8ED] flex items-center justify-center text-[#F5A524] shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[0.7rem] font-extrabold text-[#6B7280] uppercase tracking-wider">Pendidikan</p>
                            <p class="mt-0.5 text-2xl font-extrabold text-[#111827]">{{ $educations->count() }}</p>
                        </div>
                    </div>
                    <div class="glass-card p-6 flex items-center gap-4 transition-all hover:-translate-y-1 hover:border-[#C7D0EE] hover:shadow-lg group">
                        <div class="w-12 h-12 rounded-xl bg-[#EEF1FB] flex items-center justify-center text-[#1A2B6B] shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[0.7rem] font-extrabold text-[#6B7280] uppercase tracking-wider">Skill Database</p>
                            <p class="mt-0.5 text-2xl font-extrabold text-[#111827]">{{ $skills->count() }}</p>
                        </div>
                    </div>
                    <div class="glass-card p-6 flex items-center gap-4 transition-all hover:-translate-y-1 hover:border-[#C7D0EE] hover:shadow-lg group">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[0.7rem] font-extrabold text-[#6B7280] uppercase tracking-wider">Spesialisasi</p>
                            <p class="mt-0.5 text-2xl font-extrabold text-[#111827]">{{ $specializations->count() + $certifications->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="grid gap-5 md:grid-cols-3">
                    <a href="{{ route('analysis.form') }}"
                       class="group glass-card p-6 transition-all hover:-translate-y-1 hover:border-[#1A2B6B]/30 hover:shadow-xl hover:shadow-blue-900/5 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#1A2B6B] to-[#F5A524] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-10 h-10 rounded-xl bg-[#EEF1FB] flex items-center justify-center text-[#1A2B6B] mb-4 shadow-sm border border-blue-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-[#111827] text-[1.05rem] mb-1.5">Mulai Analisis</h3>
                        <p class="text-[0.85rem] text-[#6B7280] leading-relaxed">Isi form wizard akademik dan dapatkan rekomendasi karir IT terbaik secara real-time.</p>
                    </a>

                    <a href="{{ route('careers.index') }}"
                       class="group glass-card p-6 transition-all hover:-translate-y-1 hover:border-[#1A2B6B]/30 hover:shadow-xl hover:shadow-blue-900/5 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#1A2B6B] to-[#F5A524] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-10 h-10 rounded-xl bg-[#FFF8ED] flex items-center justify-center text-[#F5A524] mb-4 shadow-sm border border-orange-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-[#111827] text-[1.05rem] mb-1.5">Eksplorasi Karir</h3>
                        <p class="text-[0.85rem] text-[#6B7280] leading-relaxed">Lihat semua jalur karir spesifik yang tersedia di ekosistem industri digital saat ini.</p>
                    </a>

                    <a href="{{ route('recommendation') }}"
                       class="group glass-card p-6 transition-all hover:-translate-y-1 hover:border-[#1A2B6B]/30 hover:shadow-xl hover:shadow-blue-900/5 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#1A2B6B] to-[#F5A524] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-4 shadow-sm border border-emerald-100">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-[#111827] text-[1.05rem] mb-1.5">Lihat Hasil</h3>
                        <p class="text-[0.85rem] text-[#6B7280] leading-relaxed">Cek kembali riwayat dari hasil analisis terakhir beserta ranking kecocokan karirmu.</p>
                    </a>
                </div>

            </main>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        const MOBILE_BP = 768;

        function isMobile() {
            return window.innerWidth < MOBILE_BP;
        }

        // ---- MOBILE ----
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

        // ---- DESKTOP ----
        function toggleDesktop() {
            sidebar.classList.toggle('desktop-collapsed');
        }

        // ---- TOMBOL HAMBURGER ----
        document.getElementById('sidebar-toggle').addEventListener('click', () => {
            if (isMobile()) {
                const isHidden = sidebar.classList.contains('-translate-x-full');
                isHidden ? openMobile() : closeSidebar();
            } else {
                toggleDesktop();
            }
        });

        // Saat resize dari mobile ke desktop: reset state mobile
        window.addEventListener('resize', () => {
            if (!isMobile()) {
                overlay.classList.add('hidden');
                sidebar.classList.remove('translate-x-0', '-translate-x-full');
            }
        });
    </script>
</x-app-layout>