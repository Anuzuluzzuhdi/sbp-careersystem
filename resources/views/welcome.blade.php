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
            --blue: #1A2B6B; --blue-dark: #0D1B4B; --blue-light: #EEF1FB;
            --blue-mid: #C7D0EE; --ink: #111827; --body: #374151;
            --muted: #6B7280; --border: #E5E7EB; --bg: #F5F7FA;
            --white: #FFFFFF; --orange: #F5A524; --orange-dark: #D98D0F;
        }
        body {
            background: var(--white); color: var(--ink);
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            font-size: 15px; line-height: 1.6; -webkit-font-smoothing: antialiased;
        }

        /* ─── NAV ─── */
        nav.navbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,0.88);
            backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(229,231,235,0.7);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 3rem; height: 64px;
        }
        .nav-brand { display: flex; align-items: center; gap: 0.5rem; text-decoration: none; }
        .nav-logo { width: 38px; height: 25px; border-radius: 0; overflow: hidden; flex-shrink: 0; }
        .nav-logo img { width: 100%; height: 100%; object-fit: cover; display: block; }
        .nav-brand-text { font-size: 0.95rem; font-weight: 700; color: var(--ink); letter-spacing: -0.01em; }
        .nav-brand-text span { color: var(--blue); }
        .nav-links-center {
            display: flex; align-items: center; gap: 0.25rem;
            position: absolute; left: 50%; transform: translateX(-50%);
        }
        .nav-links-center .nav-link {
            font-size: 0.83rem; font-weight: 500; color: var(--body);
            text-decoration: none; padding: 0.4rem 0.9rem; border-radius: 6px; transition: all 0.15s;
        }
        .nav-links-center .nav-link:hover, .nav-links-center .nav-link.active {
            background: var(--blue-light); color: var(--blue);
        }
        .nav-right { display: flex; align-items: center; gap: 0.5rem; }
        .nav-right a {
            font-size: 0.83rem; font-weight: 500; text-decoration: none;
            padding: 0.45rem 1rem; border-radius: 8px; transition: all 0.15s;
        }
        .btn-nav-ghost { color: var(--body); border: 1px solid var(--border); }
        .btn-nav-ghost:hover { background: var(--bg); }
        .btn-nav-solid { background: var(--orange); color: white !important; }
        .btn-nav-solid:hover { background: var(--orange-dark); }

        /* ─── HERO SECTION ─── */
        .hero-section-wrap {
            position: relative; overflow: hidden;
            background: var(--white);
        }
        /* Glass + gradient background for hero */
        .hero-section-wrap::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 70% 60% at 75% 20%, rgba(26,43,107,0.07) 0%, transparent 65%),
                radial-gradient(ellipse 50% 50% at 20% 80%, rgba(245,165,36,0.06) 0%, transparent 65%),
                radial-gradient(ellipse 40% 40% at 60% 90%, rgba(26,43,107,0.04) 0%, transparent 60%);
            pointer-events: none; z-index: 0;
        }
        /* Subtle grid texture */
        .hero-section-wrap::after {
            content: '';
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(199,208,238,0.15) 1px, transparent 1px),
                linear-gradient(90deg, rgba(199,208,238,0.15) 1px, transparent 1px);
            background-size: 40px 40px;
            mask-image: radial-gradient(ellipse 80% 80% at 70% 30%, black 20%, transparent 80%);
            pointer-events: none; z-index: 0;
        }
        .hero-wrapper {
            max-width: 1200px; margin: 0 auto; padding: 0 3rem;
            position: relative; z-index: 1;
        }
        .hero {
            padding: 5rem 0 4rem;
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 4rem; align-items: center;
            min-height: calc(100vh - 64px);
        }
        .hero-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(238,241,251,0.9);
            backdrop-filter: blur(8px);
            color: var(--blue); font-size: 0.72rem; font-weight: 600;
            letter-spacing: 0.04em; text-transform: uppercase;
            padding: 0.3rem 0.8rem; border-radius: 2rem;
            border: 1px solid var(--blue-mid); margin-bottom: 1.2rem;
        }
        .hero-title {
            font-size: clamp(2rem, 3.5vw, 3rem); font-weight: 800;
            line-height: 1.15; letter-spacing: -0.03em;
            color: var(--ink); margin-bottom: 1.2rem;
        }
        .hero-title span { color: var(--blue); }
        .hero-desc {
            font-size: 0.93rem; color: var(--body); line-height: 1.75;
            max-width: 420px; margin-bottom: 2rem;
        }
        .hero-cta { display: flex; gap: 0.75rem; align-items: center; margin-bottom: 2.5rem; flex-wrap: wrap; }
        .btn-primary {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: var(--orange); color: white;
            font-size: 0.85rem; font-weight: 600;
            padding: 0.7rem 1.5rem; border-radius: 8px;
            text-decoration: none; border: none; cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 14px rgba(245,165,36,0.3);
        }
        .btn-primary:hover { background: var(--orange-dark); transform: translateY(-1px); box-shadow: 0 6px 20px rgba(245,165,36,0.4); }
        .btn-secondary {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(255,255,255,0.8); backdrop-filter: blur(8px);
            color: var(--ink); font-size: 0.85rem; font-weight: 600;
            padding: 0.7rem 1.5rem; border-radius: 8px;
            text-decoration: none; border: 1px solid var(--border);
            transition: all 0.2s; cursor: pointer;
        }
        .btn-secondary:hover { border-color: var(--blue); color: var(--blue); }

        /* ─── HERO SVG ILLUSTRATION ─── */
        .hero-visual {
            position: relative; display: flex;
            align-items: center; justify-content: center;
        }
        .hero-illus-container {
            position: relative; width: 100%; max-width: 500px;
        }
        /* Floating glass badges */
        .float-badge {
            position: absolute;
            background: rgba(255,255,255,0.82);
            backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255,255,255,0.9);
            border-radius: 12px; padding: 0.6rem 0.85rem;
            box-shadow: 0 4px 20px rgba(26,43,107,0.10), 0 1px 3px rgba(0,0,0,0.04);
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.75rem; font-weight: 600; color: var(--ink);
            white-space: nowrap;
        }
        .fb-icon {
            width: 26px; height: 26px; border-radius: 7px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.8rem; flex-shrink: 0;
        }
        .fb-sub { font-size: 0.63rem; color: var(--muted); font-weight: 400; display: block; }
        .fb-1 { top: 4%; left: -4%; animation: fbFloat1 4.2s ease-in-out infinite alternate; }
        .fb-2 { top: 10%; right: -2%; animation: fbFloat2 5s ease-in-out infinite alternate; }
        .fb-3 { bottom: 24%; left: -6%; animation: fbFloat1 4.8s ease-in-out infinite alternate; animation-delay: 0.4s; }
        .fb-4 { bottom: 10%; right: 2%; animation: fbFloat2 4s ease-in-out infinite alternate; animation-delay: 0.2s; }
        @keyframes fbFloat1 { from { transform: translateY(0); } to { transform: translateY(-9px); } }
        @keyframes fbFloat2 { from { transform: translateY(0); } to { transform: translateY(8px); } }

        /* Pulsing dot on badge */
        .pulse-dot {
            width: 7px; height: 7px; border-radius: 50%;
            background: #10B981; flex-shrink: 0;
            box-shadow: 0 0 0 0 rgba(16,185,129,0.4);
            animation: pulseDot 2s infinite;
        }
        @keyframes pulseDot {
            0% { box-shadow: 0 0 0 0 rgba(16,185,129,0.4); }
            70% { box-shadow: 0 0 0 7px rgba(16,185,129,0); }
            100% { box-shadow: 0 0 0 0 rgba(16,185,129,0); }
        }

        /* The SVG itself */
        .hero-main-svg { width: 100%; display: block; }

        /* SVG element animations */
        @keyframes svgFloat { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
        @keyframes screenGlow { 0%,100% { opacity: 0.85; } 50% { opacity: 1; } }
        @keyframes orbitSpin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes barRise1 { 0%,100%{height:28px;y:252px} 50%{height:38px;y:242px} }
        @keyframes barRise2 { 0%,100%{height:38px;y:242px} 50%{height:24px;y:256px} }
        @keyframes barRise3 { 0%,100%{height:32px;y:248px} 50%{height:42px;y:238px} }
        @keyframes barRise4 { 0%,100%{height:22px;y:258px} 50%{height:34px;y:246px} }

        /* ─── CAREER EXPLORER ─── */
        .explorer-section-wrap {
            position: relative; overflow: hidden;
            border-top: 1px solid var(--border);
        }
        .explorer-section-wrap::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 50% 60% at 90% 50%, rgba(26,43,107,0.04) 0%, transparent 70%),
                radial-gradient(ellipse 40% 40% at 10% 50%, rgba(245,165,36,0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        .careers-layout {
            display: grid; grid-template-columns: 220px 1fr;
            border: 1px solid var(--border); border-radius: 16px;
            overflow: hidden; background: white;
            box-shadow: 0 2px 16px rgba(26,43,107,0.06);
            position: relative; z-index: 1;
        }
        .careers-sidebar { background: var(--bg); padding: 8px 0; border-right: 1px solid var(--border); }
        .career-tab {
            display: flex; align-items: center; justify-content: space-between;
            padding: 0.7rem 1.2rem; font-size: 0.82rem; font-weight: 500;
            color: var(--body); cursor: pointer; transition: all 0.15s;
            border-left: 2px solid transparent;
        }
        .career-tab:hover { background: var(--blue-light); color: var(--blue); }
        .career-tab.active { background: var(--blue-light); color: var(--blue); font-weight: 600; border-left-color: var(--blue); }

        /* Detail area: two columns - info left, illustration right */
        .careers-detail {
            display: grid; grid-template-columns: 1fr 280px;
            gap: 0; min-height: 300px;
        }
        .career-info-col { padding: 2rem; }
        .career-illus-col {
            background: linear-gradient(145deg, var(--blue-light) 0%, rgba(238,241,251,0.4) 100%);
            border-left: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            padding: 1.5rem; position: relative; overflow: hidden;
        }
        .career-illus-col::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 80% 80% at 50% 50%, rgba(26,43,107,0.05) 0%, transparent 70%);
        }
        .career-illus-svg { width: 100%; max-width: 200px; position: relative; z-index: 1; }

        .detail-title { font-size: 1.3rem; font-weight: 700; color: var(--ink); margin-bottom: 0.4rem; }
        .detail-desc { font-size: 0.82rem; color: var(--muted); max-width: 380px; line-height: 1.65; margin-bottom: 1.5rem; }
        .skills-heading {
            font-size: 0.72rem; font-weight: 600; color: var(--muted);
            letter-spacing: 0.06em; text-transform: uppercase; margin-bottom: 0.6rem;
        }
        .skill-chips { display: flex; flex-wrap: wrap; gap: 0.4rem; }
        .skill-chip {
            font-size: 0.72rem; font-weight: 500; padding: 0.3rem 0.7rem;
            border-radius: 6px; background: var(--blue-light); color: var(--blue);
            border: 1px solid var(--blue-mid); transition: all 0.15s;
        }
        .skill-chip:hover { background: var(--blue); color: white; border-color: var(--blue); }

        /* Career illustration elements */
        @keyframes careerFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
        @keyframes careerOrbit { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
        @keyframes careerPulse { 0%,100%{opacity:0.7} 50%{opacity:1} }

        /* ─── HOW IT WORKS ─── */
        .how-bg {
            position: relative; overflow: hidden;
            background: var(--bg);
            border-top: 1px solid var(--border); border-bottom: 1px solid var(--border);
        }
        .how-bg::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 60% 70% at 50% 0%, rgba(26,43,107,0.05) 0%, transparent 60%),
                radial-gradient(ellipse 40% 40% at 90% 80%, rgba(245,165,36,0.04) 0%, transparent 60%);
            pointer-events: none;
        }
        .steps-row { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; position: relative; z-index: 1; }
        .step-item { text-align: center; }
        .step-icon-wrap {
            width: 52px; height: 52px;
            background: rgba(255,255,255,0.9); backdrop-filter: blur(8px);
            border: 1px solid rgba(229,231,235,0.8);
            border-radius: 12px; display: flex; align-items: center; justify-content: center;
            font-size: 1.3rem; margin: 0 auto 0.75rem;
            box-shadow: 0 2px 10px rgba(26,43,107,0.07); transition: all 0.25s;
        }
        .step-item:hover .step-icon-wrap {
            background: var(--blue); transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(26,43,107,0.22);
        }
        .step-num-badge {
            width: 20px; height: 20px; background: var(--blue); color: white;
            border-radius: 50%; font-size: 0.65rem; font-weight: 700;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem;
        }
        .step-title-sm { font-size: 0.82rem; font-weight: 700; color: var(--ink); margin-bottom: 0.3rem; }
        .step-desc-sm { font-size: 0.75rem; color: var(--muted); line-height: 1.55; }

        /* ─── FEATURES / VISUALISASI ─── */
        .features-section-wrap {
            position: relative; overflow: hidden; background: var(--white);
        }
        .features-section-wrap::before {
            content: '';
            position: absolute; inset: 0;
            background:
                radial-gradient(ellipse 55% 60% at 15% 50%, rgba(26,43,107,0.05) 0%, transparent 65%),
                radial-gradient(ellipse 45% 50% at 85% 50%, rgba(245,165,36,0.04) 0%, transparent 65%);
            pointer-events: none;
        }
        .features-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 5rem; align-items: center; position: relative; z-index: 1; }

        /* Illustration panel for features */
        .feat-illus-wrap {
            position: relative; display: flex; align-items: center; justify-content: center;
        }
        .feat-illus-svg { width: 100%; max-width: 440px; display: block; }

        /* Floating mini cards around feat illustration */
        .feat-float {
            position: absolute;
            background: rgba(255,255,255,0.85);
            backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.95);
            border-radius: 10px; padding: 0.55rem 0.8rem;
            box-shadow: 0 4px 18px rgba(26,43,107,0.1);
            font-size: 0.72rem; font-weight: 600; color: var(--ink);
            display: flex; align-items: center; gap: 0.45rem; white-space: nowrap;
        }
        .feat-float .ff-icon { font-size: 1rem; }
        .feat-float .ff-sub { font-size: 0.62rem; color: var(--muted); font-weight: 400; }
        .ff-1 { top: 8%; right: 5%; animation: fbFloat2 4.5s ease-in-out infinite alternate; }
        .ff-2 { bottom: 12%; left: 5%; animation: fbFloat1 5s ease-in-out infinite alternate; }

        /* SVG animation for features */
        @keyframes featFloat { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
        @keyframes featOrbit { from{transform:rotate(0deg)} to{transform:rotate(360deg)} }
        @keyframes featPulse { 0%,100%{opacity:0.5;r:4} 50%{opacity:1;r:5.5} }
        @keyframes featDash { 0%{stroke-dashoffset:200} 100%{stroke-dashoffset:0} }
        @keyframes featBlink { 0%,100%{opacity:1} 50%{opacity:0.3} }

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
        .pillars-section-wrap {
            position: relative; overflow: hidden;
            background: var(--bg); border-top: 1px solid var(--border);
        }
        .pillars-section-wrap::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 60% 60% at 50% 100%, rgba(26,43,107,0.05) 0%, transparent 70%);
            pointer-events: none;
        }
        .pillars-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem; position: relative; z-index: 1; }
        .pillar-card {
            background: rgba(255,255,255,0.85); backdrop-filter: blur(8px);
            border: 1px solid rgba(229,231,235,0.9);
            border-radius: 12px; padding: 1.5rem; transition: all 0.25s; cursor: default;
            position: relative; overflow: hidden;
        }
        .pillar-card::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px;
            background: linear-gradient(90deg, var(--blue), #3b82f6);
            transform: scaleX(0); transform-origin: left; transition: transform 0.3s ease;
        }
        .pillar-card:hover::before { transform: scaleX(1); }
        .pillar-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(26,43,107,0.09); }
        .pillar-icon { width: 40px; height: 40px; background: var(--blue-light); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; margin-bottom: 1rem; transition: all 0.25s; }
        .pillar-card:hover .pillar-icon { background: var(--blue); }
        .pillar-title { font-size: 0.88rem; font-weight: 700; color: var(--ink); margin-bottom: 0.4rem; }
        .pillar-desc { font-size: 0.78rem; color: var(--muted); line-height: 1.6; }

        /* ─── FAQ ─── */
        .faq-section-wrap {
            position: relative; overflow: hidden;
            background: var(--bg); border-top: 1px solid var(--border);
        }
        .faq-section-wrap::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 50% 50% at 50% 0%, rgba(26,43,107,0.04) 0%, transparent 60%);
            pointer-events: none;
        }
        .faq-list { max-width: 680px; margin: 0 auto; position: relative; z-index: 1; }
        .faq-item {
            background: rgba(255,255,255,0.9); backdrop-filter: blur(6px);
            border: 1px solid var(--border); border-radius: 10px; margin-bottom: 0.75rem; overflow: hidden;
        }
        .faq-q { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; font-size: 0.85rem; font-weight: 600; color: var(--ink); cursor: pointer; user-select: none; }
        .faq-q i { color: var(--muted); transition: transform 0.2s; font-size: 16px; }
        .faq-item.open .faq-q i { transform: rotate(180deg); }
        .faq-item.open .faq-q { color: var(--blue); }
        .faq-a { padding: 0 1.25rem; font-size: 0.82rem; color: var(--body); line-height: 1.7; max-height: 0; overflow: hidden; transition: max-height .3s ease, padding .3s; }
        .faq-item.open .faq-a { max-height: 200px; padding: 0 1.25rem 1rem; }

        /* ─── SECTION SHARED ─── */
        .section { padding: 5rem 3rem; max-width: 1200px; margin: 0 auto; }
        .section-center { text-align: center; }
        .section-label { font-size: 0.75rem; font-weight: 600; letter-spacing: 0.08em; text-transform: uppercase; color: var(--blue); margin-bottom: 0.6rem; }
        .section-heading { font-size: clamp(1.6rem, 2.5vw, 2.2rem); font-weight: 800; letter-spacing: -0.02em; color: var(--ink); margin-bottom: 0.75rem; }
        .section-sub { font-size: 0.92rem; color: var(--muted); max-width: 520px; margin: 0 auto 3rem; }

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
            .hero-visual { display: none; }
            .careers-layout { grid-template-columns: 1fr; }
            .careers-detail { grid-template-columns: 1fr; }
            .career-illus-col { display: none; }
            .careers-sidebar { display: flex; overflow-x: auto; border-right: none; border-bottom: 1px solid var(--border); padding: 0; }
            .career-tab { white-space: nowrap; border-left: none; border-bottom: 2px solid transparent; }
            .career-tab.active { border-left: none; border-bottom-color: var(--blue); }
            .steps-row { grid-template-columns: repeat(3, 1fr); }
            .features-grid { grid-template-columns: 1fr; }
            .pillars-grid { grid-template-columns: 1fr 1fr; }
            .nav-links-center { display: none; }
        }
        @media (max-width: 640px) {
            nav.navbar { padding: 0 1.25rem; }
            .section { padding: 3.5rem 1.25rem; }
            .steps-row { grid-template-columns: 1fr 1fr; }
            .pillars-grid { grid-template-columns: 1fr 1fr; }
            footer.site-footer { flex-direction: column; gap: 1rem; text-align: center; padding: 1.5rem; }
            .footer-links { flex-wrap: wrap; justify-content: center; }
        }
    </style>
