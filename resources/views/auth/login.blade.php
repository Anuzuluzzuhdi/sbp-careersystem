<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — {{ config('app.name', 'SIREKA') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --blue: #1A2B6B; --blue-dark: #0D1B4B; --blue-light: #EEF1FB;
            --blue-mid: #C7D0EE; --ink: #111827; --body: #374151; --muted: #6B7280;
            --border: #E5E7EB; --bg: #F5F7FA; --white: #FFFFFF;
            --orange: #F5A524; --orange-dark: #D98D0F;
        }

        html, body { height: 100%; }

        body {
            background: var(--bg);
            color: var(--ink);
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            font-size: 15px; line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ─── LAYOUT ─── */
        .auth-page {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
        }

        /* ─── LEFT PANEL ─── */
        .left-panel {
            background: var(--blue-dark); padding: 3rem;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute; top: -80px; right: -80px;
            width: 320px; height: 320px; border-radius: 50%;
            background: rgba(255,255,255,0.03); pointer-events: none;
        }
        .left-panel::after {
            content: ''; position: absolute; bottom: -60px; left: -60px;
            width: 240px; height: 240px; border-radius: 50%;
            background: rgba(255,255,255,0.03); pointer-events: none;
        }

        .brand { display: flex; align-items: center; gap: 0.6rem; text-decoration: none; }
        .brand-logo {
            width: 40px;
            height: 35px;
            border-radius: 5px;
            overflow: hidden;        /* gambar terpotong rapi sesuai border-radius */
            flex-shrink: 0;
        }
        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;       /* ganti ke 'contain' kalau logo punya padding/whitespace */
            display: block;
        }
        .brand-text { font-size: 1rem; font-weight: 700; color: white; letter-spacing: -0.01em; }
        .brand-text span { color: var(--orange); }

        .left-body { flex: 1; display: flex; flex-direction: column; justify-content: center; padding: 2rem 0; }

        .left-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(255,255,255,0.08); color: rgba(255,255,255,0.7);
            font-size: 0.72rem; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase;
            padding: 0.3rem 0.8rem; border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.12);
            margin-bottom: 1.2rem; width: fit-content;
        }

        .left-title {
            font-size: 1.75rem; font-weight: 800; line-height: 1.2;
            letter-spacing: -0.03em; color: white; margin-bottom: 1rem;
        }
        .left-title span { color: var(--orange); }

        .left-desc { font-size: 0.85rem; color: rgba(255,255,255,0.55); line-height: 1.75; margin-bottom: 2rem; }

        .feature-list { display: flex; flex-direction: column; gap: 0.6rem; }
        .feature-row { display: flex; align-items: center; gap: 0.6rem; font-size: 0.82rem; color: rgba(255,255,255,0.65); }
        .feat-check {
            width: 18px; height: 18px; background: var(--orange); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0; font-size: 0.6rem; color: white; font-weight: 700;
        }

        .left-footer { font-size: 0.72rem; color: rgba(255,255,255,0.25); }

        /* ─── RIGHT PANEL ─── */
        .right-panel {
            background: white;
            display: flex; align-items: center; justify-content: center;
            padding: 2.5rem 3rem;
        }

        .form-box { width: 100%; max-width: 380px; }

        .form-header { margin-bottom: 2rem; }
        .form-eyebrow {
            font-size: 0.72rem; font-weight: 600; letter-spacing: 0.08em;
            text-transform: uppercase; color: var(--blue); margin-bottom: 0.4rem;
        }
        .form-title { font-size: 1.5rem; font-weight: 800; letter-spacing: -0.025em; color: var(--ink); margin-bottom: 0.4rem; }
        .form-sub { font-size: 0.82rem; color: var(--muted); }
        .form-sub a { color: var(--blue); font-weight: 600; text-decoration: none; }
        .form-sub a:hover { text-decoration: underline; }

        /* ─── STATUS ─── */
        .status-msg {
            background: var(--blue-light); color: var(--blue);
            border: 1px solid var(--blue-mid); border-radius: 8px;
            padding: 0.6rem 0.9rem; font-size: 0.8rem; font-weight: 500;
            margin-bottom: 1.25rem;
        }

        /* ─── FIELDS ─── */
        .field-group { display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.25rem; }
        .field { display: flex; flex-direction: column; gap: 0.35rem; }
        .field label { font-size: 0.8rem; font-weight: 600; color: var(--ink); }

        .field input {
            width: 100%; padding: 0.65rem 0.9rem;
            border: 1px solid var(--border); border-radius: 8px;
            font-size: 0.85rem; color: var(--ink);
            font-family: inherit; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
            background: white;
        }
        .field input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(26,43,107,0.08); }
        .field input::placeholder { color: var(--muted); }
        .field input.is-invalid { border-color: #DC2626; }
        .field input.is-invalid:focus { box-shadow: 0 0 0 3px rgba(220,38,38,0.08); }

        .error-msg { font-size: 0.73rem; color: #DC2626; margin-top: 0.2rem; }

        /* ─── REMEMBER + FORGOT ─── */
        .field-footer {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 1.5rem;
        }
        .remember { display: flex; align-items: center; gap: 0.45rem; font-size: 0.8rem; color: var(--body); cursor: pointer; }
        .remember input[type="checkbox"] { width: 15px; height: 15px; accent-color: var(--blue); cursor: pointer; }
        .forgot-link { font-size: 0.8rem; color: var(--blue); font-weight: 600; text-decoration: none; }
        .forgot-link:hover { text-decoration: underline; }

        /* ─── BUTTON ─── */
        .btn-login {
            width: 100%; padding: 0.75rem 1.5rem;
            background: var(--orange); color: white;
            font-size: 0.88rem; font-weight: 700; font-family: inherit;
            border: none; border-radius: 8px; cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 0.4rem;
        }
        .btn-login:hover { background: var(--orange-dark); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(245,165,36,0.35); }

        .divider { display: flex; align-items: center; gap: 0.75rem; margin: 1.25rem 0; }
        .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }
        .divider span { font-size: 0.73rem; color: var(--muted); white-space: nowrap; }

        .register-link { text-align: center; font-size: 0.82rem; color: var(--muted); }
        .register-link a { color: var(--blue); font-weight: 600; text-decoration: none; }
        .register-link a:hover { text-decoration: underline; }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            .auth-page { grid-template-columns: 1fr; }
            .left-panel { display: none; }
            .right-panel { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="auth-page">

    {{-- ─── LEFT PANEL ─── --}}
    <div class="left-panel">
        <a href="/" class="brand">
            <div class="brand-logo">
                <img src="{{ asset('images/logo4.png') }}" alt="SIREKA Logo">
            </div>
            <div class="brand-text">SI<span>REKA</span></div>
        </a>

        <div class="left-body">
            <div class="left-badge">✦ Sistem Rekomendasi Karir</div>
            <h1 class="left-title">
                Selamat Datang<br>
                <span>Kembali!</span>
            </h1>
            <p class="left-desc">
                Masuk dan lanjutkan eksplorasi karir IT terbaikmu bersama SIREKA.
            </p>
            <div class="feature-list">
                <div class="feature-row">
                    <div class="feat-check">✓</div>
                    <span>Lihat rekomendasi karir terbaru</span>
                </div>
                <div class="feature-row">
                    <div class="feat-check">✓</div>
                    <span>Update profil & skill kapan saja</span>
                </div>
                <div class="feature-row">
                    <div class="feat-check">✓</div>
                    <span>Pantau perkembangan kompetensimu</span>
                </div>
            </div>
        </div>

        <div class="left-footer">© {{ date('Y') }} SIREKA · JTI</div>
    </div>

    {{-- ─── RIGHT PANEL ─── --}}
    <div class="right-panel">
        <div class="form-box">
            <div class="form-header">
                <div class="form-eyebrow">Masuk Akun</div>
                <h2 class="form-title">Login ke SIREKA</h2>
                @if (Route::has('register'))
                    <p class="form-sub">
                        Belum punya akun?
                        <a href="{{ route('register') }}">Daftar sekarang</a>
                    </p>
                @endif
            </div>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="status-msg">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="field-group">

                    {{-- Email --}}
                    <div class="field">
                        <label for="email">Alamat Email</label>
                        <input
                            id="email" type="email" name="email"
                            value="{{ old('email') }}"
                            placeholder="nama@email.com"
                            class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                            required autofocus autocomplete="username"
                        />
                        @error('email')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="field">
                        <label for="password">Password</label>
                        <input
                            id="password" type="password" name="password"
                            placeholder="Masukkan password"
                            class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
                            required autocomplete="current-password"
                        />
                        @error('password')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Remember Me + Forgot Password --}}
                <div class="field-footer">
                    <label class="remember">
                        <input type="checkbox" name="remember" id="remember_me">
                        Ingat saya
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Lupa password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-login">
                    Masuk Sekarang
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <path d="M2 7h10M7.5 3.5l4 3.5-4 3.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                <div class="divider"><span>atau</span></div>

                <div class="register-link">
                    Belum terdaftar?
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Buat akun</a>
                    @endif
                </div>

            </form>
        </div>
    </div>

</div>

</body>
</html>