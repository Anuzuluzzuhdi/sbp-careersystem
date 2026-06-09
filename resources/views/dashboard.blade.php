<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-jakarta { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        :root {
            --blue: #1A2B6B; --blue-dark: #0D1B4B; --blue-light: #EEF1FB;
            --blue-mid: #C7D0EE; --ink: #111827; --body: #374151;
            --muted: #6B7280; --border: #E5E7EB; --bg: #F0F4F8; /* Diubah sedikit lebih biru/gelap dari F5F7FA */
            --orange: #F5A524; --orange-dark: #D98D0F;
            --glass-border: rgba(255, 255, 255, 0.4);
        }

        /* ===== BACKGROUND MESH (Dipertegas sedikit warnanya) ===== */
        .main-workspace {
            position: relative;
            z-index: 1;
            background-color: var(--bg);
        }
        .main-workspace::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 70% 70% at 80% 0%, rgba(79, 70, 229, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 60% at 10% 90%, rgba(245, 165, 36, 0.08) 0%, transparent 60%);
            z-index: -1;
            pointer-events: none;
        }

        /* ===== GLASS CARD (Shadow lebih hidup & soft) ===== */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px; /* Sudut sedikit lebih membulat */
            box-shadow: 0 10px 40px rgba(26, 43, 107, 0.04), inset 0 1px 0 rgba(255,255,255,0.6);
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
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
            box-shadow: 0 4px 14px rgba(245, 165, 36, 0.4);
        }
        .btn-orange:hover { 
            background: var(--orange-dark); transform: translateY(-2px); 
            box-shadow: 0 8px 24px rgba(245, 165, 36, 0.5); 
        }

        /* Sidebar desktop collapse via width */
        #sidebar.desktop-collapsed { width: 0 !important; overflow: hidden; border-right: none; }
    </style>

    <div class="font-jakarta flex flex-col min-h-screen">

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

            <main class="main-workspace flex-1 w-full px-6 sm:px-10 lg:px-12 pt-8 pb-12 space-y-10 min-w-0">

                {{-- Hero Section (Ubah ke Premium Dark Blue Gradient) --}}
                <div class="rounded-[24px] flex flex-col md:flex-row items-center justify-between gap-8 p-8 md:p-12 relative overflow-hidden bg-gradient-to-br from-[#0D1B4B] via-[#1A2B6B] to-[#4F46E5] shadow-2xl shadow-blue-900/20 border border-white/10">
                    
                    {{-- Aksen Dekoratif di Background Hero --}}
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 rounded-full bg-blue-400/20 blur-3xl mix-blend-screen pointer-events-none"></div>
                    <div class="absolute bottom-0 left-10 -mb-20 w-56 h-56 rounded-full bg-orange-400/20 blur-3xl mix-blend-screen pointer-events-none"></div>

                    {{-- Kiri: Teks & CTA --}}
                    <div class="relative z-10 w-full md:w-3/5">
                        {{-- Badge Glassmorphism Transparan --}}
                        <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md text-white text-[0.75rem] font-bold uppercase tracking-wider px-4 py-2 rounded-full border border-white/20 mb-5 shadow-sm">
                            <span class="text-[#F5A524] drop-shadow-md">✨</span> Dashboard Utama
                        </div>
                        
                        <h2 class="font-extrabold text-3xl md:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
                            Halo, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#F5A524] to-[#FCD34D]">{{ Auth::user()->name }}</span> 👋
                        </h2>
                        
                        <p class="mt-4 text-[1rem] text-blue-100/90 max-w-xl leading-relaxed font-medium">
                            Selamat datang di SIREKA. Algoritma kami siap memetakan masa depanmu dengan mencocokkan profil akademikmu melawan basis data industri secara komprehensif.
                        </p>
                        
                        <div class="mt-8 flex gap-4 flex-wrap">
                            <a href="{{ route('analysis.form') }}"
                               class="btn-orange px-7 py-3.5 rounded-xl text-[0.95rem] flex items-center gap-2">
                                <span>Mulai Analisis Karir</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                            <a href="{{ route('careers.index') }}"
                               class="px-7 py-3.5 rounded-xl text-[0.95rem] flex items-center gap-2 bg-white/10 border border-white/20 font-bold text-white hover:bg-white/20 hover:border-white/40 transition-all shadow-sm backdrop-blur-sm">
                                Eksplorasi Karir
                            </a>
                        </div>
                    </div>

                    {{-- Kanan: Ilustrasi SVG (Disesuaikan warnanya untuk dark mode) --}}
                    <div class="relative z-10 w-full md:w-2/5 flex justify-center md:justify-end">
                        <div class="w-full max-w-[280px] drop-shadow-2xl hover:scale-105 transition-transform duration-500">
                            <svg viewBox="0 0 300 280" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                                {{-- Garis Penghubung --}}
                                <circle cx="150" cy="140" r="110" stroke="rgba(255,255,255,0.15)" stroke-width="2" stroke-dasharray="6 6"/>
                                <circle cx="150" cy="140" r="65" stroke="rgba(255,255,255,0.2)" stroke-width="2" stroke-dasharray="4 4"/>
                                
                                <path d="M150 140 L70 80" stroke="rgba(255,255,255,0.3)" stroke-width="2" stroke-linecap="round"/>
                                <path d="M150 140 L240 70" stroke="rgba(255,255,255,0.3)" stroke-width="2" stroke-linecap="round"/>
                                <path d="M150 140 L230 210" stroke="rgba(255,255,255,0.3)" stroke-width="2" stroke-linecap="round"/>
                                <path d="M150 140 L80 200" stroke="rgba(255,255,255,0.3)" stroke-width="2" stroke-linecap="round"/>
                                
                                {{-- Node Pusat --}}
                                <circle cx="150" cy="140" r="32" fill="rgba(255,255,255,0.1)" stroke="white" stroke-width="2"/>
                                <circle cx="150" cy="140" r="24" fill="url(#center-gradient)"/>
                                <circle cx="150" cy="140" r="8" fill="white"/>
                                
                                {{-- Node Cabang --}}
                                <circle cx="70" cy="80" r="16" fill="#1A2B6B" stroke="white" stroke-width="3"/>
                                <circle cx="70" cy="80" r="5" fill="#60A5FA"/>
                                
                                <circle cx="240" cy="70" r="20" fill="#D98D0F" stroke="white" stroke-width="3"/>
                                <circle cx="240" cy="70" r="6" fill="white"/>
                                
                                <circle cx="230" cy="210" r="14" fill="#047857" stroke="white" stroke-width="3"/>
                                <circle cx="230" cy="210" r="4" fill="#34D399"/>
                                
                                <circle cx="80" cy="200" r="18" fill="#4F46E5" stroke="white" stroke-width="3"/>
                                <circle cx="80" cy="200" r="6" fill="#A5B4FC"/>

                                {{-- Definisikan gradient untuk SVG --}}
                                <defs>
                                    <linearGradient id="center-gradient" x1="126" y1="116" x2="174" y2="164" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#F5A524"/>
                                        <stop offset="1" stop-color="#D98D0F"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Stat Cards Grid --}}
                <div class="grid gap-5 xl:grid-cols-4 lg:grid-cols-2 sm:grid-cols-2">
                    <div class="glass-card p-6 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1.5 hover:border-blue-200 hover:shadow-[0_15px_30px_rgba(26,43,107,0.1)] group cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm relative z-10">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <p class="text-[0.7rem] font-extrabold text-[#6B7280] uppercase tracking-wider mb-1">Total Karir IT</p>
                            <p class="text-3xl font-extrabold text-[#111827] leading-none">{{ $careers->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="glass-card p-6 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1.5 hover:border-orange-200 hover:shadow-[0_15px_30px_rgba(245,165,36,0.1)] group cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-orange-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-14 h-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 shrink-0 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-300 shadow-sm relative z-10">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <p class="text-[0.7rem] font-extrabold text-[#6B7280] uppercase tracking-wider mb-1">Pendidikan</p>
                            <p class="text-3xl font-extrabold text-[#111827] leading-none">{{ $educations->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="glass-card p-6 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1.5 hover:border-indigo-200 hover:shadow-[0_15px_30px_rgba(79,70,229,0.1)] group cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 shrink-0 group-hover:scale-110 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-300 shadow-sm relative z-10">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <p class="text-[0.7rem] font-extrabold text-[#6B7280] uppercase tracking-wider mb-1">Skill Database</p>
                            <p class="text-3xl font-extrabold text-[#111827] leading-none">{{ $skills->count() }}</p>
                        </div>
                    </div>
                    
                    <div class="glass-card p-6 flex items-center gap-5 transition-all duration-300 hover:-translate-y-1.5 hover:border-emerald-200 hover:shadow-[0_15px_30px_rgba(16,185,129,0.1)] group cursor-pointer relative overflow-hidden">
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-50/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-sm relative z-10">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="relative z-10">
                            <p class="text-[0.7rem] font-extrabold text-[#6B7280] uppercase tracking-wider mb-1">Spesialisasi</p>
                            <p class="text-3xl font-extrabold text-[#111827] leading-none">{{ $specializations->count() + $certifications->count() }}</p>
                        </div>
                    </div>
                </div>

                {{-- Quick Links (Ditambahkan garis warna statis di atas) --}}
                <div class="grid gap-5 md:grid-cols-3">
                    <a href="{{ route('analysis.form') }}"
                       class="group glass-card p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(26,43,107,0.08)] relative overflow-hidden flex flex-col h-full border-t-4 border-t-blue-600 hover:border-b-[#E5E7EB] hover:border-l-[#E5E7EB] hover:border-r-[#E5E7EB]">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 mb-5 shadow-sm border border-blue-100 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-[#111827] text-lg mb-2">Mulai Analisis</h3>
                        <p class="text-[0.9rem] text-[#6B7280] leading-relaxed flex-1">Isi form wizard akademik dan dapatkan rekomendasi karir IT terbaik secara real-time.</p>
                        
                        <div class="mt-4 flex items-center text-[0.8rem] font-bold text-blue-600 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            Mulai Sekarang <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
                    </a>

                    <a href="{{ route('careers.index') }}"
                       class="group glass-card p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(245,165,36,0.08)] relative overflow-hidden flex flex-col h-full border-t-4 border-t-orange-400 hover:border-b-[#E5E7EB] hover:border-l-[#E5E7EB] hover:border-r-[#E5E7EB]">
                        <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-orange-500 mb-5 shadow-sm border border-orange-100 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-[#111827] text-lg mb-2">Eksplorasi Karir</h3>
                        <p class="text-[0.9rem] text-[#6B7280] leading-relaxed flex-1">Lihat semua jalur karir spesifik yang tersedia di ekosistem industri digital saat ini.</p>
                        
                        <div class="mt-4 flex items-center text-[0.8rem] font-bold text-orange-500 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            Lihat Katalog <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
                    </a>

                    <a href="{{ route('recommendation') }}"
                       class="group glass-card p-6 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(16,185,129,0.08)] relative overflow-hidden flex flex-col h-full border-t-4 border-t-emerald-500 hover:border-b-[#E5E7EB] hover:border-l-[#E5E7EB] hover:border-r-[#E5E7EB]">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-5 shadow-sm border border-emerald-100 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h3 class="font-extrabold text-[#111827] text-lg mb-2">Lihat Hasil</h3>
                        <p class="text-[0.9rem] text-[#6B7280] leading-relaxed flex-1">Cek kembali riwayat dari hasil analisis terakhir beserta ranking kecocokan karirmu.</p>
                        
                        <div class="mt-4 flex items-center text-[0.8rem] font-bold text-emerald-600 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                            Cek Riwayat <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </div>
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