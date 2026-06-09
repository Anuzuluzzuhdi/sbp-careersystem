<x-app-layout>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .font-jakarta { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        :root {
            --blue: #1A2B6B; --blue-dark: #0D1B4B; --blue-light: #EEF1FB;
            --blue-mid: #C7D0EE; --ink: #111827; --body: #374151;
            --muted: #6B7280; --border: #E5E7EB; --bg: #F0F4F8;
            --orange: #F5A524; --orange-dark: #D98D0F;
            --glass-border: rgba(255, 255, 255, 0.6);
        }
        
        /* ===== BACKGROUND MESH (Diperkaya warnanya) ===== */
        .main-workspace {
            position: relative;
            z-index: 1;
            background-color: var(--bg);
        }
        .main-workspace::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 70% 70% at 85% 5%, rgba(79, 70, 229, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse 60% 60% at 15% 85%, rgba(245, 165, 36, 0.08) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 50% 50%, rgba(26, 43, 107, 0.04) 0%, transparent 60%);
            z-index: -1;
            pointer-events: none;
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
        #sidebar.desktop-collapsed { width: 0 !important; overflow: hidden; border-right: none; }
        
        .selected-item {
            border-color: var(--orange) !important;
            background-color: #FFF8ED !important;
            color: var(--orange-dark) !important;
            font-weight: 800 !important;
            box-shadow: 0 4px 15px rgba(245, 165, 36, 0.15) !important;
            transform: translateY(-2px);
        }
        .skill-group summary { list-style: none; cursor: pointer; }
        .skill-group summary::-webkit-details-marker { display: none; }
        .skill-group[open] .skill-group-chevron { transform: rotate(180deg); }

        /* ===== FORM GLASS CARD (Efek Premium 3D) ===== */
        .form-glass-card {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.75) 100%);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 32px;
            box-shadow: 0 20px 40px rgba(26, 43, 107, 0.06), inset 0 1px 0 rgba(255,255,255,1);
            padding: 3rem;
            margin-top: 1rem;
        }

        /* ===== STEP TRACKER (Bukan lagi putih flat, tapi glass) ===== */
        .step-track {
            display: flex; align-items: flex-start; gap: 0;
            position: relative; margin-bottom: 2.5rem;
            background: rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(12px);
            padding: 1.5rem;
            border-radius: 24px; 
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        }
        .step-track-item {
            flex: 1; display: flex; flex-direction: column;
            align-items: center; position: relative;
        }
        .step-track-item:not(:last-child)::after {
            content: ''; position: absolute; top: 20px; left: 50%;
            width: 100%; height: 4px; background: var(--blue-light);
            transition: background 0.4s ease; z-index: 0;
            border-radius: 2px;
        }
        .step-track-item.done:not(:last-child)::after {
            background: linear-gradient(to right, var(--blue), #4F46E5);
        }
        .step-circle {
            width: 44px; height: 44px; border-radius: 50%;
            border: 3px solid white; background: #F8FAFC;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.9rem; font-weight: 800; color: var(--muted);
            position: relative; z-index: 1; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .step-track-item.done .step-circle {
            background: linear-gradient(135deg, var(--blue), #4F46E5); 
            border-color: transparent; color: white;
            box-shadow: 0 4px 15px rgba(26,43,107,0.3);
        }
        .step-track-item.current .step-circle {
            background: linear-gradient(135deg, var(--orange), var(--orange-dark)); 
            border-color: transparent; color: white;
            box-shadow: 0 0 0 6px rgba(245, 165, 36, 0.15), 0 4px 15px rgba(245, 165, 36, 0.3);
            transform: scale(1.1);
        }
        .step-label-text {
            margin-top: 14px; font-size: 0.8rem; font-weight: 700;
            color: var(--muted); text-align: center; transition: all 0.3s;
            white-space: nowrap; letter-spacing: 0.02em;
        }
        .step-track-item.current .step-label-text { color: var(--orange-dark); font-weight: 800; transform: translateY(2px); }
        .step-track-item.done .step-label-text { color: var(--blue); }

        /* ===== SUMMARY CHIPS ===== */
        .summary-bar {
            display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 2.5rem;
            padding-bottom: 2rem; border-bottom: 1px dashed var(--blue-mid);
        }
        .summary-chip {
            display: inline-flex; align-items: center; gap: 8px;
            background: white; border: 1px solid rgba(26,43,107,0.1);
            border-radius: 999px; padding: 0.5rem 1.25rem;
            font-size: 0.8rem; color: var(--body); font-weight: 600;
            box-shadow: 0 4px 12px rgba(26,43,107,0.04);
            transition: transform 0.2s;
        }
        .summary-chip:hover { transform: translateY(-2px); }
        .summary-chip svg { color: var(--orange); }
        .summary-chip strong { color: var(--blue); font-weight: 800; }

        /* ===== STEP PANEL ===== */
        .step-panel { animation: fadeUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards; }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ===== STEP HEADER ===== */
        .step-heading {
            display: flex; align-items: center; gap: 12px; margin-bottom: 0.5rem;
        }
        .step-heading-badge {
            background: linear-gradient(135deg, var(--blue-light), white); 
            color: var(--blue); font-size: 0.7rem; font-weight: 800; 
            letter-spacing: 0.08em; text-transform: uppercase; 
            padding: 6px 14px; border-radius: 10px; border: 1px solid var(--blue-mid);
            box-shadow: 0 2px 8px rgba(26,43,107,0.05);
        }
        .step-heading h3 {
            font-size: 1.6rem; font-weight: 800; color: var(--ink); margin: 0; letter-spacing: -0.02em;
        }

        /* ===== SELECT STYLED ===== */
        .field-select {
            display: block; width: 100%; max-width: 400px;
            border-radius: 14px; border: 2px solid #E2E8F0;
            background: #F8FAFC; padding: 1rem 1.2rem;
            color: var(--ink); font-size: 0.95rem; font-weight: 700;
            font-family: 'Plus Jakarta Sans', sans-serif;
            outline: none; transition: all 0.3s; cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 20 20' fill='%236B7280'%3E%3Cpath fill-rule='evenodd' d='M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z' clip-rule='evenodd'/%3E%3C/svg%3E");
            background-repeat: no-repeat; background-position: right 1.2rem center;
            padding-right: 3rem;
        }
        .field-select:focus {
            background: white; border-color: var(--blue); 
            box-shadow: 0 0 0 5px rgba(26,43,107,0.1);
        }

        /* ===== SKILL GROUPS ===== */
        .skill-group {
            background: white; border: 2px solid transparent;
            border-radius: 20px; overflow: hidden; transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            margin-bottom: 1rem;
        }
        .skill-group:has(.selected-item) { border-color: rgba(245, 165, 36, 0.3); background: #FFFCF8; }
        .skill-group summary {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1.25rem 1.5rem; font-weight: 800; font-size: 1rem; 
            color: var(--ink); cursor: pointer; transition: background 0.2s; user-select: none;
        }
        .skill-group summary:hover { background: #F8FAFC; }
        .skill-group-inner {
            display: grid; gap: 0.85rem; padding: 0 1.5rem 1.5rem;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        }
        .skill-item, .specialization-item {
            text-align: left; padding: 1rem 1.2rem;
            border-radius: 14px; border: 2px solid #F1F5F9;
            background: white; color: var(--body);
            font-weight: 600; font-size: 0.9rem;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer; transition: all 0.2s;
            box-shadow: 0 2px 6px rgba(0,0,0,0.01);
        }
        .skill-item:hover, .specialization-item:hover {
            border-color: var(--blue-mid); background: var(--blue-light); color: var(--blue);
            transform: translateY(-2px); box-shadow: 0 6px 15px rgba(26,43,107,0.08);
        }

        /* ===== SPECIALIZATIONS ===== */
        .spec-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 1.2rem;
        }
        .specialization-item {
            display: flex; align-items: center; justify-content: space-between;
        }

        /* ===== RECAP CARD ===== */
        .recap-card {
            background: white; border: 1px solid var(--border);
            border-radius: 24px; overflow: hidden;
            box-shadow: 0 15px 35px rgba(26,43,107,0.06);
            max-width: 600px;
        }
        .recap-card-header {
            background: linear-gradient(135deg, var(--blue) 0%, #3B5BBD 100%);
            padding: 1.75rem; color: white; position: relative;
        }
        .recap-card-header::after {
            content: ''; position: absolute; top: 0; right: 0; bottom: 0; left: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .recap-card-header p {
            font-size: 0.75rem; font-weight: 800; letter-spacing: 0.1em;
            text-transform: uppercase; opacity: 0.8; margin: 0 0 6px; position: relative; z-index: 1;
        }
        .recap-card-header h4 { font-size: 1.25rem; font-weight: 800; margin: 0; position: relative; z-index: 1; }
        .recap-row {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1.25rem 1.75rem; border-bottom: 1px solid var(--border); font-size: 0.95rem;
        }
        .recap-row:last-child { border-bottom: none; }
        .recap-row span:first-child { color: var(--muted); font-weight: 600; }
        .recap-row span:last-child { color: var(--ink); font-weight: 800; }

        /* ===== NAV BUTTONS ===== */
        .btn-orange {
            background: linear-gradient(to right, var(--orange), var(--orange-dark)); 
            color: white; font-weight: 800; transition: all 0.3s; font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: 0 4px 15px rgba(245, 165, 36, 0.4); border: none;
        }
        .btn-orange:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(245, 165, 36, 0.5); }
        .btn-outline-blue {
            background: white; color: var(--blue); border: 2px solid var(--blue-mid);
            font-weight: 800; transition: all 0.3s; font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .btn-outline-blue:hover { border-color: var(--blue); background: var(--blue-light); box-shadow: 0 4px 15px rgba(26,43,107,0.1); }
        .btn-primary {
            background: linear-gradient(to right, var(--blue), #3B5BBD); 
            color: white; font-weight: 800; transition: all 0.3s; font-family: 'Plus Jakarta Sans', sans-serif;
            box-shadow: 0 4px 15px rgba(26, 43, 107, 0.3); border: none;
        }
        .btn-primary:hover { transform: translateY(-3px); box-shadow: 0 8px 25px rgba(26, 43, 107, 0.4); }

        .wizard-nav {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 3rem; padding-top: 2rem; border-top: 1px dashed var(--blue-mid);
        }
    </style>

    <div class="font-jakarta flex flex-col min-h-screen">

        {{-- HEADER (TETAP SAMA) --}}
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

        <div class="flex flex-1">
            @include('partials.sidebar')

            {{-- DI SINI PERUBAHAN UTAMANYA: w-full tanpa max-w-7xl, padding disamakan dengan dashboard --}}
            <main class="main-workspace flex-1 w-full px-6 sm:px-10 lg:px-12 pt-8 pb-16 min-w-0 flex flex-col">

                {{-- Page title section (Lebih Premium) --}}
                <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4 relative z-10">
                    <div>
                        <div class="inline-flex items-center gap-2 bg-white/60 backdrop-blur-sm text-[#1A2B6B] text-[0.75rem] font-bold uppercase tracking-widest px-4 py-2 rounded-full border border-white mb-4 shadow-sm">
                            <span class="text-[#F5A524]">✦</span> Analisis Karir
                        </div>
                        <h2 class="text-4xl md:text-5xl font-extrabold text-[#111827] tracking-tight leading-tight">
                            Eksplorasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1A2B6B] to-[#4F46E5]">Potensi Karirmu</span>
                        </h2>
                        <p class="mt-3 text-[1rem] text-[#6B7280] max-w-2xl leading-relaxed font-medium">Lengkapi profil akademik dan keahlianmu. Sistem AI kami akan memproses dan mencocokkan profilmu dengan ratusan standar industri teknologi saat ini.</p>
                    </div>
                </div>

                {{-- Step tracker --}}
                <div class="step-track" id="step-tracker">
                    <div class="step-track-item current" id="track-1">
                        <div class="step-circle">
                            <svg class="w-5 h-5 check-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span class="step-num">1</span>
                        </div>
                        <span class="step-label-text">Pendidikan</span>
                    </div>
                    <div class="step-track-item" id="track-2">
                        <div class="step-circle">
                            <svg class="w-5 h-5 check-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span class="step-num">2</span>
                        </div>
                        <span class="step-label-text">Keahlian (Skill)</span>
                    </div>
                    <div class="step-track-item" id="track-3">
                        <div class="step-circle">
                            <svg class="w-5 h-5 check-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span class="step-num">3</span>
                        </div>
                        <span class="step-label-text">Spesialisasi</span>
                    </div>
                    <div class="step-track-item" id="track-4">
                        <div class="step-circle">
                            <svg class="w-5 h-5 check-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span class="step-num">4</span>
                        </div>
                        <span class="step-label-text">Review & Analisis</span>
                    </div>
                </div>

                <div class="form-glass-card flex-1">
                    {{-- Summary chips --}}
                    <div class="summary-bar">
                        <div class="summary-chip">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 14l9-5-9-5-9 5 9 5z"/></svg>
                            Pendidikan: <strong id="summary-edu">-</strong>
                        </div>
                        <div class="summary-chip">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                            Skill: <strong id="summary-skill">0</strong> dipilih
                        </div>
                        <div class="summary-chip">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/></svg>
                            Spesialisasi: <strong id="summary-spec">0</strong> dipilih
                        </div>
                    </div>

                    {{-- FORM --}}
                    <form method="GET" action="{{ route('recommendation') }}" id="wizard-form">

                        {{-- Step 1: Pendidikan --}}
                        <div data-step="1" class="step-panel">
                            <div class="step-heading">
                                <span class="step-heading-badge">Step 1</span>
                                <h3>Data Pendidikan</h3>
                            </div>
                            <p class="text-[0.95rem] text-[#6B7280] mb-8">Pilih tingkat pendidikan yang paling mewakili status akademis kamu saat ini.</p>

                            <div class="max-w-md">
                                <label for="education_id" class="block text-[0.85rem] uppercase tracking-wider font-extrabold text-[#111827] mb-3">Jenjang Pendidikan</label>
                                <select id="education_id" name="education_id" class="field-select shadow-sm">
                                    <option value="">Pilih pendidikan...</option>
                                    @foreach ($educations as $item)
                                        <option value="{{ $item->education_id }}">{{ $item->education_level }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Step 2: Skill --}}
                        <div data-step="2" class="step-panel hidden">
                            <div class="step-heading">
                                <span class="step-heading-badge">Step 2</span>
                                <h3>Pilih Skill Utama</h3>
                            </div>
                            <p class="text-[0.95rem] text-[#6B7280] mb-8">Buka kategori di bawah dan pilih keahlian teknis maupun non-teknis yang kamu kuasai secara mendalam.</p>
                            
                            <div class="space-y-4">
                                @foreach ($skillGroups as $category => $groupSkills)
                                    <details class="skill-group" {{ $loop->first ? 'open' : '' }}>
                                        <summary>
                                            <span class="flex items-center gap-3">
                                                <span class="w-2.5 h-2.5 rounded-full bg-gradient-to-br from-[#1A2B6B] to-[#4F46E5] shadow-sm"></span>
                                                {{ $category }}
                                            </span>
                                            <span class="flex items-center gap-4 text-xs text-[#6B7280] font-bold">
                                                <span class="bg-white px-3 py-1.5 rounded-lg border border-[#E5E7EB] shadow-sm">{{ count($groupSkills) }} skill</span>
                                                <svg class="skill-group-chevron h-6 w-6 transition-transform text-[#1A2B6B]" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.29a.75.75 0 01.02-1.08z" clip-rule="evenodd"/>
                                                </svg>
                                            </span>
                                        </summary>
                                        <div class="skill-group-inner">
                                            @foreach ($groupSkills as $item)
                                                <button type="button"
                                                    data-value="{{ $item->skill_id }}"
                                                    data-group="skills"
                                                    class="skill-item">
                                                    {{ $item->skill_name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </details>
                                @endforeach
                            </div>
                        </div>

                        {{-- Step 3: Spesialisasi --}}
                        <div data-step="3" class="step-panel hidden">
                            <div class="step-heading">
                                <span class="step-heading-badge">Step 3</span>
                                <h3>Fokus Spesialisasi</h3>
                            </div>
                            <p class="text-[0.95rem] text-[#6B7280] mb-8">Pilih bidang atau spesialisasi spesifik yang paling mendeskripsikan minat karirmu.</p>
                            
                            <div class="spec-grid">
                                @foreach ($specializations as $item)
                                    <button type="button"
                                        data-value="{{ $item->specialization_id }}"
                                        data-group="specializations"
                                        class="specialization-item group">
                                        <span class="font-bold text-[0.95rem]">{{ $item->specialization_name }}</span>
                                        <div class="w-6 h-6 rounded-full border-2 border-[#C7D0EE] flex items-center justify-center transition-all duration-300 group-[.selected-item]:border-[#F5A524] group-[.selected-item]:bg-[#F5A524] group-[.selected-item]:shadow-[0_0_0_4px_rgba(245,165,36,0.2)]">
                                            <svg class="w-3.5 h-3.5 text-white opacity-0 transition-opacity duration-300 group-[.selected-item]:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3.5" d="M5 13l4 4L19 7"/></svg>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- Step 4: Sertifikasi + Review --}}
                        <div data-step="4" class="step-panel hidden">
                            <div class="step-heading">
                                <span class="step-heading-badge">Step 4</span>
                                <h3>Sertifikasi & Konfirmasi</h3>
                            </div>
                            <p class="text-[0.95rem] text-[#6B7280] mb-8">Lengkapi data opsional dan tinjau kembali profil kamu sebelum diproses AI.</p>

                            <div class="max-w-md mb-10">
                                <label for="certification_id" class="block text-[0.85rem] uppercase tracking-wider font-extrabold text-[#111827] mb-3">Sertifikat Profesional</label>
                                <select id="certification_id" name="certification_id" class="field-select shadow-sm">
                                    <option value="">-- Pilih sertifikat (Opsional) --</option>
                                    @foreach ($certifications as $item)
                                        <option value="{{ $item->certification_id }}">{{ $item->certification_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="recap-card">
                                <div class="recap-card-header">
                                    <p>Ringkasan Profil</p>
                                    <h4>Konfirmasi sebelum sistem bekerja</h4>
                                </div>
                                <div class="recap-row">
                                    <span>Tingkat Pendidikan</span>
                                    <span id="recap-edu" class="text-right">-</span>
                                </div>
                                <div class="recap-row bg-[#F8FAFC]">
                                    <span>Total Skill Terpilih</span>
                                    <span id="recap-skill" class="bg-white border border-[#E5E7EB] shadow-sm text-[#1A2B6B] px-4 py-1.5 rounded-lg">0 skill</span>
                                </div>
                                <div class="recap-row">
                                    <span>Spesialisasi Fokus</span>
                                    <span id="recap-spec" class="bg-white border border-[#E5E7EB] shadow-sm text-[#1A2B6B] px-4 py-1.5 rounded-lg">0 spesialisasi</span>
                                </div>
                            </div>
                        </div>

                        <div id="skill-inputs"></div>
                        <div id="specialization-inputs"></div>

                        {{-- Navigation --}}
                        <div class="wizard-nav">
                            <button id="prev-step" type="button"
                                class="btn-outline-blue px-7 py-3.5 rounded-xl text-[0.95rem] disabled:opacity-40 disabled:cursor-not-allowed flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                                Kembali
                            </button>
                            <button id="next-step" type="button"
                                class="btn-primary px-9 py-3.5 rounded-xl text-[0.95rem] flex items-center gap-2">
                                Selanjutnya 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
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
        const prevButton     = document.getElementById('prev-step');
        const nextButton     = document.getElementById('next-step');
        const form           = document.getElementById('wizard-form');
        const skillInputs    = document.getElementById('skill-inputs');
        const specInputs     = document.getElementById('specialization-inputs');
        const eduSelect      = document.getElementById('education_id');

        let currentStep  = 1;
        const maxStep    = 4;
        const selectedSkills = new Set();
        const selectedSpecs  = new Set();

        function updateStep() {
            stepPanels.forEach((p, i) => p.classList.toggle('hidden', i !== currentStep - 1));
            prevButton.disabled = currentStep === 1;

            for (let i = 1; i <= 4; i++) {
                const track = document.getElementById(`track-${i}`);
                track.classList.remove('done', 'current');
                const circle = track.querySelector('.step-circle');
                const checkIcon = circle.querySelector('.check-icon');
                const stepNum = circle.querySelector('.step-num');

                if (i < currentStep) {
                    track.classList.add('done');
                    checkIcon.classList.remove('hidden');
                    stepNum.classList.add('hidden');
                } else if (i === currentStep) {
                    track.classList.add('current');
                    checkIcon.classList.add('hidden');
                    stepNum.classList.remove('hidden');
                } else {
                    checkIcon.classList.add('hidden');
                    stepNum.classList.remove('hidden');
                }
            }

            if (currentStep === maxStep) {
                nextButton.innerHTML = `🚀 Analisis Sekarang`;
                nextButton.classList.add('btn-orange');
                nextButton.classList.remove('btn-primary');
            } else {
                nextButton.innerHTML = `Selanjutnya <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>`;
                nextButton.classList.remove('btn-orange');
                nextButton.classList.add('btn-primary');
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