</head>
<body>

<!-- NAV -->
<nav class="navbar">
    <a href="/" class="nav-brand">
        <div class="nav-logo"><img src="{{ asset('images/logo3.png') }}" alt="SIREKA Logo"></div>
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
<div class="hero-section-wrap" id="hero">
    <div class="hero-wrapper">
        <section class="hero">
            <!-- Left: Text -->
            <div>
                <div class="hero-badge">✦ Sistem Rekomendasi Karir Berbasis Data</div>
                <h1 class="hero-title">Pahami Potensimu,<br><span>Temukan Arah Karirmu</span></h1>
                <p class="hero-desc">SIREKA adalah Sistem Rekomendasi Karir IT yang dipersonalisasi berdasarkan latar belakang pendidikan, skill, minat mendalam, dan pengalaman kamu.</p>
                <div class="hero-cta">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn-primary">Daftar Sekarang</a>
                    @endif
                    <a href="#cara-kerja" class="btn-secondary">Lihat Cara Kerja</a>
                </div>
            </div>

            <!-- Right: Clean SVG Illustration -->
            <div class="hero-visual">
                <div class="hero-illus-container">
                    <svg class="hero-main-svg" viewBox="0 0 480 420" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <linearGradient id="hgBlue" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#1A2B6B"/>
                                <stop offset="100%" stop-color="#2563EB"/>
                            </linearGradient>
                            <linearGradient id="hgBlueLight" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#EEF1FB"/>
                                <stop offset="100%" stop-color="#dce3f7"/>
                            </linearGradient>
                            <linearGradient id="hgOrange" x1="0" y1="0" x2="1" y2="0">
                                <stop offset="0%" stop-color="#F5A524"/>
                                <stop offset="100%" stop-color="#FBBF24"/>
                            </linearGradient>
                            <linearGradient id="hgSkin" x1="0" y1="0" x2="0" y2="1">
                                <stop offset="0%" stop-color="#FDE8C8"/>
                                <stop offset="100%" stop-color="#F5C99A"/>
                            </linearGradient>
                            <radialGradient id="hgGlow" cx="50%" cy="50%" r="50%">
                                <stop offset="0%" stop-color="#EEF1FB" stop-opacity="0.8"/>
                                <stop offset="100%" stop-color="#EEF1FB" stop-opacity="0"/>
                            </radialGradient>
                            <filter id="hfShadow">
                                <feDropShadow dx="0" dy="6" stdDeviation="10" flood-color="#1A2B6B" flood-opacity="0.1"/>
                            </filter>
                            <filter id="hfShadowSm">
                                <feDropShadow dx="0" dy="3" stdDeviation="6" flood-color="#1A2B6B" flood-opacity="0.12"/>
                            </filter>
                        </defs>

                        <!-- Glow background -->
                        <ellipse cx="240" cy="220" rx="180" ry="160" fill="url(#hgGlow)"/>

                        <!-- Outer dashed orbit -->
                        <circle cx="240" cy="210" r="155" stroke="#C7D0EE" stroke-width="1" stroke-dasharray="6 8" fill="none" opacity="0.5"
                            style="transform-box:fill-box;transform-origin:240px 210px;animation:orbitSpin 30s linear infinite"/>

                        <!-- Inner orbit -->
                        <circle cx="240" cy="210" r="110" stroke="#C7D0EE" stroke-width="1" stroke-dasharray="4 10" fill="none" opacity="0.35"
                            style="transform-box:fill-box;transform-origin:240px 210px;animation:orbitSpin 20s linear infinite reverse"/>

                        <!-- Orbit dots -->
                        <circle cx="240" cy="55" r="7" fill="url(#hgOrange)" opacity="0.85"
                            style="transform-box:fill-box;transform-origin:240px 210px;animation:orbitSpin 30s linear infinite"/>
                        <circle cx="388" cy="283" r="5" fill="url(#hgBlue)" opacity="0.6"
                            style="transform-box:fill-box;transform-origin:240px 210px;animation:orbitSpin 30s linear infinite"/>
                        <circle cx="92" cy="283" r="5" fill="url(#hgBlue)" opacity="0.6"
                            style="transform-box:fill-box;transform-origin:240px 210px;animation:orbitSpin 30s linear infinite"/>

                        <!-- Monitor base shadow -->
                        <ellipse cx="240" cy="375" rx="90" ry="8" fill="#E5E7EB" opacity="0.5"/>

                        <!-- Monitor body -->
                        <rect x="150" y="230" width="180" height="125" rx="12" fill="url(#hgBlueLight)" stroke="#C7D0EE" stroke-width="1.5" filter="url(#hfShadow)"
                            style="animation:svgFloat 5s ease-in-out infinite"/>
                        <!-- Monitor screen -->
                        <rect x="162" y="242" width="156" height="95" rx="7" fill="url(#hgBlue)"
                            style="animation:screenGlow 3s ease-in-out infinite"/>
                        <!-- Screen chart bars -->
                        <rect x="176" cy="252" y="252" width="18" height="28" rx="3" fill="url(#hgOrange)" style="animation:barRise1 2.8s ease-in-out infinite"/>
                        <rect x="200" cy="242" y="242" width="18" height="38" rx="3" fill="white" opacity="0.25" style="animation:barRise2 3.2s ease-in-out infinite"/>
                        <rect x="224" cy="248" y="248" width="18" height="32" rx="3" fill="url(#hgOrange)" style="animation:barRise3 2.5s ease-in-out infinite"/>
                        <rect x="248" cy="258" y="258" width="18" height="22" rx="3" fill="white" opacity="0.25" style="animation:barRise4 3.5s ease-in-out infinite"/>
                        <rect x="272" cy="245" y="245" width="18" height="35" rx="3" fill="url(#hgOrange)" style="animation:barRise1 3s ease-in-out infinite"/>
                        <!-- Screen top line -->
                        <rect x="174" y="252" width="55" height="5" rx="2.5" fill="white" opacity="0.45"/>
                        <rect x="174" y="261" width="38" height="4" rx="2" fill="white" opacity="0.2"/>
                        <!-- Monitor stand -->
                        <rect x="228" y="355" width="24" height="12" rx="3" fill="#C7D0EE"/>
                        <rect x="210" y="364" width="60" height="7" rx="3.5" fill="#C7D0EE"/>

                        <!-- Person body -->
                        <g style="animation:svgFloat 5s ease-in-out infinite">
                            <!-- Body torso -->
                            <rect x="200" y="168" width="80" height="70" rx="18" fill="url(#hgBlue)" filter="url(#hfShadowSm)"/>
                            <!-- Collar V -->
                            <path d="M240 172 L233 186 L240 192 L247 186 Z" fill="white" opacity="0.12"/>
                            <!-- Left arm -->
                            <rect x="162" y="176" width="42" height="18" rx="9" fill="url(#hgBlue)"/>
                            <!-- Right arm -->
                            <rect x="276" y="176" width="42" height="18" rx="9" fill="url(#hgBlue)"/>
                            <!-- Hands -->
                            <circle cx="163" cy="185" r="10" fill="url(#hgSkin)"/>
                            <circle cx="317" cy="185" r="10" fill="url(#hgSkin)"/>
                            <!-- Head -->
                            <circle cx="240" cy="148" r="32" fill="url(#hgSkin)" filter="url(#hfShadowSm)"/>
                            <!-- Hair -->
                            <path d="M210 142 Q213 112 240 110 Q267 112 270 142 Q264 130 240 128 Q216 130 210 142Z" fill="#1A2B6B"/>
                            <!-- Face details -->
                            <circle cx="230" cy="146" r="4" fill="#333"/>
                            <circle cx="250" cy="146" r="4" fill="#333"/>
                            <circle cx="231" cy="145" r="1.5" fill="white"/>
                            <circle cx="251" cy="145" r="1.5" fill="white"/>
                            <path d="M232 158 Q240 165 248 158" stroke="#C17A3A" stroke-width="1.8" stroke-linecap="round" fill="none"/>
                            <!-- Cheek blush -->
                            <circle cx="220" cy="155" r="6" fill="#F5A524" opacity="0.15"/>
                            <circle cx="260" cy="155" r="6" fill="#F5A524" opacity="0.15"/>
                        </g>

                        <!-- Floating star accents -->
                        <path d="M76 140 L78.5 133 L81 140 L88 142.5 L81 145 L78.5 152 L76 145 L69 142.5Z" fill="#F5A524" opacity="0.65"/>
                        <path d="M396 130 L398 124 L400 130 L406 132 L400 134 L398 140 L396 134 L390 132Z" fill="#1A2B6B" opacity="0.45"/>
                        <circle cx="90" cy="300" r="5" fill="none" stroke="#C7D0EE" stroke-width="1.5"/>
                        <circle cx="392" cy="290" r="5" fill="none" stroke="#C7D0EE" stroke-width="1.5"/>
                        <circle cx="110" cy="180" r="3.5" fill="#F5A524" opacity="0.4"/>
                        <circle cx="370" cy="250" r="3.5" fill="#F5A524" opacity="0.4"/>
                        <circle cx="370" cy="170" r="3" fill="#C7D0EE"/>
                        <circle cx="112" cy="260" r="3" fill="#C7D0EE"/>
                    </svg>

                    <!-- Floating glass badges -->
                    <div class="float-badge fb-1">
                        <div class="fb-icon" style="background:#EEF1FB">💻</div>
                        <div><div>Software Engineer</div><span class="fb-sub">94% kesesuaian</span></div>
                    </div>
                    <div class="float-badge fb-2">
                        <div class="pulse-dot"></div>
                        <div><div>Analisis Aktif</div><span class="fb-sub">Real-time</span></div>
                    </div>
                    <div class="float-badge fb-3">
                        <div class="fb-icon" style="background:#EEF1FB">📊</div>
                        <div><div>Data Analyst</div><span class="fb-sub">82% kesesuaian</span></div>
                    </div>
                    <div class="float-badge fb-4">
                        <div class="fb-icon" style="background:#ECFDF5">✅</div>
                        <div><div>5 Sertifikasi</div><span class="fb-sub">Terverifikasi</span></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- CAREER EXPLORER -->
