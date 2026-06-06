<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'SBP CareerSystem') }} — Sistem Rekomendasi Karir</title>

        @fonts

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif

        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            :root {
                --blue: #1A2B6B;
                --blue-dark: #0D1B4B;
                --blue-light: #EEF1FB;
                --blue-mid: #C7D0EE;
                --ink: #111827;
                --body: #374151;
                --muted: #6B7280;
                --border: #E5E7EB;
                --bg: #F5F7FA;
                --white: #FFFFFF;
                --orange: #F5A524;
                --orange-dark: #D98D0F;
            }

            body {
                background: var(--white);
                color: var(--ink);
                font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
                font-size: 15px;
                line-height: 1.6;
                -webkit-font-smoothing: antialiased;
            }

            /* ─── NAV ─── */
            nav.navbar {
                position: sticky;
                top: 0;
                z-index: 100;
                background: rgba(255,255,255,0.95);
                backdrop-filter: blur(12px);
                border-bottom: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 3rem;
                height: 64px;
            }

            .nav-brand {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                text-decoration: none;
            }
            .nav-logo {
                width: 36px;
                height: 36px;
                border-radius: 8px;
                overflow: hidden;
                border: 1px solid var(--border);
                display: flex;
                align-items: center;
                justify-content: center;
                background: var(--blue);
                color: #fff;
                font-weight: 700;
                font-size: 13px;
                flex-shrink: 0;
                cursor: pointer;
                position: relative;
            }
            .nav-logo img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .nav-logo-tooltip {
                position: absolute;
                bottom: -28px;
                left: 50%;
                transform: translateX(-50%);
                background: var(--ink);
                color: white;
                font-size: 10px;
                padding: 3px 7px;
                border-radius: 4px;
                white-space: nowrap;
                opacity: 0;
                pointer-events: none;
                transition: opacity .2s;
            }
            .nav-logo:hover .nav-logo-tooltip { opacity: 1; }

            .nav-brand-text {
                font-size: 0.95rem;
                font-weight: 700;
                color: var(--ink);
                letter-spacing: -0.01em;
            }
            .nav-brand-text span { color: var(--blue); }

            .nav-links-center {
                display: flex;
                align-items: center;
                gap: 0.25rem;
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
            }
            .nav-links-center .nav-link {
                font-size: 0.83rem;
                font-weight: 500;
                color: var(--body);
                text-decoration: none;
                padding: 0.4rem 0.9rem;
                border-radius: 6px;
                transition: all 0.15s;
            }
            .nav-links-center .nav-link:hover,
            .nav-links-center .nav-link.active {
                background: var(--blue-light);
                color: var(--blue);
            }

            .nav-right { display: flex; align-items: center; gap: 0.5rem; }
            .nav-right a {
                font-size: 0.83rem;
                font-weight: 500;
                text-decoration: none;
                padding: 0.45rem 1rem;
                border-radius: 8px;
                transition: all 0.15s;
            }
            .nav-right .btn-nav-ghost { color: var(--body); border: 1px solid var(--border); }
            .nav-right .btn-nav-ghost:hover { background: var(--bg); }
            .nav-right .btn-nav-solid {
                background: var(--orange);
                color: white;
            }
            .nav-right .btn-nav-solid:hover { background: var(--orange-dark); }

            /* ─── HERO ─── */
            .hero-wrapper {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 3rem;
            }
            .hero {
                padding: 5rem 0 3.5rem;
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 4rem;
                align-items: center;
                min-height: calc(100vh - 64px);
            }

            .hero-badge {
                display: inline-flex;
                align-items: center;
                gap: 0.4rem;
                background: var(--blue-light);
                color: var(--blue);
                font-size: 0.72rem;
                font-weight: 600;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                padding: 0.3rem 0.8rem;
                border-radius: 2rem;
                border: 1px solid var(--blue-mid);
                margin-bottom: 1.2rem;
            }

            .hero-title {
                font-size: clamp(2rem, 3.5vw, 3rem);
                font-weight: 800;
                line-height: 1.15;
                letter-spacing: -0.03em;
                color: var(--ink);
                margin-bottom: 1.2rem;
            }
            .hero-title span { color: var(--blue); }

            .hero-desc {
                font-size: 0.93rem;
                color: var(--body);
                line-height: 1.75;
                max-width: 420px;
                margin-bottom: 2rem;
            }

            .hero-cta { display: flex; gap: 0.75rem; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; }

            .btn-primary {
                display: inline-flex; align-items: center; gap: 0.4rem;
                background: var(--orange); color: white;
                font-size: 0.85rem; font-weight: 600;
                padding: 0.7rem 1.5rem; border-radius: 8px;
                text-decoration: none; border: none; cursor: pointer;
                transition: all 0.2s;
            }
            .btn-primary:hover { background: var(--orange-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(245,165,36,0.35); }

            .btn-secondary {
                display: inline-flex; align-items: center; gap: 0.4rem;
                background: white; color: var(--ink);
                font-size: 0.85rem; font-weight: 600;
                padding: 0.7rem 1.5rem; border-radius: 8px;
                text-decoration: none; border: 1px solid var(--border);
                transition: all 0.2s; cursor: pointer;
            }
            .btn-secondary:hover { border-color: var(--blue); color: var(--blue); }

            .hero-social-proof {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                font-size: 0.8rem;
                color: var(--muted);
            }
            .avatars { display: flex; }
            .avatar {
                width: 28px; height: 28px;
                border-radius: 50%;
                border: 2px solid white;
                margin-left: -6px;
                background: var(--blue-mid);
                display: flex; align-items: center; justify-content: center;
                font-size: 0.6rem; font-weight: 700; color: var(--blue);
            }
            .avatar:first-child { margin-left: 0; }

            /* HERO VISUAL */
            .hero-visual { position: relative; }
            .hero-card-main {
                background: white;
                border: 1px solid var(--border);
                border-radius: 16px;
                padding: 1.5rem;
                box-shadow: 0 4px 24px rgba(26,43,107,0.08);
            }
            .card-header {
                display: flex; align-items: center; justify-content: space-between;
                margin-bottom: 1rem;
            }
            .card-title-sm { font-size: 0.85rem; font-weight: 700; color: var(--ink); }
            .badge-live {
                display: flex; align-items: center; gap: 0.3rem;
                background: #ECFDF5; color: #059669;
                font-size: 0.65rem; font-weight: 600;
                padding: 0.2rem 0.6rem; border-radius: 2rem;
            }
            .badge-live::before {
                content: '';
                width: 6px; height: 6px;
                background: #10B981; border-radius: 50%;
                animation: pulse-dot 2s infinite;
            }
            @keyframes pulse-dot { 0%, 100% { opacity: 1; } 50% { opacity: 0.3; } }

            .result-item {
                display: flex; align-items: center; gap: 0.75rem;
                padding: 0.65rem 0; border-bottom: 1px solid var(--bg);
            }
            .result-item:last-child { border-bottom: none; }
            .result-icon {
                width: 32px; height: 32px; border-radius: 8px;
                background: var(--blue-light);
                display: flex; align-items: center; justify-content: center;
                font-size: 0.9rem; flex-shrink: 0;
            }
            .result-name { font-size: 0.8rem; font-weight: 600; color: var(--ink); }
            .result-sub { font-size: 0.7rem; color: var(--muted); }
            .result-bar-wrap { flex: 1; }
            .result-bar-bg { height: 5px; background: var(--bg); border-radius: 3px; overflow: hidden; }
            .result-bar-fill {
                height: 100%; background: var(--blue); border-radius: 3px;
                width: 0; transition: width 1.2s ease;
            }
            .result-pct { font-size: 0.75rem; font-weight: 700; color: var(--blue); white-space: nowrap; }

            .hero-card-float {
                position: absolute; bottom: -1.5rem; left: -1.5rem;
                background: white; border: 1px solid var(--border);
                border-radius: 12px; padding: 0.9rem 1.1rem;
                box-shadow: 0 8px 24px rgba(26,43,107,0.1);
                display: flex; align-items: center; gap: 0.75rem; min-width: 200px;
            }
            .float-icon {
                width: 36px; height: 36px; background: var(--blue);
                border-radius: 8px; display: flex; align-items: center; justify-content: center;
                font-size: 1rem; flex-shrink: 0;
            }
            .float-label { font-size: 0.7rem; color: var(--muted); }
            .float-value { font-size: 0.9rem; font-weight: 700; color: var(--ink); }

            /* ─── COUNTER ROW ─── */
            .counter-row {
                display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;
                max-width: 1200px; margin: 0 auto; padding: 2rem 3rem 0;
            }
            .counter-card {
                background: var(--bg); border: 1px solid var(--border);
                border-radius: 12px; padding: 1.25rem; text-align: center;
            }
            .counter-num { font-size: 1.8rem; font-weight: 800; color: var(--blue); }
            .counter-label { font-size: 0.75rem; color: var(--muted); margin-top: 4px; }

            /* ─── SECTION BASE ─── */
            .section {
                padding: 5rem 3rem;
                max-width: 1200px;
                margin: 0 auto;
            }
            .section-center { text-align: center; }
            .section-label {
                font-size: 0.75rem; font-weight: 600; letter-spacing: 0.08em;
                text-transform: uppercase; color: var(--blue); margin-bottom: 0.6rem;
            }
            .section-heading {
                font-size: clamp(1.6rem, 2.5vw, 2.2rem); font-weight: 800;
                letter-spacing: -0.02em; color: var(--ink); margin-bottom: 0.75rem;
            }
            .section-sub {
                font-size: 0.92rem; color: var(--muted); max-width: 520px; margin: 0 auto 3rem;
            }

            /* ─── CAREER EXPLORER ─── */
            .careers-layout {
                display: grid; grid-template-columns: 220px 1fr;
                border: 1px solid var(--border); border-radius: 16px;
                overflow: hidden; background: white;
                box-shadow: 0 2px 16px rgba(26,43,107,0.06);
            }
            .careers-sidebar { background: var(--bg); padding: 8px 0; border-right: 1px solid var(--border); }
            .career-tab {
                display: flex; align-items: center; justify-content: space-between;
                padding: 0.7rem 1.2rem; font-size: 0.82rem; font-weight: 500;
                color: var(--body); cursor: pointer; transition: all 0.15s;
                border-left: 2px solid transparent;
            }
            .career-tab:hover { background: var(--blue-light); color: var(--blue); }
            .career-tab.active {
                background: var(--blue-light); color: var(--blue);
                font-weight: 600; border-left-color: var(--blue);
            }
            .careers-detail { padding: 2rem; min-height: 280px; }
            .detail-header {
                display: flex; align-items: flex-start;
                justify-content: space-between; margin-bottom: 1.5rem; gap: 1rem;
            }
            .detail-title { font-size: 1.3rem; font-weight: 700; color: var(--ink); margin-bottom: 0.4rem; }
            .detail-desc { font-size: 0.82rem; color: var(--muted); max-width: 400px; line-height: 1.6; }
            .match-badge {
                background: var(--blue); color: white;
                border-radius: 12px; padding: 0.6rem 1rem; text-align: center; flex-shrink: 0;
            }
            .match-pct { font-size: 1.5rem; font-weight: 800; }
            .match-label { font-size: 0.65rem; font-weight: 500; opacity: 0.8; }
            .skills-section { margin-bottom: 1.5rem; }
            .skills-heading {
                font-size: 0.75rem; font-weight: 600; color: var(--muted);
                letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 0.6rem;
            }
            .skill-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
            .skill-chip {
                font-size: 0.72rem; font-weight: 500; padding: 0.3rem 0.7rem;
                border-radius: 6px; background: var(--blue-light); color: var(--blue);
                border: 1px solid var(--blue-mid);
            }
            .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
            .detail-box {
                background: var(--bg); border-radius: 10px;
                padding: 1rem; border: 1px solid var(--border);
            }
            .detail-box-title {
                font-size: 0.72rem; font-weight: 600; color: var(--muted);
                letter-spacing: 0.05em; text-transform: uppercase; margin-bottom: 0.75rem;
                display: flex; align-items: center; gap: 0.4rem;
            }
            .grade-row {
                display: flex; justify-content: space-between;
                font-size: 0.78rem; padding: 0.25rem 0; border-bottom: 1px solid var(--border);
            }
            .grade-row:last-child { border-bottom: none; }
            .grade-row span:first-child { color: var(--body); }
            .grade-row span:last-child { font-weight: 600; color: var(--blue); }
            .mini-bars { display: flex; align-items: flex-end; gap: 4px; height: 50px; }
            .mini-bar { flex: 1; background: var(--blue-mid); border-radius: 3px 3px 0 0; }
            .mini-bar.active { background: var(--blue); }

            /* ─── HOW IT WORKS ─── */
            .how-bg { background: var(--bg); border-top: 1px solid var(--border); border-bottom: 1px solid var(--border); }
            .steps-row { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; }
            .step-item { text-align: center; }
            .step-icon-wrap {
                width: 52px; height: 52px; background: white;
                border: 1px solid var(--border); border-radius: 12px;
                display: flex; align-items: center; justify-content: center; font-size: 1.3rem;
                margin: 0 auto 0.75rem; box-shadow: 0 2px 8px rgba(26,43,107,0.06);
            }
            .step-num-badge {
                width: 20px; height: 20px; background: var(--blue); color: white;
                border-radius: 50%; font-size: 0.65rem; font-weight: 700;
                display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem;
            }
            .step-title-sm { font-size: 0.82rem; font-weight: 700; color: var(--ink); margin-bottom: 0.3rem; }
            .step-desc-sm { font-size: 0.75rem; color: var(--muted); line-height: 1.55; }

            /* ─── FEATURES ─── */
            .features-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
            .feature-card-mock {
                background: var(--blue-dark);
                border: 1px solid rgba(255,255,255,0.08);
                border-radius: 16px; padding: 1.5rem;
                box-shadow: 0 4px 20px rgba(13,27,75,0.25);
            }
            .mock-title { font-size: 0.85rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; }
            .rec-bar-item { margin-bottom: 0.75rem; }
            .rec-bar-label { display: flex; justify-content: space-between; font-size: 0.78rem; color: rgba(255,255,255,0.75); margin-bottom: 0.3rem; }
            .rec-bar-label span:last-child { font-weight: 600; color: var(--orange); }
            .rec-bar-track { height: 6px; background: rgba(255,255,255,0.12); border-radius: 3px; overflow: hidden; }
            .rec-bar-fill { height: 100%; background: var(--orange); border-radius: 3px; width: 0; transition: width 1s ease; }
            .feature-badge {
                display: inline-flex; align-items: center; gap: 0.4rem;
                background: var(--blue-light); color: var(--blue);
                font-size: 0.72rem; font-weight: 600; padding: 0.25rem 0.7rem;
                border-radius: 2rem; border: 1px solid var(--blue-mid); margin-bottom: 1rem;
            }
            .features-title { font-size: clamp(1.5rem, 2.5vw, 2rem); font-weight: 800; letter-spacing: -0.02em; color: var(--ink); margin-bottom: 1rem; line-height: 1.2; }
            .features-desc { font-size: 0.9rem; color: var(--body); line-height: 1.75; margin-bottom: 1.5rem; }
            .feature-check-list { display: flex; flex-direction: column; gap: 0.6rem; }
            .feature-check { display: flex; align-items: flex-start; gap: 0.6rem; font-size: 0.83rem; color: var(--body); }
            .check-icon {
                width: 18px; height: 18px; background: var(--blue); border-radius: 50%;
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0; margin-top: 1px; color: white; font-size: 0.6rem; font-weight: 700;
            }

            /* ─── PILLARS ─── */
            .pillars-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; }
            .pillar-card {
                background: white; border: 1px solid var(--border);
                border-radius: 12px; padding: 1.5rem; transition: all 0.2s; cursor: default;
            }
            .pillar-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(26,43,107,0.09); }
            .pillar-icon { width: 40px; height: 40px; background: var(--blue-light); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: 1rem; }
            .pillar-title { font-size: 0.88rem; font-weight: 700; color: var(--ink); margin-bottom: 0.4rem; }
            .pillar-desc { font-size: 0.78rem; color: var(--muted); line-height: 1.6; }

            /* ─── FAQ ─── */
            .faq-bg { background: var(--bg); border-top: 1px solid var(--border); }
            .faq-list { max-width: 680px; margin: 0 auto; }
            .faq-item { background: white; border: 1px solid var(--border); border-radius: 10px; margin-bottom: 0.75rem; overflow: hidden; }
            .faq-q { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; font-size: 0.85rem; font-weight: 600; color: var(--ink); cursor: pointer; user-select: none; }
            .faq-q i { color: var(--muted); transition: transform 0.2s; font-size: 16px; }
            .faq-item.open .faq-q i { transform: rotate(180deg); }
            .faq-a { padding: 0 1.25rem; font-size: 0.82rem; color: var(--body); line-height: 1.7; max-height: 0; overflow: hidden; transition: max-height .3s ease, padding .3s; }
            .faq-item.open .faq-a { max-height: 200px; padding: 0 1.25rem 1rem; }

            /* ─── FOOTER ─── */
            footer.site-footer {
                background: var(--blue-dark); padding: 2rem 3rem;
                display: flex; align-items: center; justify-content: space-between;
            }
            footer.site-footer p { font-size: 0.75rem; color: rgba(255,255,255,0.4); }
            .footer-links { display: flex; gap: 1.5rem; }
            .footer-links a { font-size: 0.75rem; color: rgba(255,255,255,0.4); text-decoration: none; transition: color .15s; }
            .footer-links a:hover { color: rgba(255,255,255,0.8); }

            /* ─── RESPONSIVE ─── */
            @media (max-width: 1024px) {
                .hero { grid-template-columns: 1fr; min-height: auto; padding-top: 4rem; }
                .hero-card-float { display: none; }
                .hero-visual { display: none; }
                .careers-layout { grid-template-columns: 1fr; }
                .careers-sidebar { display: flex; overflow-x: auto; border-right: none; border-bottom: 1px solid var(--border); padding: 0; }
                .career-tab { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
                .career-tab.active { border-left: none; border-bottom-color: var(--blue); }
                .detail-header { flex-direction: column; }
                .steps-row { grid-template-columns: repeat(3, 1fr); }
                .features-grid { grid-template-columns: 1fr; }
                .pillars-grid { grid-template-columns: 1fr 1fr; }
                .nav-links-center { display: none; }
                .counter-row { grid-template-columns: 1fr; }
            }
            @media (max-width: 640px) {
                nav.navbar { padding: 0 1.25rem; }
                .section { padding: 3.5rem 1.25rem; }
                .hero-wrapper { padding: 0 1.25rem; }
                .counter-row { padding: 1.5rem 1.25rem 0; }
                .steps-row { grid-template-columns: 1fr 1fr; }
                .pillars-grid { grid-template-columns: 1fr 1fr; }
                .detail-grid { grid-template-columns: 1fr; }
                footer.site-footer { flex-direction: column; gap: 1rem; text-align: center; padding: 1.5rem; }
                .footer-links { flex-wrap: wrap; justify-content: center; }
            }
        </style>
    </head>
    <body>

        <!-- NAV -->
        <nav class="navbar">
            <a href="/" class="nav-brand">
                <div class="nav-logo" id="navLogo" title="Klik untuk ganti logo">
                    JK
                    <span class="nav-logo-tooltip">Ganti logo</span>
                </div>
                <div class="nav-brand-text">SI<span>REKA</span></div>
            </a>
            <div class="nav-links-center">
                <a href="#hero" class="nav-link active" data-section="hero">Beranda</a>
                <a href="#cara-kerja" class="nav-link" data-section="cara-kerja">Cara Kerja</a>
                <a href="#fitur" class="nav-link" data-section="fitur">Fitur</a>
                <a href="#faq" class="nav-link" data-section="faq">FAQ</a>
            </div>
            <div class="nav-right">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="btn-nav-ghost">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-nav-solid">Daftar</a>
                    @endif
                @endif
            </div>
        </nav>

        <!-- HERO -->
        <div class="hero-wrapper" id="hero">
            <section class="hero">
                <div>
                    <div class="hero-badge">✦  Sistem Rekomendasi Karir Berbasis Data</div>
                    <h1 class="hero-title">
                        Pahami Potensimu,<br>
                        <span>Temukan Arah Karirmu</span>
                    </h1>
                    <p class="hero-desc">
                        SIREKA adalah Sistem Rekomendasi Karir IT yang dipersonalisasi berdasarkan latar belakang pendidikan, skill, minat mendalam, dan pengalaman kamu.
                    </p>
                    <div class="hero-cta">
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">
                                Daftar Sekarang
                                {{-- <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M2 7h10M7.5 3.5l4 3.5-4 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg> --}}
                            </a>
                        @endif
                        <a href="#cara-kerja" class="btn-secondary">Lihat Cara Kerja</a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="hero-card-main">
                        <div class="card-header">
                            <div class="card-title-sm">Analisis Terkini</div>
                            <div class="badge-live">Live Updates</div>
                        </div>
                        <div class="result-item">
                            <div class="result-icon">💻</div>
                            <div style="min-width:110px">
                                <div class="result-name">Software Engineer</div>
                                <div class="result-sub">Engineering</div>
                            </div>
                            <div class="result-bar-wrap">
                                <div class="result-bar-bg">
                                    <div class="result-bar-fill" data-target="94"></div>
                                </div>
                            </div>
                            <div class="result-pct">94%</div>
                        </div>
                        <div class="result-item">
                            <div class="result-icon">📊</div>
                            <div style="min-width:110px">
                                <div class="result-name">Data Analyst</div>
                                <div class="result-sub">Analytics</div>
                            </div>
                            <div class="result-bar-wrap">
                                <div class="result-bar-bg">
                                    <div class="result-bar-fill" data-target="82"></div>
                                </div>
                            </div>
                            <div class="result-pct">82%</div>
                        </div>
                        <div class="result-item">
                            <div class="result-icon">🤖</div>
                            <div style="min-width:110px">
                                <div class="result-name">ML Engineer</div>
                                <div class="result-sub">AI / ML</div>
                            </div>
                            <div class="result-bar-wrap">
                                <div class="result-bar-bg">
                                    <div class="result-bar-fill" data-target="75"></div>
                                </div>
                            </div>
                            <div class="result-pct">75%</div>
                        </div>
                        <div class="result-item">
                            <div class="result-icon">🎯</div>
                            <div style="min-width:110px">
                                <div class="result-name">Business Analyst</div>
                                <div class="result-sub">Strategy</div>
                            </div>
                            <div class="result-bar-wrap">
                                <div class="result-bar-bg">
                                    <div class="result-bar-fill" data-target="68"></div>
                                </div>
                            </div>
                            <div class="result-pct">68%</div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- <!-- COUNTER ROW -->
        <div class="counter-row">
            <div class="counter-card">
                <div class="counter-num" data-count="1247" data-suffix="+">0+</div>
                <div class="counter-label">Mahasiswa Bergabung</div>
            </div>
            <div class="counter-card">
                <div class="counter-num" data-count="7" data-suffix=" Jalur">0 Jalur</div>
                <div class="counter-label">Karir IT Tersedia</div>
            </div>
            <div class="counter-card">
                <div class="counter-num" data-count="94" data-suffix="%">0%</div>
                <div class="counter-label">Tingkat Kepuasan</div>
            </div>
        </div> --}}

        <!-- CAREER EXPLORER -->
        <div style="border-top:1px solid var(--border);border-bottom:1px solid var(--border);margin-top:3rem;">
            <div class="section section-center" style="padding-bottom:0">
                <div class="section-label">Eksplorasi Karir</div>
                <h2 class="section-heading">Eksplorasi Spektrum Karir IT</h2>
                <p class="section-sub">Temukan detail setiap peran, keahlian yang dibutuhkan, dan bagaimana performamu mencocokkan standar industri.</p>
            </div>
            <div class="section" style="padding-top:1.5rem;">
                <div class="careers-layout">
                    <div class="careers-sidebar" id="careerSidebar"></div>
                    <div class="careers-detail" id="careerDetail"></div>
                </div>
            </div>
        </div>

        <!-- HOW IT WORKS -->
        <div class="how-bg" id="cara-kerja">
            <div class="section section-center">
                <div class="section-label">Cara Kerja</div>
                <h2 class="section-heading">Bagaimana SIREKA Bekerja?</h2>
                <p class="section-sub">Proses analisis ilmiah untuk menentukan masa depan karir kamu.</p>
                <div class="steps-row">
                    <div class="step-item">
                        <div class="step-icon-wrap">🎓</div>
                        <div class="step-num-badge">1</div>
                        <div class="step-title-sm">Input Profil</div>
                        <p class="step-desc-sm">Lengkapi data diri dan pengalaman dasar.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-icon-wrap">📚</div>
                        <div class="step-num-badge">2</div>
                        <div class="step-title-sm">Academic Analysis</div>
                        <p class="step-desc-sm">Evaluasi nilai mata kuliah kunci.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-icon-wrap">⚡</div>
                        <div class="step-num-badge">3</div>
                        <div class="step-title-sm">Skill & Sertifikat</div>
                        <p class="step-desc-sm">Tandai skill dan sertifikasi yang kamu miliki.</p>
                    </div>
                    <div class="step-item">
                        <div class="step-icon-wrap">⚖️</div>
                        <div class="step-num-badge">4</div>
                        <div class="step-title-sm">CBF & SAW</div>
                        <p class="step-desc-sm">Cocokkan profil kamu dengan karir (CBF), lalu hitung ranking kecocokan (SAW).</p>
                    </div>
                    <div class="step-item">
                        <div class="step-icon-wrap">🏆</div>
                        <div class="step-num-badge">5</div>
                        <div class="step-title-sm">Recommendation</div>
                        <p class="step-desc-sm">Dapatkan ranking karir paling sesuai.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FEATURES -->
        <div id="fitur">
            <div class="section">
                <div class="features-grid">
                    <div class="feature-card-mock">
                        <div class="mock-title">🖥 Dashboard Rekomendasi</div>
                        <div class="rec-bar-item">
                            <div class="rec-bar-label"><span>Business Analyst</span><span>93% Match</span></div>
                            <div class="rec-bar-track"><div class="rec-bar-fill" data-target="93"></div></div>
                        </div>
                        <div class="rec-bar-item">
                            <div class="rec-bar-label"><span>Data Analyst</span><span>78% Match</span></div>
                            <div class="rec-bar-track"><div class="rec-bar-fill" data-target="78"></div></div>
                        </div>
                        <div class="rec-bar-item">
                            <div class="rec-bar-label"><span>Software Engineer</span><span>65% Match</span></div>
                            <div class="rec-bar-track"><div class="rec-bar-fill" data-target="65"></div></div>
                        </div>
                        <div style="margin-top:1.5rem;background:var(--bg);border-radius:10px;padding:1rem;border:1px solid var(--border);">
                            <div style="font-size:0.72rem;color:var(--muted);margin-bottom:0.5rem;">Radar Kompetensi</div>
                            <svg viewBox="0 0 120 100" width="100%" style="max-height:100px;">
                                <polygon points="60,10 100,35 85,80 35,80 20,35" fill="none" stroke="#E2E8F0" stroke-width="1"/>
                                <polygon points="60,25 82,42 74,68 46,68 38,42" fill="rgba(37,99,235,0.15)" stroke="#2563EB" stroke-width="1.5"/>
                                <circle cx="60" cy="25" r="3" fill="#2563EB"/>
                                <circle cx="82" cy="42" r="3" fill="#2563EB"/>
                                <circle cx="74" cy="68" r="3" fill="#2563EB"/>
                                <circle cx="46" cy="68" r="3" fill="#2563EB"/>
                                <circle cx="38" cy="42" r="3" fill="#2563EB"/>
                            </svg>
                        </div>
                    </div>
                    <div class="features-text">
                        <div class="feature-badge">✦ Visualisasi Komprehensif</div>
                        <h2 class="features-title">Visualisasi Potensi yang Komprehensif</h2>
                        <p class="features-desc">Dapatkan gambaran jelas tentang di mana letak keunggulanmu melalui grafik radar minat, progress bar keahlian, dan analisis persentase kecocokan industri yang mendalam.</p>
                        <div class="feature-check-list">
                            <div class="feature-check">
                                <div class="check-icon">✓</div>
                                <span><strong>Matriks Kompetensi</strong> — Membandingkan nilai akademik dengan standar industri.</span>
                            </div>
                            <div class="feature-check">
                                <div class="check-icon">✓</div>
                                <span><strong>Kecocokan Karakter</strong> — Sejauh mana kepribadianmu cocok dengan budaya kerja di IT.</span>
                            </div>
                            <div class="feature-check">
                                <div class="check-icon">✓</div>
                                <span><strong>CBF + SAW</strong> — Pencocokan profil berbasis Content-Based Filtering dan perankingan Simple Additive Weighting.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PILLARS -->
        <div style="background:var(--bg);border-top:1px solid var(--border);">
            <div class="section section-center">
                <div class="section-label">Keunggulan</div>
                <h2 class="section-heading" style="margin-bottom:2.5rem;">Mengapa Memilih SIREKA?</h2>
                <div class="pillars-grid">
                    <div class="pillar-card">
                        <div class="pillar-icon">🎯</div>
                        <div class="pillar-title">Accurate</div>
                        <p class="pillar-desc">Hasil didasarkan pada riset akademis dan standar industri teknologi global.</p>
                    </div>
                    <div class="pillar-card">
                        <div class="pillar-icon">👤</div>
                        <div class="pillar-title">Personalized</div>
                        <p class="pillar-desc">Saran yang disesuaikan dengan profil unik dan pengalaman kamu.</p>
                    </div>
                    <div class="pillar-card">
                        <div class="pillar-icon">⚡</div>
                        <div class="pillar-title">Fast</div>
                        <p class="pillar-desc">Dapatkan hasil analisis karir yang komprehensif dalam waktu kurang dari 5 menit.</p>
                    </div>
                    <div class="pillar-card">
                        <div class="pillar-icon">🚀</div>
                        <div class="pillar-title">Career Focused</div>
                        <p class="pillar-desc">Fokus pada pertumbuhan karir jangka panjang di ekosistem digital Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ -->
        <div class="faq-bg" id="faq">
            <div class="section section-center">
                <div class="section-label">FAQ</div>
                <h2 class="section-heading">Pertanyaan Umum</h2>
                <p class="section-sub" style="margin-bottom:2rem;">Jawaban atas pertanyaan yang sering ditanyakan.</p>
                <div class="faq-list">
                    <div class="faq-item open">
                        <div class="faq-q">
                            Bagaimana SIREKA menentukan tingkat kesesuaian?
                            <i class="ti ti-chevron-down"></i>
                        </div>
                        <div class="faq-a">SIREKA menggunakan Content-Based Filtering (CBF) untuk mencocokkan profil kamu—pendidikan, skill, spesialisasi, dan sertifikat—dengan profil setiap karir. Skor kecocokan dihitung dengan Simple Additive Weighting (SAW), lalu dinormalisasi menjadi persentase 0–100% agar ranking karir lebih mudah dipahami.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-q">
                            Apakah platform ini berbayar?
                            <i class="ti ti-chevron-down"></i>
                        </div>
                        <div class="faq-a">Tidak. SIREKA sepenuhnya gratis untuk digunakan oleh seluruh mahasiswa JTI.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-q">
                            Dapatkah saya mengupdate data performa saya?
                            <i class="ti ti-chevron-down"></i>
                        </div>
                        <div class="faq-a">Ya, kamu dapat memperbarui profil, skill, dan sertifikasi kapan saja melalui dashboard untuk mendapatkan rekomendasi yang lebih akurat.</div>
                    </div>
                    <div class="faq-item">
                        <div class="faq-q">
                            Berapa lama proses analisis berlangsung?
                            <i class="ti ti-chevron-down"></i>
                        </div>
                        <div class="faq-a">Proses pengisian profil memakan waktu sekitar 5–10 menit. Setelah selesai, hasil rekomendasi langsung ditampilkan secara real-time di dashboard kamu.</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="site-footer">
            <p>© {{ date('Y') }} SIREKA</p>
            <div class="footer-links">
                <a href="#">Kebijakan Privasi</a>
                <a href="#">Syarat & Ketentuan</a>
                <a href="#">Bantuan</a>
                <a href="#">Kontak Kami</a>
            </div>
        </footer>

        <script>
        /* ── DATA KARIR ── */
        const careers = [
            {
                name: 'Software Engineer', icon: '💻', match: 85,
                desc: 'Merancang, mengembangkan, dan memelihara sistem perangkat lunak kompleks menggunakan berbagai bahasa pemrograman dan arsitektur modern.',
                skills: ['Java', 'React.js', 'SQL', 'System Design', 'Git'],
                grades: [['Struktur Data', 'A'], ['Algoritma', 'A-'], ['Basis Data', 'B+']],
                bars: [40, 80, 100, 60, 90, 50, 75]
            },
            {
                name: 'Data Analyst', icon: '📊', match: 78,
                desc: 'Menganalisis data besar untuk menghasilkan insight bisnis yang actionable melalui visualisasi dan laporan strategis.',
                skills: ['Python', 'SQL', 'Tableau', 'Statistics', 'Excel'],
                grades: [['Statistika', 'A'], ['Basis Data', 'A-'], ['Matematika', 'B+']],
                bars: [70, 90, 85, 60, 75, 55, 80]
            },
            {
                name: 'Data Scientist', icon: '🔬', match: 72,
                desc: 'Membangun model prediktif dan algoritma machine learning untuk memecahkan masalah bisnis yang kompleks.',
                skills: ['Python', 'R', 'TensorFlow', 'Statistics', 'ML'],
                grades: [['Statistika', 'A+'], ['AI/ML', 'A'], ['Kalkulus', 'B+']],
                bars: [60, 85, 100, 70, 95, 50, 65]
            },
            {
                name: 'UI/UX Designer', icon: '🎨', match: 68,
                desc: 'Merancang antarmuka pengguna yang intuitif dan pengalaman digital yang menyenangkan berdasarkan riset pengguna mendalam.',
                skills: ['Figma', 'Prototyping', 'User Research', 'CSS', 'Design System'],
                grades: [['Interaksi Manusia-Komputer', 'A'], ['Desain Web', 'A-'], ['Psikologi UX', 'B+']],
                bars: [80, 60, 75, 90, 85, 70, 55]
            },
            {
                name: 'ML Engineer', icon: '🤖', match: 75,
                desc: 'Mengimplementasikan, men-deploy, dan memelihara model machine learning di lingkungan produksi skala besar.',
                skills: ['Python', 'PyTorch', 'Docker', 'Kubernetes', 'MLOps'],
                grades: [['AI/ML', 'A'], ['Pemrograman', 'A-'], ['Jaringan', 'B+']],
                bars: [50, 90, 100, 65, 80, 60, 75]
            },
            {
                name: 'Cyber Security', icon: '🛡️', match: 70,
                desc: 'Melindungi sistem dan jaringan dari ancaman siber melalui analisis keamanan, penetration testing, dan incident response.',
                skills: ['Network Security', 'Python', 'Kali Linux', 'Forensics', 'SIEM'],
                grades: [['Keamanan Informasi', 'A'], ['Jaringan', 'A-'], ['Pemrograman', 'B+']],
                bars: [65, 80, 90, 55, 70, 85, 60]
            },
            {
                name: 'Cloud Engineer', icon: '☁️', match: 65,
                desc: 'Merancang dan mengelola infrastruktur cloud yang skalabel, aman, dan hemat biaya untuk mendukung aplikasi modern.',
                skills: ['AWS/GCP', 'Terraform', 'Docker', 'Kubernetes', 'CI/CD'],
                grades: [['Sistem Operasi', 'A'], ['Jaringan', 'A'], ['Pemrograman', 'B+']],
                bars: [55, 70, 85, 100, 75, 60, 80]
            },
        ];

        let activeCareer = 0;

        function renderCareer() {
            const sidebar = document.getElementById('careerSidebar');
            sidebar.innerHTML = careers.map((c, i) => `
                <div class="career-tab${i === activeCareer ? ' active' : ''}" onclick="selectCareer(${i})">
                    ${c.icon} ${c.name}
                    <i class="ti ti-chevron-right" style="opacity:.4;font-size:14px"></i>
                </div>
            `).join('');

            const c = careers[activeCareer];
            document.getElementById('careerDetail').innerHTML = `
                <div class="detail-header">
                    <div>
                        <div class="detail-title">${c.icon} ${c.name}</div>
                        <div class="detail-desc">${c.desc}</div>
                    </div>
                    <div class="match-badge">
                        <div class="match-pct">${c.match}%</div>
                        <div class="match-label">Kesesuaian</div>
                    </div>
                </div>
                <div class="skills-section">
                    <div class="skills-heading">Keahlian Utama</div>
                    <div class="skill-chips">
                        ${c.skills.map(s => `<span class="skill-chip">${s}</span>`).join('')}
                    </div>
                </div>
                <div class="detail-grid">
                    <div class="detail-box">
                        <div class="detail-box-title">🎓 Analisis Akademik</div>
                        ${c.grades.map(([name, grade]) => `
                            <div class="grade-row"><span>${name}</span><span>${grade}</span></div>
                        `).join('')}
                    </div>
                    <div class="detail-box">
                        <div class="detail-box-title">📈 Analisis Minat</div>
                        <div class="mini-bars">
                            ${c.bars.map((h, i) => `<div class="mini-bar${[1,2,4,6].includes(i) ? ' active' : ''}" style="height:${h}%"></div>`).join('')}
                        </div>
                    </div>
                </div>
            `;
        }

        function selectCareer(index) {
            activeCareer = index;
            renderCareer();
        }

        renderCareer();

        /* ── FAQ ACCORDION ── */
        document.querySelectorAll('.faq-q').forEach(q => {
            q.addEventListener('click', () => {
                const item = q.parentElement;
                const wasOpen = item.classList.contains('open');
                document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
                if (!wasOpen) item.classList.add('open');
            });
        });

        /* ── ANIMATED BARS ── */
        function animateBars(scope) {
            const el = scope || document;
            el.querySelectorAll('.result-bar-fill[data-target], .rec-bar-fill[data-target]').forEach(bar => {
                const target = bar.getAttribute('data-target');
                setTimeout(() => { bar.style.width = target + '%'; }, 150);
            });
        }

        const barObs = new IntersectionObserver(entries => {
            entries.forEach(e => { if (e.isIntersecting) animateBars(); });
        }, { threshold: 0.1 });

        document.querySelectorAll('.hero-card-main, .feature-card-mock').forEach(el => barObs.observe(el));

        /* ── COUNTER ANIMATION ── */
        function animateCounter(el) {
            const target = parseInt(el.dataset.count);
            const suffix = el.dataset.suffix || '';
            let current = 0;
            const step = Math.ceil(target / 60);
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                const display = current >= 1000 ? (current / 1000).toFixed(1) + 'K' : current;
                el.textContent = display + suffix;
                if (current >= target) clearInterval(timer);
            }, 20);
        }

        const counterObs = new IntersectionObserver(entries => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    document.querySelectorAll('[data-count]').forEach(animateCounter);
                    counterObs.disconnect();
                }
            });
        }, { threshold: 0.2 });

        document.querySelectorAll('.counter-card').forEach(c => counterObs.observe(c));

        /* ── LOGO GANTI GAMBAR ── */
        // Untuk production: ganti logika ini dengan upload ke server via AJAX/FormData
        // sehingga logo tersimpan permanen. Saat ini hanya preview sementara di client.
        const navLogo = document.getElementById('navLogo');
        navLogo.addEventListener('click', () => {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = e => {
                const file = e.target.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = ev => {
                    navLogo.innerHTML = `<img src="${ev.target.result}" alt="Logo">`;
                };
                reader.readAsDataURL(file);
            };
            input.click();
        });

        /* ── SMOOTH SCROLL + ACTIVE NAV ── */
        const navLinks = document.querySelectorAll('.nav-link[data-section]');
        const sections = ['hero', 'cara-kerja', 'fitur', 'faq'];

        // Smooth scroll saat link diklik
        navLinks.forEach(link => {
            link.addEventListener('click', e => {
                e.preventDefault();
                const targetId = link.getAttribute('data-section');
                const targetEl = document.getElementById(targetId);
                if (targetEl) {
                    const offset = 70; // tinggi navbar
                    const top = targetEl.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });

        // Update active link berdasarkan section yang terlihat di viewport
        function setActiveNav(sectionId) {
            navLinks.forEach(link => {
                link.classList.toggle('active', link.getAttribute('data-section') === sectionId);
            });
        }

        const sectionObs = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    setActiveNav(entry.target.id);
                }
            });
        }, {
            rootMargin: '-50% 0px -50% 0px', // trigger ketika section ada di tengah viewport
            threshold: 0
        });

        sections.forEach(id => {
            const el = document.getElementById(id);
            if (el) sectionObs.observe(el);
        });

        // Juga tangani anchor biasa di halaman (misal tombol "Lihat Cara Kerja")
        document.querySelectorAll('a[href^="#"]:not(.nav-link)').forEach(a => {
            a.addEventListener('click', e => {
                const href = a.getAttribute('href');
                if (href === '#') return;
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    const offset = 70;
                    const top = target.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });
        </script>

    </body>
</html>