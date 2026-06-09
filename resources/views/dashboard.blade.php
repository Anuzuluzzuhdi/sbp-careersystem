<x-app-layout>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

    <style>
        :root {
            --dash-blue: #1A2B6B;
            --dash-blue-light: #EEF1FB;
            --dash-blue-mid: #C7D0EE;
            --dash-ink: #111827;
            --dash-muted: #6B7280;
            --dash-border: #E5E7EB;
            --dash-bg: #F5F7FA;
        }

        .dashboard-page { background: #fff; min-height: calc(100vh - 4rem); }
        .dashboard-hero {
            text-align: center;
            padding: 2.5rem 1.5rem 1.5rem;
            border-bottom: 1px solid var(--dash-border);
            background: linear-gradient(180deg, #fff 0%, var(--dash-bg) 100%);
        }
        .dashboard-hero-label {
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--dash-blue);
            margin-bottom: 0.5rem;
        }
        .dashboard-hero-title {
            font-size: clamp(1.6rem, 2.5vw, 2.2rem);
            font-weight: 800;
            color: var(--dash-ink);
            letter-spacing: -0.02em;
        }
        .dashboard-hero-sub {
            margin-top: 0.75rem;
            font-size: 0.92rem;
            color: var(--dash-muted);
            max-width: 640px;
            margin-left: auto;
            margin-right: auto;
        }
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem;
        }
        .dashboard-stat {
            background: #fff;
            border: 1px solid var(--dash-border);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            text-align: center;
        }
        .dashboard-stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--dash-blue);
        }
        .dashboard-stat-label {
            font-size: 0.75rem;
            color: var(--dash-muted);
            margin-top: 0.25rem;
        }
        .careers-layout {
            display: grid;
            grid-template-columns: 240px 1fr;
            border: 1px solid var(--dash-border);
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 16px rgba(26, 43, 107, 0.06);
            max-width: 1200px;
            margin: 0 auto 2.5rem;
        }
        .careers-sidebar {
            background: var(--dash-bg);
            border-right: 1px solid var(--dash-border);
            padding: 8px 0;
            max-height: 520px;
            overflow-y: auto;
        }
        .career-tab {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            padding: 0.75rem 1.2rem;
            font-size: 0.82rem;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            transition: all 0.15s;
            border-left: 3px solid transparent;
            text-align: left;
            width: 100%;
            background: transparent;
            border-top: none;
            border-right: none;
            border-bottom: none;
        }
        .career-tab:hover { background: var(--dash-blue-light); color: var(--dash-blue); }
        .career-tab.active {
            background: var(--dash-blue-light);
            color: var(--dash-blue);
            font-weight: 600;
            border-left-color: var(--dash-blue);
        }
        .career-tab-score {
            font-size: 0.65rem;
            font-weight: 700;
            color: var(--dash-blue);
            background: #fff;
            border: 1px solid var(--dash-blue-mid);
            border-radius: 999px;
            padding: 0.1rem 0.45rem;
            flex-shrink: 0;
        }
        .careers-detail { padding: 2rem; min-height: 420px; }
        .detail-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }
        .detail-title { font-size: 1.35rem; font-weight: 700; color: var(--dash-ink); margin-bottom: 0.4rem; }
        .detail-desc { font-size: 0.85rem; color: var(--dash-muted); max-width: 480px; line-height: 1.65; }
        .match-badge {
            background: var(--dash-blue);
            color: #fff;
            border-radius: 12px;
            padding: 0.65rem 1rem;
            text-align: center;
            flex-shrink: 0;
            min-width: 90px;
        }
        .match-pct { font-size: 1.5rem; font-weight: 800; line-height: 1; }
        .match-label { font-size: 0.65rem; font-weight: 500; opacity: 0.85; margin-top: 0.15rem; }
        .skills-heading {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--dash-muted);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 0.6rem;
        }
        .skill-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1.5rem; }
        .skill-chip {
            font-size: 0.72rem;
            font-weight: 500;
            padding: 0.35rem 0.75rem;
            border-radius: 6px;
            background: var(--dash-blue-light);
            color: var(--dash-blue);
            border: 1px solid var(--dash-blue-mid);
        }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .detail-box {
            background: var(--dash-bg);
            border-radius: 10px;
            padding: 1rem;
            border: 1px solid var(--dash-border);
        }
        .detail-box-title {
            font-size: 0.72rem;
            font-weight: 600;
            color: var(--dash-muted);
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }
        .grade-row {
            display: flex;
            justify-content: space-between;
            font-size: 0.78rem;
            padding: 0.35rem 0;
            border-bottom: 1px solid var(--dash-border);
        }
        .grade-row:last-child { border-bottom: none; }
        .grade-row span:last-child { font-weight: 600; color: var(--dash-blue); }
        .mini-bars { display: flex; align-items: flex-end; gap: 6px; height: 70px; margin-top: 0.5rem; }
        .mini-bar-wrap { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 4px; height: 100%; justify-content: flex-end; }
        .mini-bar {
            width: 100%;
            background: var(--dash-blue-mid);
            border-radius: 4px 4px 0 0;
            min-height: 8px;
        }
        .mini-bar-label {
            font-size: 0.55rem;
            color: var(--dash-muted);
            text-align: center;
            line-height: 1.2;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .empty-explorer {
            max-width: 1200px;
            margin: 0 auto 2.5rem;
            border: 1px dashed var(--dash-border);
            border-radius: 16px;
            padding: 3rem 1.5rem;
            text-align: center;
            color: var(--dash-muted);
            background: var(--dash-bg);
        }
        .selected {
            border-color: #6366f1 !important;
            background-color: #eef2ff !important;
            color: #1f2937 !important;
        }
        .skill-group summary { list-style: none; cursor: pointer; }
        .skill-group summary::-webkit-details-marker { display: none; }
        .skill-group[open] .skill-group-chevron { transform: rotate(180deg); }

        @media (max-width: 900px) {
            .dashboard-stats { grid-template-columns: repeat(2, 1fr); }
            .careers-layout { grid-template-columns: 1fr; }
            .careers-sidebar {
                display: flex;
                overflow-x: auto;
                max-height: none;
                border-right: none;
                border-bottom: 1px solid var(--dash-border);
            }
            .career-tab {
                white-space: nowrap;
                border-left: none;
                border-bottom: 3px solid transparent;
                width: auto;
            }
            .career-tab.active { border-left: none; border-bottom-color: var(--dash-blue); }
            .detail-header { flex-direction: column; }
            .detail-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="dashboard-page">
        <div class="dashboard-hero">
            <div class="dashboard-hero-label">Dashboard Karir</div>
            <h1 class="dashboard-hero-title">Eksplorasi Spektrum Karier IT</h1>
            <p class="dashboard-hero-sub">
                Temukan detail setiap peran, keahlian yang dibutuhkan, dan bagaimana profil Anda mencocokkan standar industri.
            </p>
        </div>

        <div class="dashboard-stats">
            <div class="dashboard-stat">
                <div class="dashboard-stat-value">{{ $careers->count() }}</div>
                <div class="dashboard-stat-label">Total Karir</div>
            </div>
            <div class="dashboard-stat">
                <div class="dashboard-stat-value">{{ $educations->count() }}</div>
                <div class="dashboard-stat-label">Pilihan Pendidikan</div>
            </div>
            <div class="dashboard-stat">
                <div class="dashboard-stat-value">{{ $skills->count() }}</div>
                <div class="dashboard-stat-label">Skill Tersedia</div>
            </div>
            <div class="dashboard-stat">
                <div class="dashboard-stat-value">{{ $specializations->count() + $certifications->count() }}</div>
                <div class="dashboard-stat-label">Spesialisasi & Sertifikat</div>
            </div>
        </div>

        @if ($careerProfiles->isNotEmpty())
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="careers-layout">
                    <div class="careers-sidebar" id="careerSidebar">
                        @foreach ($careerProfiles as $profile)
                            <button
                                type="button"
                                class="career-tab {{ $profile['career_id'] === $selectedCareerId ? 'active' : '' }}"
                                data-career-id="{{ $profile['career_id'] }}"
                            >
                                <span>{{ $profile['name'] }}</span>
                                <span class="flex items-center gap-1">
                                    @if (! is_null($profile['score']))
                                        <span class="career-tab-score">{{ number_format($profile['score'], 0) }}%</span>
                                    @endif
                                    <i class="ti ti-chevron-right text-sm opacity-40"></i>
                                </span>
                            </button>
                        @endforeach
                    </div>
                    <div class="careers-detail" id="careerDetail"></div>
                </div>
            </div>
        @else
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="empty-explorer">
                    <p class="font-medium text-slate-700">Belum ada data karir untuk ditampilkan.</p>
                </div>
            </div>
        @endif
    </div>

    <div id="search-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 px-4 py-6">
        <div class="flex max-h-[92vh] w-full max-w-4xl flex-col overflow-hidden rounded-3xl bg-white text-slate-900 shadow-2xl">
            <div class="flex shrink-0 items-center justify-between border-b border-slate-200 px-6 py-5">
                <div>
                    <h3 class="text-xl font-semibold">Mulai Analisis Karir</h3>
                    <p class="mt-1 text-sm text-slate-500">Ikuti langkah berikut untuk memilih kriteria dan lihat rekomendasi karir.</p>
                </div>
                <button id="close-search-modal" type="button" class="rounded-full border border-slate-200 bg-white px-3 py-2 text-slate-600 transition hover:bg-slate-100">
                    Close
                </button>
            </div>

            <form method="GET" action="{{ route('dashboard') }}" id="wizard-form" class="flex min-h-0 flex-1 flex-col">
                <div class="shrink-0 border-b border-slate-200 bg-slate-50 px-6 py-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3">
                            <span id="step-label" class="rounded-full bg-indigo-700 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">Step 1</span>
                            <span class="text-sm font-medium text-slate-700">{{ request()->query('education_id') ? 'Lengkapi kriteria Anda' : 'Pilih data pendidikan terlebih dahulu' }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2 text-sm text-slate-500">
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 shadow-sm">
                                Education: <strong class="text-slate-800">{{ optional($educations->firstWhere('education_id', request('education_id')))->education_level ?? 'Belum pilih' }}</strong>
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 shadow-sm">
                                Skills: <strong class="text-slate-800">{{ count(request('skill_ids', [])) }} dipilih</strong>
                            </span>
                            <span class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 shadow-sm">
                                Specializations: <strong class="text-slate-800">{{ count(request('specialization_ids', [])) }} dipilih</strong>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="min-h-0 flex-1 overflow-y-auto px-6 py-6">
                    <div data-step="1" class="step-panel">
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600">Pilih satu pendidikan yang paling mendekati latar belakang Anda.</p>
                            <label for="education_id" class="block text-sm font-medium text-slate-700">Education</label>
                            <select id="education_id" name="education_id" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
                                <option value="">Pilih pendidikan</option>
                                @foreach ($educations as $item)
                                    <option value="{{ $item->education_id }}" {{ request('education_id') == $item->education_id ? 'selected' : '' }}>{{ $item->education_level }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div data-step="2" class="step-panel hidden">
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600">Buka kategori skill, lalu klik skill yang Anda miliki.</p>
                            <div class="space-y-3">
                                @foreach ($skillGroups as $category => $groupSkills)
                                    <details class="skill-group rounded-2xl border border-slate-200 bg-white" {{ $loop->first ? 'open' : '' }}>
                                        <summary class="flex items-center justify-between gap-3 px-4 py-3 text-sm font-semibold text-slate-800">
                                            <span>{{ $category }}</span>
                                            <span class="flex items-center gap-2 text-xs font-medium text-slate-500">
                                                <span>{{ count($groupSkills) }} skill</span>
                                                <svg class="skill-group-chevron h-4 w-4 transition-transform" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd" /></svg>
                                            </span>
                                        </summary>
                                        <div class="grid gap-2 border-t border-slate-200 p-3 md:grid-cols-2">
                                            @foreach ($groupSkills as $item)
                                                <button type="button" data-value="{{ $item->skill_id }}" data-group="skills" class="skill-item rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-left text-slate-800 shadow-sm transition hover:border-indigo-400 hover:bg-indigo-50 {{ in_array($item->skill_id, request('skill_ids', [])) ? 'selected border-indigo-500 bg-indigo-50 text-indigo-900' : '' }}">
                                                    <div class="flex items-center justify-between gap-2">
                                                        <span class="font-medium">{{ $item->skill_name }}</span>
                                                        <span class="text-xs text-slate-500">Skill</span>
                                                    </div>
                                                </button>
                                            @endforeach
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div data-step="3" class="step-panel hidden">
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600">Pilih spesialisasi yang relevan dengan tujuan karir Anda.</p>
                            <div class="grid gap-3 md:grid-cols-2">
                                @foreach ($specializations as $item)
                                    <button type="button" data-value="{{ $item->specialization_id }}" data-group="specializations" class="specialization-item rounded-2xl border border-slate-200 bg-white px-4 py-3 text-left text-slate-800 shadow-sm transition hover:border-indigo-400 hover:bg-indigo-50 {{ in_array($item->specialization_id, request('specialization_ids', [])) ? 'selected border-indigo-500 bg-indigo-50 text-indigo-900' : '' }}">
                                        <div class="flex items-center justify-between gap-2">
                                            <span class="font-medium">{{ $item->specialization_name }}</span>
                                            <span class="text-xs text-slate-500">Spesialisasi</span>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div data-step="4" class="step-panel hidden">
                        <div class="space-y-4">
                            <p class="text-sm text-slate-600">Pilih satu sertifikat yang paling mewakili kemampuan Anda.</p>
                            <label for="certification_id" class="block text-sm font-medium text-slate-700">Sertifikat</label>
                            <select id="certification_id" name="certification_id" class="mt-2 block w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500">
                                <option value="">Pilih sertifikat</option>
                                @foreach ($certifications as $item)
                                    <option value="{{ $item->certification_id }}" {{ request('certification_id') == $item->certification_id ? 'selected' : '' }}>{{ $item->certification_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div id="skill-inputs"></div>
                    <div id="specialization-inputs"></div>
                </div>

                <div class="shrink-0 border-t border-slate-200 bg-white px-6 py-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <button id="prev-step" type="button" class="inline-flex items-center justify-center rounded-2xl border border-slate-300 bg-white px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-100">Back</button>
                            <button id="next-step" type="button" class="inline-flex items-center justify-center rounded-2xl bg-indigo-700 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-600">Next</button>
                        </div>
                        <div class="text-sm text-slate-500">Step <span id="current-step-number">1</span> dari 4</div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const careerProfiles = @json($careerProfiles);
        let activeCareerId = @json($selectedCareerId);

        function renderCareerDetail(profile) {
            const scoreHtml = profile.score !== null && profile.score !== undefined
                ? `<div class="match-pct">${Number(profile.score).toFixed(profile.score % 1 === 0 ? 0 : 2)}%</div>`
                : `<div class="match-pct">—</div>`;

            const skillsHtml = (profile.top_skills || []).map(skill =>
                `<span class="skill-chip">${skill}</span>`
            ).join('');

            const educationHtml = (profile.education_analysis || []).map(item =>
                `<div class="grade-row"><span>${item.label}</span><span>${(Number(item.weight) * 100).toFixed(1)}%</span></div>`
            ).join('');

            const maxBar = Math.max(...(profile.specialization_bars || []).map(item => Number(item.weight)), 0.01);
            const barsHtml = (profile.specialization_bars || []).map(item => {
                const height = Math.max(12, Math.round((Number(item.weight) / maxBar) * 100));
                return `<div class="mini-bar-wrap"><div class="mini-bar" style="height:${height}%"></div><div class="mini-bar-label">${item.label}</div></div>`;
            }).join('');

            document.getElementById('careerDetail').innerHTML = `
                <div class="detail-header">
                    <div>
                        <div class="detail-title">${profile.name}</div>
                        <div class="detail-desc">${profile.description}</div>
                    </div>
                    <div class="match-badge">
                        ${scoreHtml}
                        <div class="match-label">Kesesuaian</div>
                    </div>
                </div>
                <div>
                    <div class="skills-heading">Keahlian Utama</div>
                    <div class="skill-chips">${skillsHtml || '<span class="text-sm text-slate-500">Belum ada data skill.</span>'}</div>
                </div>
                <div class="detail-grid">
                    <div class="detail-box">
                        <div class="detail-box-title">🎓 Analisis Akademik</div>
                        ${educationHtml || '<p class="text-sm text-slate-500">Belum ada data pendidikan.</p>'}
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-title">💡 Analisis Minat</div>
                        <div class="mini-bars">${barsHtml || '<p class="text-sm text-slate-500">Belum ada data spesialisasi.</p>'}</div>
                    </div>
                </div>
            `;
        }

        function selectCareer(careerId) {
            activeCareerId = careerId;
            document.querySelectorAll('.career-tab').forEach(tab => {
                tab.classList.toggle('active', Number(tab.dataset.careerId) === Number(careerId));
            });
            const profile = careerProfiles.find(item => Number(item.career_id) === Number(careerId));
            if (profile) {
                renderCareerDetail(profile);
            }
        }

        document.querySelectorAll('.career-tab').forEach(tab => {
            tab.addEventListener('click', () => selectCareer(tab.dataset.careerId));
        });

        if (careerProfiles.length) {
            selectCareer(activeCareerId || careerProfiles[0].career_id);
        }

        const modal = document.getElementById('search-modal');
        const openButtons = [
            document.getElementById('open-search-modal-nav'),
            document.getElementById('open-search-modal-nav-mobile'),
        ].filter(Boolean);
        const closeButton = document.getElementById('close-search-modal');
        const stepPanels = Array.from(document.querySelectorAll('.step-panel'));
        const stepLabel = document.getElementById('step-label');
        const currentStepNumber = document.getElementById('current-step-number');
        const prevButton = document.getElementById('prev-step');
        const nextButton = document.getElementById('next-step');
        const skillItems = Array.from(document.querySelectorAll('.skill-item'));
        const specializationItems = Array.from(document.querySelectorAll('.specialization-item'));
        const form = document.getElementById('wizard-form');
        const skillInputs = document.getElementById('skill-inputs');
        const specializationInputs = document.getElementById('specialization-inputs');

        let currentStep = 1;
        const maxStep = 4;
        const selectedSkills = new Set(@json(array_map('strval', (array) request('skill_ids', []))));
        const selectedSpecializations = new Set(@json(array_map('strval', (array) request('specialization_ids', []))));

        function openModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            updateStep();
        }

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function updateStep() {
            stepPanels.forEach((panel, index) => {
                panel.classList.toggle('hidden', index !== currentStep - 1);
            });
            currentStepNumber.textContent = currentStep;
            stepLabel.textContent = `Step ${currentStep}`;
            prevButton.disabled = currentStep === 1;
            nextButton.textContent = currentStep === maxStep ? 'Cari Sekarang' : 'Next';
        }

        function toggleSelection(item, selectedSet) {
            const value = item.dataset.value;
            if (selectedSet.has(value)) {
                selectedSet.delete(value);
                item.classList.remove('border-indigo-500', 'bg-indigo-50', 'text-indigo-900', 'selected');
            } else {
                selectedSet.add(value);
                item.classList.add('border-indigo-500', 'bg-indigo-50', 'text-indigo-900', 'selected');
            }
            updateHiddenInputs();
        }

        function restoreSelections(items, selectedSet) {
            items.forEach((item) => {
                if (selectedSet.has(item.dataset.value)) {
                    item.classList.add('border-indigo-500', 'bg-indigo-50', 'text-indigo-900', 'selected');
                }
            });
        }

        function updateHiddenInputs() {
            skillInputs.innerHTML = '';
            specializationInputs.innerHTML = '';

            selectedSkills.forEach((value) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'skill_ids[]';
                input.value = value;
                skillInputs.appendChild(input);
            });

            selectedSpecializations.forEach((value) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'specialization_ids[]';
                input.value = value;
                specializationInputs.appendChild(input);
            });
        }

        skillItems.forEach((item) => item.addEventListener('click', () => toggleSelection(item, selectedSkills)));
        specializationItems.forEach((item) => item.addEventListener('click', () => toggleSelection(item, selectedSpecializations)));
        restoreSelections(skillItems, selectedSkills);
        restoreSelections(specializationItems, selectedSpecializations);
        updateHiddenInputs();

        prevButton.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep -= 1;
                updateStep();
            }
        });

        nextButton.addEventListener('click', () => {
            if (currentStep < maxStep) {
                currentStep += 1;
                updateStep();
            } else {
                updateHiddenInputs();
                form.submit();
            }
        });

        form.addEventListener('submit', updateHiddenInputs);
        openButtons.forEach(button => button.addEventListener('click', openModal));
        closeButton.addEventListener('click', closeModal);
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModal();
            }
        });

        const shouldOpenModal = @json(array_filter($criteria) ? true : false);
        if (shouldOpenModal) {
            currentStep = maxStep;
            openModal();
        }
    </script>
</x-app-layout>