<div class="explorer-section-wrap">
    <div class="section section-center" style="padding-bottom:0">
        <div class="section-label">Eksplorasi Karir</div>
        <h2 class="section-heading">Eksplorasi Spektrum Karir IT</h2>
        <p class="section-sub">Temukan detail setiap peran dan keahlian yang dibutuhkan di industri teknologi.</p>
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
                <p class="step-desc-sm">Evaluasi berdasarkan riwayat pendidikan.</p>
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
                <div class="step-title-sm">CBF dan SAW</div>
                <p class="step-desc-sm">Cocokkan profil kamu dengan karir (CBF), lalu hitung ranking dengan kecocokan (SAW)</p>
            </div>
            <div class="step-item">
                <div class="step-icon-wrap">🏆</div>
                <div class="step-num-badge">5</div>
                <div class="step-title-sm">Recommendation</div>
                <p class="step-desc-sm">Dapatkan ranking karir paling sesuai</p>
            </div>
        </div>
    </div>
</div>

<!-- FEATURES -->
<div class="features-section-wrap" id="fitur">
    <div class="section">
        <div class="features-grid">
            <!-- Left: Illustration -->
            <div class="feat-illus-wrap">
                <svg class="feat-illus-svg" viewBox="0 0 440 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <linearGradient id="fgBlue" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#1A2B6B"/>
                            <stop offset="100%" stop-color="#1e40af"/>
                        </linearGradient>
                        <linearGradient id="fgCard" x1="0" y1="0" x2="0" y2="1">
                            <stop offset="0%" stop-color="#f8faff"/>
                            <stop offset="100%" stop-color="#eef1fb"/>
                        </linearGradient>
                        <linearGradient id="fgOr" x1="0" y1="0" x2="1" y2="0">
                            <stop offset="0%" stop-color="#F5A524"/>
                            <stop offset="100%" stop-color="#FBBF24"/>
                        </linearGradient>
                        <radialGradient id="fgGlow" cx="50%" cy="50%" r="50%">
                            <stop offset="0%" stop-color="#EEF1FB" stop-opacity="0.9"/>
                            <stop offset="100%" stop-color="#EEF1FB" stop-opacity="0"/>
                        </radialGradient>
                        <filter id="ffShadow">
                            <feDropShadow dx="0" dy="8" stdDeviation="12" flood-color="#1A2B6B" flood-opacity="0.12"/>
                        </filter>
                        <filter id="ffShadowSm">
                            <feDropShadow dx="0" dy="3" stdDeviation="6" flood-color="#1A2B6B" flood-opacity="0.1"/>
                        </filter>
                    </defs>

                    <!-- Background glow -->
                    <ellipse cx="220" cy="200" rx="180" ry="160" fill="url(#fgGlow)"/>

                    <!-- Connecting network lines -->
                    <line x1="220" y1="200" x2="120" y2="100" stroke="#C7D0EE" stroke-width="1.5" stroke-dasharray="5 5"
                        style="stroke-dashoffset:0;animation:featDash 3s linear infinite"/>
                    <line x1="220" y1="200" x2="320" y2="100" stroke="#C7D0EE" stroke-width="1.5" stroke-dasharray="5 5"
                        style="stroke-dashoffset:0;animation:featDash 3.5s linear infinite"/>
                    <line x1="220" y1="200" x2="100" y2="260" stroke="#C7D0EE" stroke-width="1.5" stroke-dasharray="5 5"
                        style="stroke-dashoffset:0;animation:featDash 2.8s linear infinite"/>
                    <line x1="220" y1="200" x2="340" y2="270" stroke="#C7D0EE" stroke-width="1.5" stroke-dasharray="5 5"
                        style="stroke-dashoffset:0;animation:featDash 4s linear infinite"/>
                    <line x1="220" y1="200" x2="220" y2="340" stroke="#C7D0EE" stroke-width="1.5" stroke-dasharray="5 5"
                        style="stroke-dashoffset:0;animation:featDash 3.2s linear infinite"/>

                    <!-- Center node: person/brain hub -->
                    <circle cx="220" cy="200" r="48" fill="url(#fgBlue)" filter="url(#ffShadow)"
                        style="animation:featFloat 4s ease-in-out infinite"/>
                    <!-- Center icon: graduation cap simplified -->
                    <rect x="204" y="190" width="32" height="22" rx="4" fill="white" opacity="0.2"/>
                    <polygon points="220,180 204,190 236,190" fill="white" opacity="0.35"/>
                    <line x1="234" y1="190" x2="234" y2="200" stroke="white" stroke-width="2" opacity="0.5"/>
                    <circle cx="234" cy="202" r="2.5" fill="url(#fgOr)"/>
                    <!-- Pulsing ring -->
                    <circle cx="220" cy="200" r="58" stroke="#1A2B6B" stroke-width="1" fill="none" opacity="0.15"
                        style="animation:featPulse 3s ease-in-out infinite"/>
                    <circle cx="220" cy="200" r="70" stroke="#1A2B6B" stroke-width="0.8" fill="none" opacity="0.08"
                        style="animation:featPulse 3s ease-in-out infinite;animation-delay:0.5s"/>

                    <!-- Satellite node: SE -->
                    <g style="animation:careerFloat 4.5s ease-in-out infinite">
                        <rect x="80" y="68" width="80" height="52" rx="10" fill="url(#fgCard)" stroke="#C7D0EE" stroke-width="1" filter="url(#ffShadowSm)"/>
                        <text x="120" y="88" text-anchor="middle" font-size="18">💻</text>
                        <text x="120" y="105" text-anchor="middle" font-size="8" fill="#1A2B6B" font-weight="600" font-family="sans-serif">Software Eng.</text>
                    </g>

                    <!-- Satellite node: Data -->
                    <g style="animation:careerFloat 5s ease-in-out infinite;animation-delay:0.3s">
                        <rect x="280" y="68" width="80" height="52" rx="10" fill="url(#fgCard)" stroke="#C7D0EE" stroke-width="1" filter="url(#ffShadowSm)"/>
                        <text x="320" y="88" text-anchor="middle" font-size="18">📊</text>
                        <text x="320" y="105" text-anchor="middle" font-size="8" fill="#1A2B6B" font-weight="600" font-family="sans-serif">Data Analyst</text>
                    </g>

                    <!-- Satellite node: Security -->
                    <g style="animation:careerFloat 3.8s ease-in-out infinite;animation-delay:0.6s">
                        <rect x="44" y="232" width="80" height="52" rx="10" fill="url(#fgCard)" stroke="#C7D0EE" stroke-width="1" filter="url(#ffShadowSm)"/>
                        <text x="84" y="252" text-anchor="middle" font-size="18">🛡️</text>
                        <text x="84" y="269" text-anchor="middle" font-size="8" fill="#1A2B6B" font-weight="600" font-family="sans-serif">Cyber Security</text>
                    </g>

                    <!-- Satellite node: Cloud -->
                    <g style="animation:careerFloat 4.2s ease-in-out infinite;animation-delay:0.9s">
                        <rect x="316" y="242" width="80" height="52" rx="10" fill="url(#fgCard)" stroke="#C7D0EE" stroke-width="1" filter="url(#ffShadowSm)"/>
                        <text x="356" y="262" text-anchor="middle" font-size="18">☁️</text>
                        <text x="356" y="279" text-anchor="middle" font-size="8" fill="#1A2B6B" font-weight="600" font-family="sans-serif">Cloud Engineer</text>
                    </g>

                    <!-- Satellite node: UX -->
                    <g style="animation:careerFloat 5.2s ease-in-out infinite;animation-delay:1.1s">
                        <rect x="180" y="315" width="80" height="52" rx="10" fill="url(#fgOr)" filter="url(#ffShadowSm)"/>
                        <text x="220" y="335" text-anchor="middle" font-size="18">🎨</text>
                        <text x="220" y="352" text-anchor="middle" font-size="8" fill="white" font-weight="700" font-family="sans-serif">UI/UX Designer</text>
                    </g>

                    <!-- Dot accents -->
                    <circle cx="160" cy="50" r="4" fill="#F5A524" opacity="0.5"/>
                    <circle cx="380" cy="160" r="4" fill="#F5A524" opacity="0.5"/>
                    <circle cx="60" cy="180" r="3" fill="#C7D0EE"/>
                    <circle cx="400" cy="360" r="3" fill="#C7D0EE"/>
                </svg>

                <!-- Floating mini cards -->
                <div class="feat-float ff-1">
                    <span class="ff-icon">🤖</span>
                    <div><div>ML Engineer</div><span class="ff-sub">Jalur AI / ML</span></div>
                </div>
                <div class="feat-float ff-2">
                    <span class="ff-icon">🔬</span>
                    <div><div>Data Scientist</div><span class="ff-sub">Model Prediktif</span></div>
                </div>
            </div>

            <!-- Right: Text -->
            <div>
                <div class="feature-badge">✦ Visualisasi Komprehensif</div>
                <h2 class="features-title">Visualisasi Potensi yang Komprehensif</h2>
                <p class="features-desc">Dapatkan gambaran jelas tentang di mana letak keunggulanmu melalui grafik radar minat, progress bar keahlian, dan analisis persentase kecocokan industri yang mendalam.</p>
                <div class="feature-check-list">
                    <div class="feature-check">
                        <div class="check-icon">✓</div>
                        <span><strong>Matriks Kompetensi</strong> — Membandingkan riwayat akademik dengan standar industri.</span>
                    </div>
                    <div class="feature-check">
                        <div class="check-icon">✓</div>
                        <span><strong>Kecocokan Karakter</strong> — Sejauh mana kepribadianmu cocok dengan budaya kerja di IT.</span>
                    </div>
                    <div class="feature-check">
                        <div class="check-icon">✓</div>
                        <span><strong>CBF + SAW</strong> — Pencocokan profil berbasis Content-Based Filtering dan perankingan Simple Additive Writing.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PILLARS -->
