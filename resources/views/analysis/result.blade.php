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
        .score-bar-fill { width:0; transition:width 1.2s ease; }
    </style>

    <div class="font-jakarta flex flex-col md:flex-row min-h-screen bg-[#F5F7FA]">

        @include('partials.sidebar')

        <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-8 py-10 space-y-8">

            {{-- Header --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="inline-flex items-center gap-1.5 bg-[#EEF1FB] text-[#1A2B6B] text-[0.72rem] font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-[#C7D0EE] mb-3">
                        🏆 Hasil Rekomendasi
                    </div>
                    <h2 class="text-2xl font-extrabold text-[#111827]">Hasil Analisis Karir</h2>
                    <p class="mt-1 text-sm text-[#6B7280]">Peringkat karir berdasarkan data yang kamu masukkan menggunakan metode SAW.</p>
                </div>
                <a href="{{ route('analysis.form') }}"
                   class="inline-flex items-center gap-2 bg-white border border-[#E5E7EB] hover:border-[#1A2B6B] hover:text-[#1A2B6B] text-[#374151] px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Ubah Pencarian
                </a>
            </div>

            {{-- Kriteria yang dipakai --}}
            @if (array_filter($criteria))
                <div class="bg-white rounded-2xl border border-[#E5E7EB] p-5 shadow-sm">
                    <p class="text-xs font-bold text-[#6B7280] uppercase tracking-wider mb-3">Kriteria yang digunakan</p>
                    <div class="flex flex-wrap gap-2">
                        @if ($criteria['education_id'])
                            @php $edu = collect($educations)->firstWhere('education_id', $criteria['education_id']); @endphp
                            @if ($edu)
                                <span class="inline-flex items-center gap-1.5 bg-[#EEF1FB] text-[#1A2B6B] border border-[#C7D0EE] text-xs font-bold px-3 py-1 rounded-full">
                                    🎓 {{ $edu->education_level }}
                                </span>
                            @endif
                        @endif
                        @foreach (($criteria['skill_ids'] ?? []) as $sid)
                            @php $sk = collect($skills)->firstWhere('skill_id', $sid); @endphp
                            @if ($sk)
                                <span class="inline-flex items-center gap-1.5 bg-orange-50 text-orange-700 border border-orange-200 text-xs font-bold px-3 py-1 rounded-full">
                                    ⚡ {{ $sk->skill_name }}
                                </span>
                            @endif
                        @endforeach
                        @foreach (($criteria['specialization_ids'] ?? []) as $spid)
                            @php $sp = collect($specializations)->firstWhere('specialization_id', $spid); @endphp
                            @if ($sp)
                                <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs font-bold px-3 py-1 rounded-full">
                                    🎯 {{ $sp->specialization_name }}
                                </span>
                            @endif
                        @endforeach
                        @if ($criteria['certification_id'])
                            @php $cert = collect($certifications)->firstWhere('certification_id', $criteria['certification_id']); @endphp
                            @if ($cert)
                                <span class="inline-flex items-center gap-1.5 bg-purple-50 text-purple-700 border border-purple-200 text-xs font-bold px-3 py-1 rounded-full">
                                    📜 {{ $cert->certification_name }}
                                </span>
                            @endif
                        @endif
                    </div>
                </div>
            @endif

            {{-- Hasil --}}
            @if ($searchResults->isNotEmpty())

                {{-- Top result highlight --}}
                @php $top = $searchResults->first(); @endphp
                <div class="relative bg-gradient-to-br from-[#1A2B6B] to-[#0D1B4B] rounded-3xl p-6 md:p-8 text-white overflow-hidden shadow-lg">
                    <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/3 pointer-events-none"></div>
                    <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <div class="inline-flex items-center gap-1.5 bg-[#F5A524]/20 text-[#F5A524] text-[0.72rem] font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-[#F5A524]/30 mb-4">
                                🏆 Rekomendasi Utama
                            </div>
                            <h3 class="text-2xl font-extrabold mb-2">{{ $top->career_name }}</h3>
                            <p class="text-white/60 text-sm">Karir yang paling cocok berdasarkan profil dan skill yang kamu miliki.</p>
                        </div>
                        <div class="shrink-0 bg-white/10 backdrop-blur rounded-2xl px-8 py-5 text-center border border-white/20">
                            <div class="text-4xl font-extrabold text-[#F5A524]">{{ number_format($top->score, 1) }}%</div>
                            <div class="text-xs text-white/60 font-medium mt-1">Kecocokan</div>
                        </div>
                    </div>
                </div>

                {{-- Semua hasil --}}
                <div>
                    <h3 class="text-base font-extrabold text-[#111827] mb-4">Semua Hasil Ranking</h3>
                    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($searchResults as $index => $result)
                            <div class="relative bg-white rounded-2xl border border-[#E5E7EB] p-5 shadow-sm transition hover:border-[#C7D0EE] hover:shadow-md group overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#1A2B6B] to-[#F5A524] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <div class="flex items-center justify-between mb-4">
                                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-extrabold border
                                        {{ $index === 0 ? 'bg-[#F5A524] text-white border-[#F5A524]' : 'bg-[#F5F7FA] text-[#6B7280] border-[#E5E7EB]' }}">
                                        {{ $index + 1 }}
                                    </span>
                                    <span class="inline-flex rounded-lg bg-[#EEF1FB] px-2.5 py-1 text-xs font-bold text-[#1A2B6B] border border-[#C7D0EE]">
                                        Rekomendasi
                                    </span>
                                </div>
                                <h4 class="font-bold text-[#111827] text-base mb-4">{{ $result->career_name }}</h4>
                                <div class="mb-1 flex justify-between text-xs font-medium text-[#6B7280]">
                                    <span>Kecocokan</span>
                                    <span class="font-extrabold {{ $result->score >= 80 ? 'text-emerald-600' : 'text-[#1A2B6B]' }}">
                                        {{ number_format($result->score, 2) }}%
                                    </span>
                                </div>
                                <div class="h-2 bg-[#F5F7FA] rounded-full overflow-hidden border border-[#E5E7EB]">
                                    <div class="score-bar-fill h-full rounded-full {{ $result->score >= 80 ? 'bg-emerald-500' : 'bg-[#1A2B6B]' }}"
                                         data-target="{{ $result->score }}"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            @elseif (array_filter($criteria))
                <div class="rounded-2xl border border-amber-200 bg-amber-50 p-10 text-center">
                    <div class="w-16 h-16 mx-auto bg-amber-100 rounded-full flex items-center justify-center text-2xl mb-4">⚠️</div>
                    <p class="font-bold text-amber-900 text-lg">Tidak ada kecocokan tinggi</p>
                    <p class="mt-2 text-sm text-amber-700 max-w-md mx-auto">Coba perluas pilihan skill atau ubah jenjang pendidikan.</p>
                    <a href="{{ route('analysis.form') }}"
                       class="mt-5 inline-block bg-[#F5A524] hover:bg-[#D98D0F] text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-all">
                        Ubah Pencarian
                    </a>
                </div>
            @else
                <div class="rounded-2xl border-2 border-dashed border-[#E5E7EB] bg-white p-10 text-center">
                    <div class="w-16 h-16 mx-auto bg-white border border-[#E5E7EB] rounded-2xl flex items-center justify-center text-2xl shadow-sm mb-4">📊</div>
                    <p class="font-bold text-[#111827] text-lg">Belum Ada Hasil</p>
                    <p class="mt-2 text-sm text-[#6B7280] max-w-sm mx-auto">Kamu belum menjalankan analisis. Mulai sekarang untuk melihat rekomendasi karir.</p>
                    <a href="{{ route('analysis.form') }}"
                       class="mt-5 inline-flex items-center gap-2 bg-[#F5A524] hover:bg-[#D98D0F] text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-all">
                        Mulai Analisis
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            @endif

        </main>
    </div>

    <script>
        const bars = document.querySelectorAll('.score-bar-fill[data-target]');
        const obs  = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    setTimeout(() => { e.target.style.width = e.target.dataset.target + '%'; }, 150);
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.1 });
        bars.forEach(b => obs.observe(b));
    </script>
</x-app-layout>