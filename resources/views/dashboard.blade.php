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
        .btn-orange { background:var(--orange); color:white; font-weight:600; transition:all 0.2s; }
        .btn-orange:hover { background:var(--orange-dark); transform:translateY(-1px); }
    </style>

    <div class="font-jakarta flex flex-col md:flex-row min-h-screen bg-[#F5F7FA]">

        @include('partials.sidebar')

        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-8 py-10 space-y-10">

            {{-- Hero --}}
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 bg-white p-8 rounded-3xl border border-[#E5E7EB] shadow-sm relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-[#EEF1FB] rounded-full blur-3xl opacity-50 -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="inline-flex items-center gap-1.5 bg-[#EEF1FB] text-[#1A2B6B] text-[0.72rem] font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-[#C7D0EE] mb-4">
                        ✦ Dashboard Sistem
                    </div>
                    <h2 class="font-extrabold text-3xl text-[#111827] leading-tight">
                        Halo, <span class="text-[#1A2B6B]">{{ Auth::user()->name }}</span> 👋
                    </h2>
                    <p class="mt-3 text-[0.95rem] text-[#6B7280] max-w-lg">
                        Selamat datang di SIREKA. Mulai analisis karir atau eksplorasi daftar karir IT yang tersedia.
                    </p>
                </div>
                <div class="relative z-10 flex gap-3 flex-wrap">
                    <a href="{{ route('analysis.form') }}"
                       class="btn-orange px-6 py-3.5 rounded-xl text-sm flex items-center gap-2">
                        <span>Mulai Analisis Karir</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('careers.index') }}"
                       class="px-6 py-3.5 rounded-xl text-sm flex items-center gap-2 bg-white border border-[#E5E7EB] font-semibold text-[#374151] hover:border-[#1A2B6B] hover:text-[#1A2B6B] transition-all">
                        Lihat Daftar Karir
                    </a>
                </div>
            </div>

            {{-- Stat Cards --}}
            <div class="grid gap-5 xl:grid-cols-4 lg:grid-cols-2 sm:grid-cols-2">
                <div class="bg-white rounded-2xl border border-[#E5E7EB] p-5 shadow-sm flex items-center gap-4 transition hover:-translate-y-1 hover:shadow-md">
                    <div class="w-12 h-12 rounded-xl bg-[#EEF1FB] flex items-center justify-center text-[#1A2B6B] shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#6B7280] uppercase tracking-wider">Total Karir</p>
                        <p class="mt-1 text-2xl font-extrabold text-[#111827]">{{ $careers->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-[#E5E7EB] p-5 shadow-sm flex items-center gap-4 transition hover:-translate-y-1 hover:shadow-md">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center text-[#F5A524] shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#6B7280] uppercase tracking-wider">Pendidikan</p>
                        <p class="mt-1 text-2xl font-extrabold text-[#111827]">{{ $educations->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-[#E5E7EB] p-5 shadow-sm flex items-center gap-4 transition hover:-translate-y-1 hover:shadow-md">
                    <div class="w-12 h-12 rounded-xl bg-[#EEF1FB] flex items-center justify-center text-[#1A2B6B] shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#6B7280] uppercase tracking-wider">Skill Tersedia</p>
                        <p class="mt-1 text-2xl font-extrabold text-[#111827]">{{ $skills->count() }}</p>
                    </div>
                </div>
                <div class="bg-white rounded-2xl border border-[#E5E7EB] p-5 shadow-sm flex items-center gap-4 transition hover:-translate-y-1 hover:shadow-md">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-[#6B7280] uppercase tracking-wider">Spesialisasi</p>
                        <p class="mt-1 text-2xl font-extrabold text-[#111827]">{{ $specializations->count() + $certifications->count() }}</p>
                    </div>
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="grid gap-5 md:grid-cols-3">
                <a href="{{ route('analysis.form') }}"
                   class="group bg-white rounded-2xl border border-[#E5E7EB] p-6 shadow-sm transition hover:-translate-y-1 hover:border-[#C7D0EE] hover:shadow-md relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1A2B6B] to-[#F5A524] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-10 h-10 rounded-xl bg-[#EEF1FB] flex items-center justify-center text-[#1A2B6B] mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#111827]">Mulai Analisis</h3>
                    <p class="mt-1 text-sm text-[#6B7280]">Isi form wizard dan dapatkan rekomendasi karir terbaik.</p>
                </a>

                <a href="{{ route('careers.index') }}"
                   class="group bg-white rounded-2xl border border-[#E5E7EB] p-6 shadow-sm transition hover:-translate-y-1 hover:border-[#C7D0EE] hover:shadow-md relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1A2B6B] to-[#F5A524] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-10 h-10 rounded-xl bg-orange-50 flex items-center justify-center text-[#F5A524] mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#111827]">Eksplorasi Karir</h3>
                    <p class="mt-1 text-sm text-[#6B7280]">Lihat semua jalur karir IT yang tersedia beserta detailnya.</p>
                </a>

                <a href="{{ route('recommendation') }}"
                   class="group bg-white rounded-2xl border border-[#E5E7EB] p-6 shadow-sm transition hover:-translate-y-1 hover:border-[#C7D0EE] hover:shadow-md relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1A2B6B] to-[#F5A524] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-[#111827]">Lihat Hasil</h3>
                    <p class="mt-1 text-sm text-[#6B7280]">Cek hasil analisis terakhir dan ranking kecocokan karirmu.</p>
                </a>
            </div>

        </main>
    </div>
</x-app-layout>