<div class="pillars-section-wrap">
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
<div class="faq-section-wrap" id="faq">
    <div class="section section-center">
        <div class="section-label">FAQ</div>
        <h2 class="section-heading">Pertanyaan Umum</h2>
        <p class="section-sub" style="margin-bottom:2rem;">Jawaban atas pertanyaan yang sering ditanyakan.</p>
        <div class="faq-list">
            <div class="faq-item open">
                <div class="faq-q">Bagaimana SIREKA menentukan tingkat kesesuaian? <i class="ti ti-chevron-down"></i></div>
                <div class="faq-a">SIREKA menggunakan Content-Baed Filtering (CBF) untuk mencocokkan profil kamu seperti pendidikan, skill, spesialisasi, dan sertifikat dengan profil setiap karir. Skor kecocokan dihitung dengan Simple Additive Writing (SAW), lalu dinormalisasikan menjadi presentasi 0-100% agar ranking karir lebih mudah dipahami.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q">Apakah platform ini berbayar? <i class="ti ti-chevron-down"></i></div>
                <div class="faq-a">Tidak. SIREKA sepenuhnya gratis untuk digunakan oleh seluruh mahasiswa JTI.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q">Dapatkah saya mengupdate data performa saya? <i class="ti ti-chevron-down"></i></div>
                <div class="faq-a">Ya, kamu dapat memperbarui profil, skill, dan sertifikasi kapan saja melalui dashboard untuk mendapatkan rekomendasi yang lebih akurat.</div>
            </div>
            <div class="faq-item">
                <div class="faq-q">Berapa lama proses analisis berlangsung? <i class="ti ti-chevron-down"></i></div>
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
/* ── CAREER DATA ── */
const careers = [
    {
        name: 'Software Engineer', icon: '💻',
        desc: 'Merancang, mengembangkan, dan memelihara sistem perangkat lunak kompleks menggunakan berbagai bahasa pemrograman dan arsitektur modern.',
        skills: ['Java', 'React.js', 'SQL', 'System Design', 'Git'],
        illusColor: '#1A2B6B', illusIcon: '💻',
        illusSvg: `
            <!-- Laptop/Code scene -->
            <rect x="30" y="60" width="140" height="95" rx="10" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <rect x="40" y="70" width="120" height="68" rx="6" fill="#1A2B6B"/>
            <!-- Code lines -->
            <rect x="50" y="80" width="45" height="5" rx="2" fill="#F5A524" opacity="0.8"/>
            <rect x="60" y="90" width="60" height="4" rx="2" fill="white" opacity="0.35"/>
            <rect x="60" y="99" width="40" height="4" rx="2" fill="#6ee7b7" opacity="0.6"/>
            <rect x="50" y="108" width="30" height="4" rx="2" fill="#F5A524" opacity="0.8"/>
            <rect x="85" y="108" width="50" height="4" rx="2" fill="white" opacity="0.25"/>
            <rect x="60" y="117" width="55" height="4" rx="2" fill="white" opacity="0.2"/>
            <rect x="50" y="126" width="25" height="4" rx="2" fill="#F5A524" opacity="0.8"/>
            <!-- Keyboard base -->
            <rect x="22" y="155" width="156" height="8" rx="4" fill="#C7D0EE"/>
            <!-- Floating bracket icon -->
            <circle cx="155" cy="50" r="18" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1"/>
            <text x="155" y="56" text-anchor="middle" font-size="14" fill="#1A2B6B" font-weight="700" font-family="monospace">&lt;/&gt;</text>
            <!-- Gear icon -->
            <circle cx="30" cy="150" r="14" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1"/>
            <circle cx="30" cy="150" r="5" fill="#1A2B6B" opacity="0.4"/>
            <rect x="28" y="137" width="4" height="5" rx="2" fill="#1A2B6B" opacity="0.5"/>
            <rect x="28" y="158" width="4" height="5" rx="2" fill="#1A2B6B" opacity="0.5"/>
            <rect x="17" y="148" width="5" height="4" rx="2" fill="#1A2B6B" opacity="0.5"/>
            <rect x="38" y="148" width="5" height="4" rx="2" fill="#1A2B6B" opacity="0.5"/>
        `
    },
    {
        name: 'Data Analyst', icon: '📊',
        desc: 'Menganalisis data besar untuk menghasilkan insight bisnis yang actionable melalui visualisasi dan laporan strategis.',
        skills: ['Python', 'SQL', 'Tableau', 'Statistics', 'Excel'],
        illusColor: '#0369a1',
        illusSvg: `
            <!-- Bar chart scene -->
            <rect x="20" y="40" width="160" height="130" rx="10" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <!-- Chart area -->
            <rect x="30" y="50" width="140" height="90" rx="5" fill="white"/>
            <!-- Bars -->
            <rect x="45" y="95" width="18" height="38" rx="3" fill="#1A2B6B" opacity="0.8"/>
            <rect x="70" y="78" width="18" height="55" rx="3" fill="url(#fgOr)"/>
            <rect x="95" y="88" width="18" height="45" rx="3" fill="#1A2B6B" opacity="0.5"/>
            <rect x="120" y="70" width="18" height="63" rx="3" fill="url(#fgOr)"/>
            <rect x="145" y="82" width="18" height="51" rx="3" fill="#1A2B6B" opacity="0.6"/>
            <!-- Trend line -->
            <polyline points="54,100 79,82 104,92 129,72 154,86" stroke="#F5A524" stroke-width="2" fill="none" stroke-linecap="round"/>
            <!-- Dots on trend -->
            <circle cx="54" cy="100" r="3" fill="#F5A524"/>
            <circle cx="79" cy="82" r="3" fill="#F5A524"/>
            <circle cx="129" cy="72" r="3" fill="#F5A524"/>
            <!-- Label -->
            <rect x="30" y="145" width="60" height="5" rx="2" fill="#C7D0EE"/>
            <rect x="30" y="155" width="40" height="4" rx="2" fill="#C7D0EE" opacity="0.6"/>
            <!-- Pie icon -->
            <circle cx="155" cy="160" r="16" fill="white" stroke="#C7D0EE" stroke-width="1"/>
            <path d="M155 160 L155 145 A15 15 0 0 1 168 168 Z" fill="#F5A524"/>
            <path d="M155 160 L168 168 A15 15 0 0 1 140 170 Z" fill="#1A2B6B" opacity="0.5"/>
            <path d="M155 160 L140 170 A15 15 0 0 1 155 145 Z" fill="#1A2B6B" opacity="0.8"/>
        `
    },
    {
        name: 'Data Scientist', icon: '🔬',
        desc: 'Membangun model prediktif dan algoritma machine learning untuk memecahkan masalah bisnis yang kompleks.',
        skills: ['Python', 'R', 'TensorFlow', 'Statistics', 'ML'],
        illusColor: '#7c3aed',
        illusSvg: `
            <!-- Neural network scene -->
            <!-- Lines layer 1-2 -->
            <line x1="52" y1="60" x2="110" y2="80" stroke="#C7D0EE" stroke-width="1.2"/>
            <line x1="52" y1="60" x2="110" y2="110" stroke="#C7D0EE" stroke-width="1.2"/>
            <line x1="52" y1="60" x2="110" y2="140" stroke="#C7D0EE" stroke-width="1.2"/>
            <line x1="52" y1="105" x2="110" y2="80" stroke="#C7D0EE" stroke-width="1.2"/>
            <line x1="52" y1="105" x2="110" y2="110" stroke="#C7D0EE" stroke-width="1.2"/>
            <line x1="52" y1="105" x2="110" y2="140" stroke="#C7D0EE" stroke-width="1.2"/>
            <line x1="52" y1="150" x2="110" y2="80" stroke="#C7D0EE" stroke-width="1.2"/>
            <line x1="52" y1="150" x2="110" y2="110" stroke="#C7D0EE" stroke-width="1.2"/>
            <line x1="52" y1="150" x2="110" y2="140" stroke="#C7D0EE" stroke-width="1.2"/>
            <!-- Lines layer 2-3 -->
            <line x1="110" y1="80" x2="168" y2="90" stroke="#1A2B6B" stroke-width="1.2" opacity="0.5"/>
            <line x1="110" y1="80" x2="168" y2="125" stroke="#1A2B6B" stroke-width="1.2" opacity="0.5"/>
            <line x1="110" y1="110" x2="168" y2="90" stroke="#F5A524" stroke-width="1.5" opacity="0.7"/>
            <line x1="110" y1="110" x2="168" y2="125" stroke="#F5A524" stroke-width="1.5" opacity="0.7"/>
            <line x1="110" y1="140" x2="168" y2="90" stroke="#1A2B6B" stroke-width="1.2" opacity="0.5"/>
            <line x1="110" y1="140" x2="168" y2="125" stroke="#1A2B6B" stroke-width="1.2" opacity="0.5"/>
            <!-- Layer 1 nodes -->
            <circle cx="52" cy="60" r="12" fill="#EEF1FB" stroke="#1A2B6B" stroke-width="1.5"/>
            <circle cx="52" cy="105" r="12" fill="#EEF1FB" stroke="#1A2B6B" stroke-width="1.5"/>
            <circle cx="52" cy="150" r="12" fill="#EEF1FB" stroke="#1A2B6B" stroke-width="1.5"/>
            <!-- Layer 2 nodes -->
            <circle cx="110" cy="80" r="14" fill="#1A2B6B"/>
            <circle cx="110" cy="110" r="14" fill="url(#fgOr)"/>
            <circle cx="110" cy="140" r="14" fill="#1A2B6B"/>
            <!-- Layer 3 nodes -->
            <circle cx="168" cy="90" r="12" fill="#EEF1FB" stroke="#F5A524" stroke-width="2"/>
            <circle cx="168" cy="125" r="12" fill="#EEF1FB" stroke="#1A2B6B" stroke-width="1.5"/>
            <!-- Inner dots -->
            <circle cx="52" cy="60" r="4" fill="#1A2B6B" opacity="0.4"/>
            <circle cx="52" cy="105" r="4" fill="#1A2B6B" opacity="0.4"/>
            <circle cx="52" cy="150" r="4" fill="#1A2B6B" opacity="0.4"/>
            <circle cx="168" cy="90" r="4" fill="#F5A524"/>
        `
    },
    {
        name: 'UI/UX Designer', icon: '🎨',
        desc: 'Merancang antarmuka pengguna yang intuitif dan pengalaman digital yang menyenangkan berdasarkan riset pengguna mendalam.',
        skills: ['Figma', 'Prototyping', 'User Research', 'CSS', 'Design System'],
        illusColor: '#db2777',
        illusSvg: `
            <!-- Figma-like design scene -->
            <!-- Canvas bg -->
            <rect x="20" y="35" width="160" height="140" rx="10" fill="#F9FAFB" stroke="#C7D0EE" stroke-width="1.5"/>
            <!-- Toolbar -->
            <rect x="20" y="35" width="160" height="22" rx="10" fill="#EEF1FB"/>
            <rect x="20" y="46" width="160" height="11" fill="#EEF1FB"/>
            <circle cx="33" cy="46" r="4" fill="#F5A524" opacity="0.7"/>
            <circle cx="47" cy="46" r="4" fill="#1A2B6B" opacity="0.4"/>
            <circle cx="61" cy="46" r="4" fill="#1A2B6B" opacity="0.25"/>
            <!-- Phone wireframe on canvas -->
            <rect x="80" y="65" width="55" height="90" rx="8" fill="white" stroke="#C7D0EE" stroke-width="1.5"/>
            <rect x="88" y="75" width="39" height="24" rx="4" fill="#EEF1FB"/>
            <rect x="88" y="103" width="39" height="6" rx="3" fill="#C7D0EE" opacity="0.7"/>
            <rect x="88" y="113" width="25" height="6" rx="3" fill="#C7D0EE" opacity="0.5"/>
            <rect x="88" y="127" width="39" height="18" rx="4" fill="#F5A524" opacity="0.7"/>
            <!-- Cursor -->
            <path d="M148 95 L148 112 L152 108 L155 114 L157 113 L154 107 L159 107Z" fill="#1A2B6B"/>
            <!-- Left panel shapes -->
            <circle cx="45" cy="80" r="12" fill="white" stroke="#C7D0EE" stroke-width="1.5"/>
            <circle cx="45" cy="80" r="6" fill="#F5A524" opacity="0.6"/>
            <rect x="33" y="100" width="24" height="18" rx="4" fill="white" stroke="#C7D0EE" stroke-width="1.5"/>
            <rect x="37" y="104" width="16" height="10" rx="2" fill="#1A2B6B" opacity="0.25"/>
            <circle cx="45" cy="132" r="10" fill="white" stroke="#F5A524" stroke-width="1.5"/>
            <!-- Grid dots -->
            <circle cx="145" cy="65" r="1.5" fill="#C7D0EE"/>
            <circle cx="155" cy="65" r="1.5" fill="#C7D0EE"/>
            <circle cx="165" cy="65" r="1.5" fill="#C7D0EE"/>
        `
    },
    {
        name: 'ML Engineer', icon: '🤖',
        desc: 'Mengimplementasikan, men-deploy, dan memelihara model machine learning di lingkungan produksi skala besar.',
        skills: ['Python', 'PyTorch', 'Docker', 'Kubernetes', 'MLOps'],
        illusColor: '#059669',
        illusSvg: `
            <!-- Pipeline / robot scene -->
            <!-- Pipeline boxes -->
            <rect x="15" y="55" width="45" height="35" rx="7" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <text x="37" y="77" text-anchor="middle" font-size="14">📥</text>
            <line x1="60" y1="72" x2="80" y2="72" stroke="#C7D0EE" stroke-width="1.5" stroke-dasharray="3 3"/>
            <rect x="80" y="55" width="45" height="35" rx="7" fill="#1A2B6B"/>
            <text x="102" y="77" text-anchor="middle" font-size="14">⚙️</text>
            <line x1="125" y1="72" x2="145" y2="72" stroke="#C7D0EE" stroke-width="1.5" stroke-dasharray="3 3"/>
            <rect x="145" y="55" width="45" height="35" rx="7" fill="url(#fgOr)"/>
            <text x="167" y="77" text-anchor="middle" font-size="14">📤</text>
            <!-- Robot / model icon below -->
            <rect x="75" y="115" width="55" height="50" rx="10" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <rect x="88" y="125" width="29" height="18" rx="5" fill="#1A2B6B" opacity="0.2"/>
            <circle cx="95" cy="134" r="4" fill="#1A2B6B" opacity="0.7"/>
            <circle cx="110" cy="134" r="4" fill="url(#fgOr)"/>
            <rect x="90" y="147" width="25" height="4" rx="2" fill="#C7D0EE"/>
            <!-- Antennas -->
            <line x1="95" y1="115" x2="90" y2="102" stroke="#C7D0EE" stroke-width="1.5"/>
            <circle cx="90" cy="100" r="3" fill="#F5A524"/>
            <line x1="110" y1="115" x2="115" y2="102" stroke="#C7D0EE" stroke-width="1.5"/>
            <circle cx="115" cy="100" r="3" fill="#1A2B6B" opacity="0.5"/>
            <!-- Docker-like containers -->
            <rect x="20" y="130" width="40" height="22" rx="5" fill="white" stroke="#C7D0EE" stroke-width="1"/>
            <rect x="24" y="134" width="14" height="14" rx="3" fill="#EEF1FB"/>
            <rect x="40" y="134" width="14" height="14" rx="3" fill="#EEF1FB"/>
            <rect x="155" y="130" width="40" height="22" rx="5" fill="white" stroke="#C7D0EE" stroke-width="1"/>
            <rect x="159" y="134" width="14" height="14" rx="3" fill="#EEF1FB"/>
            <rect x="175" y="134" width="14" height="14" rx="3" fill="#EEF1FB"/>
        `
    },
    {
        name: 'Cyber Security', icon: '🛡️',
        desc: 'Melindungi sistem dan jaringan dari ancaman siber melalui analisis keamanan, penetration testing, dan incident response.',
        skills: ['Network Security', 'Python', 'Kali Linux', 'Forensics', 'SIEM'],
        illusColor: '#dc2626',
        illusSvg: `
            <!-- Shield / lock scene -->
            <!-- Shield main -->
            <path d="M100 38 L155 60 L155 115 Q155 155 100 175 Q45 155 45 115 L45 60 Z" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <path d="M100 50 L142 68 L142 112 Q142 145 100 162 Q58 145 58 112 L58 68 Z" fill="#1A2B6B" opacity="0.12"/>
            <!-- Lock icon inside shield -->
            <rect x="83" y="100" width="34" height="28" rx="6" fill="#1A2B6B"/>
            <path d="M88 100 L88 92 Q88 80 100 80 Q112 80 112 92 L112 100" stroke="#1A2B6B" stroke-width="4" stroke-linecap="round" fill="none"/>
            <circle cx="100" cy="114" r="4" fill="white" opacity="0.7"/>
            <line x1="100" y1="114" x2="100" y2="122" stroke="white" stroke-width="2.5" stroke-linecap="round" opacity="0.7"/>
            <!-- Scan rings -->
            <circle cx="100" cy="107" r="50" stroke="#F5A524" stroke-width="1" fill="none" opacity="0.3" stroke-dasharray="4 6"
                style="transform-box:fill-box;transform-origin:100px 107px;animation:featOrbit 8s linear infinite"/>
            <!-- Warning dots -->
            <circle cx="42" cy="75" r="8" fill="#FEF3C7" stroke="#F5A524" stroke-width="1.5"/>
            <text x="42" y="79" text-anchor="middle" font-size="9" fill="#D97706" font-weight="700" font-family="sans-serif">!</text>
            <circle cx="158" cy="140" r="8" fill="#DCFCE7" stroke="#22C55E" stroke-width="1.5"/>
            <text x="158" y="144" text-anchor="middle" font-size="9" fill="#16A34A" font-weight="700" font-family="sans-serif">✓</text>
        `
    },
    {
        name: 'Cloud Engineer', icon: '☁️',
        desc: 'Merancang dan mengelola infrastruktur cloud yang skalabel, aman, dan hemat biaya untuk mendukung aplikasi modern.',
        skills: ['AWS/GCP', 'Terraform', 'Docker', 'Kubernetes', 'CI/CD'],
        illusColor: '#0ea5e9',
        illusSvg: `
            <!-- Cloud infra scene -->
            <!-- Main cloud -->
            <ellipse cx="100" cy="75" rx="65" ry="35" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <ellipse cx="78" cy="82" rx="28" ry="22" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <ellipse cx="122" cy="78" rx="30" ry="24" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <!-- Cloud interior -->
            <ellipse cx="100" cy="73" rx="55" ry="28" fill="white"/>
            <text x="100" y="79" text-anchor="middle" font-size="22">☁️</text>
            <!-- Server nodes below cloud -->
            <line x1="65" y1="98" x2="55" y2="120" stroke="#C7D0EE" stroke-width="1.5"/>
            <line x1="100" y1="100" x2="100" y2="122" stroke="#C7D0EE" stroke-width="1.5"/>
            <line x1="135" y1="98" x2="145" y2="120" stroke="#C7D0EE" stroke-width="1.5"/>
            <!-- Servers -->
            <rect x="35" y="120" width="40" height="28" rx="6" fill="#1A2B6B"/>
            <rect x="39" y="125" width="14" height="8" rx="2" fill="white" opacity="0.2"/>
            <circle cx="61" cy="129" r="3" fill="url(#fgOr)"/>
            <rect x="39" y="135" width="28" height="4" rx="2" fill="white" opacity="0.15"/>
            <rect x="80" y="122" width="40" height="28" rx="6" fill="url(#fgOr)"/>
            <rect x="84" y="127" width="14" height="8" rx="2" fill="white" opacity="0.3"/>
            <circle cx="106" cy="131" r="3" fill="white" opacity="0.8"/>
            <rect x="84" y="137" width="28" height="4" rx="2" fill="white" opacity="0.3"/>
            <rect x="125" y="120" width="40" height="28" rx="6" fill="#1A2B6B"/>
            <rect x="129" y="125" width="14" height="8" rx="2" fill="white" opacity="0.2"/>
            <circle cx="151" cy="129" r="3" fill="url(#fgOr)"/>
            <rect x="129" y="135" width="28" height="4" rx="2" fill="white" opacity="0.15"/>
            <!-- Kubernetes hex hint -->
            <polygon points="100,158 112,165 112,178 100,185 88,178 88,165" fill="#EEF1FB" stroke="#C7D0EE" stroke-width="1.5"/>
            <text x="100" y="176" text-anchor="middle" font-size="10" fill="#1A2B6B" font-weight="700" font-family="sans-serif">K8s</text>
        `
    }
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
        <div class="career-info-col">
            <div class="detail-title">${c.icon} ${c.name}</div>
            <div class="detail-desc">${c.desc}</div>
            <div class="skills-heading">Keahlian Utama</div>
            <div class="skill-chips">
                ${c.skills.map(s => `<span class="skill-chip">${s}</span>`).join('')}
            </div>
        </div>
        <div class="career-illus-col">
            <svg class="career-illus-svg" viewBox="0 0 200 210" fill="none" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="fgOr" x1="0" y1="0" x2="1" y2="0">
                        <stop offset="0%" stop-color="#F5A524"/>
                        <stop offset="100%" stop-color="#FBBF24"/>
                    </linearGradient>
                </defs>
                ${c.illusSvg}
            </svg>
        </div>
    `;
}

function selectCareer(index) {
    activeCareer = index;
    renderCareer();
}

renderCareer();

/* ── FAQ ── */
document.querySelectorAll('.faq-q').forEach(q => {
    q.addEventListener('click', () => {
        const item = q.parentElement;
        const wasOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!wasOpen) item.classList.add('open');
    });
});

/* ── SMOOTH SCROLL + ACTIVE NAV ── */
const navLinks = document.querySelectorAll('.nav-link[data-section]');
const sections = ['hero', 'cara-kerja', 'fitur', 'faq'];

navLinks.forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const targetEl = document.getElementById(link.getAttribute('data-section'));
        if (targetEl) window.scrollTo({ top: targetEl.getBoundingClientRect().top + window.scrollY - 70, behavior: 'smooth' });
    });
});

function setActiveNav(id) {
    navLinks.forEach(l => l.classList.toggle('active', l.getAttribute('data-section') === id));
}

const sectionObs = new IntersectionObserver(entries => {
    entries.forEach(e => { if (e.isIntersecting) setActiveNav(e.target.id); });
}, { rootMargin: '-50% 0px -50% 0px', threshold: 0 });

sections.forEach(id => { const el = document.getElementById(id); if (el) sectionObs.observe(el); });

document.querySelectorAll('a[href^="#"]:not(.nav-link)').forEach(a => {
    a.addEventListener('click', e => {
        const href = a.getAttribute('href');
        if (href === '#') return;
        const target = document.querySelector(href);
        if (target) { e.preventDefault(); window.scrollTo({ top: target.getBoundingClientRect().top + window.scrollY - 70, behavior: 'smooth' }); }
    });
});
</script>
</body>
</html>