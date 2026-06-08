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
        .selected-item {
            border-color:var(--blue) !important;
            background-color:var(--blue-light) !important;
            color:var(--blue) !important;
            font-weight:700;
        }
        .skill-group summary { list-style:none; cursor:pointer; }
        .skill-group summary::-webkit-details-marker { display:none; }
        .skill-group[open] .skill-group-chevron { transform:rotate(180deg); }
        .btn-orange { background:var(--orange); color:white; font-weight:600; transition:all 0.2s; }
        .btn-orange:hover { background:var(--orange-dark); transform:translateY(-1px); }
        .btn-outline-blue {
            background:white; color:var(--blue);
            border:1px solid var(--border); font-weight:600; transition:all 0.2s;
        }
        .btn-outline-blue:hover { border-color:var(--blue); background:var(--blue-light); }
        .animate-fade-in { animation:fadeIn 0.3s ease-in-out forwards; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(5px)} to{opacity:1;transform:translateY(0)} }
        .step-dot { width:8px; height:8px; border-radius:50%; background:var(--border); transition:all 0.2s; }
        .step-dot.done { background:var(--blue); }
        .step-dot.current { background:var(--orange); width:24px; border-radius:4px; }
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

            <main class="flex-1 w-full max-w-4xl mx-auto px-4 sm:px-8 py-10 min-w-0">

                <div class="mb-8">
                    <div class="inline-flex items-center gap-1.5 bg-[#EEF1FB] text-[#1A2B6B] text-[0.72rem] font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-[#C7D0EE] mb-3">
                        ✦ Analisis Karir
                    </div>
                    <h2 class="text-2xl font-extrabold text-[#111827]">Form Analisis Karir</h2>
                    <p class="mt-1 text-sm text-[#6B7280]">Ikuti 4 langkah berikut untuk mendapatkan rekomendasi yang akurat.</p>
                </div>

                <div class="bg-white rounded-3xl border border-[#E5E7EB] shadow-sm overflow-hidden">

                    {{-- Step header --}}
                    <div class="border-b border-[#E5E7EB] bg-[#F5F7FA] px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <span id="step-label" class="rounded-lg bg-[#1A2B6B] px-3 py-1 text-xs font-bold uppercase tracking-wider text-white">Step 1</span>
                            <span id="step-title" class="text-sm font-bold text-[#111827]">Data Pendidikan</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="flex gap-1.5 items-center">
                                <div class="step-dot current" id="dot-1"></div>
                                <div class="step-dot" id="dot-2"></div>
                                <div class="step-dot" id="dot-3"></div>
                                <div class="step-dot" id="dot-4"></div>
                            </div>
                            <span class="text-xs text-[#6B7280] font-medium">
                                <span id="current-step-number">1</span> / 4
                            </span>
                        </div>
                    </div>

                    {{-- Summary bar --}}
                    <div class="border-b border-[#E5E7EB] px-6 py-3 flex flex-wrap gap-2 text-xs text-[#6B7280] font-medium bg-white">
                        <span class="inline-flex items-center gap-1.5 rounded border border-[#E5E7EB] bg-[#F5F7FA] px-2.5 py-1">
                            Edu: <strong id="summary-edu" class="text-[#1A2B6B]">-</strong>
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded border border-[#E5E7EB] bg-[#F5F7FA] px-2.5 py-1">
                            Skill: <strong id="summary-skill" class="text-[#1A2B6B]">0</strong>
                        </span>
                        <span class="inline-flex items-center gap-1.5 rounded border border-[#E5E7EB] bg-[#F5F7FA] px-2.5 py-1">
                            Spesialisasi: <strong id="summary-spec" class="text-[#1A2B6B]">0</strong>
                        </span>
                    </div>

                    <form method="GET" action="{{ route('recommendation') }}" id="wizard-form">
                        <div class="px-6 py-8 min-h-[320px]">

                            {{-- Step 1: Pendidikan --}}
                            <div data-step="1" class="step-panel animate-fade-in">
                                <div class="space-y-4 max-w-xl">
                                    <p class="text-sm text-[#6B7280]">Pilih satu tingkat pendidikan yang paling mewakili status kamu saat ini.</p>
                                    <label for="education_id" class="block text-sm font-bold text-[#111827]">Jenjang Pendidikan</label>
                                    <select id="education_id" name="education_id"
                                        class="mt-2 block w-full rounded-xl border border-[#C7D0EE] bg-[#F5F7FA] px-4 py-3 text-[#111827] focus:border-[#1A2B6B] focus:bg-white focus:ring-2 focus:ring-[#EEF1FB] font-medium transition-colors outline-none">
                                        <option value="">Pilih pendidikan...</option>
                                        @foreach ($educations as $item)
                                            <option value="{{ $item->education_id }}">{{ $item->education_level }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Step 2: Skill --}}
                            <div data-step="2" class="step-panel hidden animate-fade-in">
                                <div class="space-y-4">
                                    <p class="text-sm text-[#6B7280]">Pilih skill yang kamu kuasai. Buka kategori dan klik kotak keahliannya.</p>
                                    <div class="space-y-3">
                                        @foreach ($skillGroups as $category => $groupSkills)
                                            <details class="skill-group rounded-xl border border-[#E5E7EB] bg-[#F5F7FA]"
                                                {{ $loop->first ? 'open' : '' }}>
                                                <summary class="flex items-center justify-between gap-3 px-5 py-3.5 text-sm font-bold text-[#111827] hover:bg-[#EEF1FB] transition-colors rounded-xl">
                                                    <span>{{ $category }}</span>
                                                    <span class="flex items-center gap-2 text-xs text-[#6B7280] font-semibold">
                                                        <span class="bg-white px-2 py-0.5 rounded border border-[#E5E7EB]">{{ count($groupSkills) }} skill</span>
                                                        <svg class="skill-group-chevron h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                </summary>
                                                <div class="grid gap-2.5 border-t border-[#E5E7EB] p-4 md:grid-cols-2 bg-white rounded-b-xl">
                                                    @foreach ($groupSkills as $item)
                                                        <button type="button"
                                                            data-value="{{ $item->skill_id }}"
                                                            data-group="skills"
                                                            class="skill-item text-left px-4 py-3 rounded-lg border border-[#E5E7EB] bg-white text-[#374151] font-medium text-sm transition hover:border-[#C7D0EE] hover:bg-[#F5F7FA]">
                                                            {{ $item->skill_name }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                            </details>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Step 3: Spesialisasi --}}
                            <div data-step="3" class="step-panel hidden animate-fade-in">
                                <div class="space-y-4">
                                    <p class="text-sm text-[#6B7280]">Spesialisasi mana yang menjadi fokus utama kamu?</p>
                                    <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-3">
                                        @foreach ($specializations as $item)
                                            <button type="button"
                                                data-value="{{ $item->specialization_id }}"
                                                data-group="specializations"
                                                class="specialization-item text-left px-5 py-4 rounded-xl border border-[#E5E7EB] bg-[#F5F7FA] text-[#374151] font-bold text-sm transition hover:border-[#1A2B6B] hover:bg-white">
                                                {{ $item->specialization_name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            {{-- Step 4: Sertifikasi --}}
                            <div data-step="4" class="step-panel hidden animate-fade-in">
                                <div class="space-y-4 max-w-xl">
                                    <p class="text-sm text-[#6B7280]">Jika kamu memiliki sertifikasi profesional, pilih dari daftar berikut (opsional).</p>
                                    <label for="certification_id" class="block text-sm font-bold text-[#111827]">Sertifikat Profesional</label>
                                    <select id="certification_id" name="certification_id"
                                        class="mt-2 block w-full rounded-xl border border-[#C7D0EE] bg-[#F5F7FA] px-4 py-3 text-[#111827] focus:border-[#1A2B6B] focus:bg-white focus:ring-2 focus:ring-[#EEF1FB] font-medium transition-colors outline-none">
                                        <option value="">-- Pilih sertifikat (Opsional) --</option>
                                        @foreach ($certifications as $item)
                                            <option value="{{ $item->certification_id }}">{{ $item->certification_name }}</option>
                                        @endforeach
                                    </select>

                                    <div class="mt-6 rounded-xl bg-[#F5F7FA] border border-[#E5E7EB] p-4 space-y-2">
                                        <p class="text-xs font-bold text-[#6B7280] uppercase tracking-wider mb-3">Ringkasan Pilihan Kamu</p>
                                        <div class="flex justify-between text-sm border-b border-[#E5E7EB] pb-2">
                                            <span class="text-[#6B7280]">Pendidikan</span>
                                            <span id="recap-edu" class="font-bold text-[#111827]">-</span>
                                        </div>
                                        <div class="flex justify-between text-sm border-b border-[#E5E7EB] pb-2">
                                            <span class="text-[#6B7280]">Skill dipilih</span>
                                            <span id="recap-skill" class="font-bold text-[#111827]">0 skill</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-[#6B7280]">Spesialisasi dipilih</span>
                                            <span id="recap-spec" class="font-bold text-[#111827]">0 spesialisasi</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="skill-inputs"></div>
                            <div id="specialization-inputs"></div>
                        </div>

                        {{-- Footer navigasi --}}
                        <div class="border-t border-[#E5E7EB] bg-[#F5F7FA] px-6 py-4 flex items-center justify-between gap-4">
                            <button id="prev-step" type="button"
                                class="btn-outline-blue px-5 py-2.5 rounded-xl text-sm disabled:opacity-40 disabled:cursor-not-allowed">
                                ← Kembali
                            </button>
                            <button id="next-step" type="button"
                                class="bg-[#1A2B6B] hover:bg-[#0D1B4B] text-white px-7 py-2.5 rounded-xl text-sm font-bold transition-colors">
                                Selanjutnya →
                            </button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>

    <script>
        // ===== SIDEBAR TOGGLE =====
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

        // ===== WIZARD FORM =====
        const stepPanels     = Array.from(document.querySelectorAll('.step-panel'));
        const stepLabel      = document.getElementById('step-label');
        const stepTitle      = document.getElementById('step-title');
        const currentStepNum = document.getElementById('current-step-number');
        const prevButton     = document.getElementById('prev-step');
        const nextButton     = document.getElementById('next-step');
        const form           = document.getElementById('wizard-form');
        const skillInputs    = document.getElementById('skill-inputs');
        const specInputs     = document.getElementById('specialization-inputs');
        const eduSelect      = document.getElementById('education_id');

        const stepTitles = ['Data Pendidikan', 'Pilih Skill', 'Pilih Spesialisasi', 'Sertifikasi & Review'];
        let currentStep  = 1;
        const maxStep    = 4;
        const selectedSkills = new Set();
        const selectedSpecs  = new Set();

        function updateStep() {
            stepPanels.forEach((p, i) => p.classList.toggle('hidden', i !== currentStep - 1));
            currentStepNum.textContent = currentStep;
            stepLabel.textContent      = `Step ${currentStep}`;
            stepTitle.textContent      = stepTitles[currentStep - 1];
            prevButton.disabled        = currentStep === 1;
            for (let i = 1; i <= 4; i++) {
                const dot = document.getElementById(`dot-${i}`);
                dot.classList.remove('done', 'current');
                if (i < currentStep)        dot.classList.add('done');
                else if (i === currentStep) dot.classList.add('current');
            }
            if (currentStep === maxStep) {
                nextButton.textContent = '🚀 Analisis Sekarang';
                nextButton.classList.add('btn-orange');
                nextButton.classList.remove('bg-[#1A2B6B]', 'hover:bg-[#0D1B4B]');
            } else {
                nextButton.textContent = 'Selanjutnya →';
                nextButton.classList.remove('btn-orange');
                nextButton.classList.add('bg-[#1A2B6B]', 'hover:bg-[#0D1B4B]');
            }
            updateSummary();
        }

        function updateSummary() {
            const sel     = eduSelect.options[eduSelect.selectedIndex];
            const eduText = sel && sel.value ? sel.text : '-';
            document.getElementById('summary-edu').textContent   = eduText;
            document.getElementById('summary-skill').textContent = selectedSkills.size;
            document.getElementById('summary-spec').textContent  = selectedSpecs.size;
            const re = document.getElementById('recap-edu');
            const rs = document.getElementById('recap-skill');
            const rp = document.getElementById('recap-spec');
            if (re) re.textContent = eduText;
            if (rs) rs.textContent = `${selectedSkills.size} skill`;
            if (rp) rp.textContent = `${selectedSpecs.size} spesialisasi`;
        }

        function toggleSelection(item, selectedSet) {
            const value = item.dataset.value;
            if (selectedSet.has(value)) {
                selectedSet.delete(value);
                item.classList.remove('selected-item');
            } else {
                selectedSet.add(value);
                item.classList.add('selected-item');
            }
            updateHiddenInputs();
            updateSummary();
        }

        function updateHiddenInputs() {
            skillInputs.innerHTML = '';
            specInputs.innerHTML  = '';
            selectedSkills.forEach(v => {
                const inp = document.createElement('input');
                inp.type = 'hidden'; inp.name = 'skill_ids[]'; inp.value = v;
                skillInputs.appendChild(inp);
            });
            selectedSpecs.forEach(v => {
                const inp = document.createElement('input');
                inp.type = 'hidden'; inp.name = 'specialization_ids[]'; inp.value = v;
                specInputs.appendChild(inp);
            });
        }

        document.querySelectorAll('.skill-item').forEach(item =>
            item.addEventListener('click', () => toggleSelection(item, selectedSkills))
        );
        document.querySelectorAll('.specialization-item').forEach(item =>
            item.addEventListener('click', () => toggleSelection(item, selectedSpecs))
        );
        eduSelect.addEventListener('change', updateSummary);

        prevButton.addEventListener('click', () => {
            if (currentStep > 1) { currentStep--; updateStep(); }
        });
        nextButton.addEventListener('click', () => {
            if (currentStep < maxStep) { currentStep++; updateStep(); }
            else { updateHiddenInputs(); form.submit(); }
        });

        updateStep();
    </script>
</x-app-layout>