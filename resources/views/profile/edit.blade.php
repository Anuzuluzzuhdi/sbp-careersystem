<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="sireka-header text-xl leading-tight">
                {{ __('Pengaturan Akun') }}
            </h2>
            
            <a href="{{ route('dashboard') }}" class="sireka-btn-back">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* ─── SIREKA DESIGN SYSTEM OVERRIDE ─── */
        .sireka-profile-page {
            --blue: #1A2B6B; --blue-dark: #0D1B4B;
            --ink: #111827; --muted: #6B7280;
            --border: #E5E7EB; --bg: #F5F7FA;
            --orange: #F5A524; --orange-dark: #D98D0F;

            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            background-color: var(--bg);
            min-height: calc(100vh - 65px); 
            padding-bottom: 4rem;
        }

        .sireka-header {
            font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif;
            color: #111827;
            font-weight: 800;
        }

        /* Tombol Back */
        .sireka-btn-back {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: white;
            color: var(--blue);
            font-size: 0.85rem;
            font-weight: 700;
            border: 1px solid var(--border);
            border-radius: 8px;
            transition: all 0.2s;
            text-decoration: none;
        }
        .sireka-btn-back:hover {
            background: var(--bg);
            border-color: var(--blue-mid);
            transform: translateX(-2px);
        }

        /* Banner Profil */
        .sireka-banner {
            background: var(--blue-dark);
            border-radius: 12px;
            padding: 2.5rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(13, 27, 75, 0.1);
        }
        .sireka-banner::after {
            content: '';
            position: absolute; top: -50px; right: -20px;
            width: 200px; height: 200px; border-radius: 50%;
            background: rgba(255,255,255,0.04); pointer-events: none;
        }
        .sireka-banner-badge {
            display: inline-flex; align-items: center; gap: 0.4rem;
            background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.8);
            font-size: 0.72rem; font-weight: 600; letter-spacing: 0.04em; text-transform: uppercase;
            padding: 0.3rem 0.8rem; border-radius: 2rem;
            border: 1px solid rgba(255,255,255,0.15);
            margin-bottom: 1rem;
        }
        .sireka-banner-title {
            font-size: 1.5rem; font-weight: 800; line-height: 1.2;
            letter-spacing: -0.02em;
        }
        .sireka-banner-title span { color: var(--orange); }
        .sireka-banner-desc {
            font-size: 0.85rem; color: rgba(255,255,255,0.6);
            margin-top: 0.5rem; max-width: 500px;
        }

        /* Style Card / Kotak Form */
        .sireka-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--border);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            position: relative;
            z-index: 10;
        }

        /* Typography Form */
        .sireka-card header h2 {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: var(--ink) !important;
            letter-spacing: -0.025em;
        }
        .sireka-card header p {
            font-size: 0.85rem !important;
            color: var(--muted) !important;
            margin-top: 0.3rem !important;
        }
        .sireka-card label {
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            color: var(--ink) !important;
        }

        /* Style Input Form */
        .sireka-card input[type="text"],
        .sireka-card input[type="email"],
        .sireka-card input[type="password"] {
            width: 100% !important;
            padding: 0.65rem 0.9rem !important;
            border: 1px solid var(--border) !important;
            border-radius: 8px !important;
            font-size: 0.85rem !important;
            color: var(--ink) !important;
            font-family: inherit !important;
            box-shadow: none !important;
            transition: border-color 0.15s, box-shadow 0.15s !important;
        }
        .sireka-card input:focus {
            border-color: var(--blue) !important;
            box-shadow: 0 0 0 3px rgba(26,43,107,0.08) !important;
            outline: none !important;
        }

        /* Tombol Simpan (Oranye) */
        .sireka-card button[type="submit"]:not(.bg-red-600),
        .sireka-card .bg-gray-800 {
            padding: 0.75rem 1.5rem !important;
            background: var(--orange) !important;
            color: white !important;
            font-size: 0.88rem !important;
            font-weight: 700 !important;
            border: none !important;
            border-radius: 8px !important;
            transition: all 0.2s !important;
            text-transform: none !important;
            letter-spacing: normal !important;
            box-shadow: none !important;
        }
        .sireka-card button[type="submit"]:not(.bg-red-600):hover,
        .sireka-card .bg-gray-800:hover {
            background: var(--orange-dark) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245,165,36,0.35) !important;
        }

        /* Tombol Delete (Merah) */
        .sireka-card button.bg-red-600 {
            border-radius: 8px !important;
            text-transform: none !important;
            font-weight: 700 !important;
        }
    </style>

    <div class="sireka-profile-page pt-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="sireka-banner mb-8">
                <div class="sireka-banner-badge">✦ PENGATURAN</div>
                <h1 class="sireka-banner-title">
                    Pusat Keamanan <span>& Privasi</span>
                </h1>
                <p class="sireka-banner-desc">
                    Kelola semua pengaturan akun SIREKA kamu di satu tempat. Sesuaikan data diri, perbarui kata sandi, dan atur privasi akunmu di bawah ini.
                </p>
            </div>

            <div class="space-y-6">
                <div class="p-6 sm:p-8 sireka-card">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-6 sm:p-8 sireka-card">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-6 sm:p-8 sireka-card">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>