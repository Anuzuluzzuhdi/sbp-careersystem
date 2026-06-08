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
        .score-bar-fill { width:0; transition:width 1.2s ease; }
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

            <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-8 py-10 space-y-8 min-w-0">

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
                    @php
                        $top = $searchResults->first();
                        $dummyDetails = [
                            'AI Research Scientist' => ['desc' => 'Meneliti dan mengembangkan model kecerdasan buatan dan algoritma machine learning mutakhir.', 'jobdesk' => 'Mendesain eksperimen AI, menulis paper riset, dan menciptakan algoritma baru.', 'salary' => 'Rp 15.000.000 - Rp 35.000.000'],
                            'AR/VR Developer' => ['desc' => 'Menciptakan pengalaman imersif menggunakan teknologi Augmented Reality dan Virtual Reality.', 'jobdesk' => 'Mengembangkan interaksi 3D, integrasi hardware VR/AR, dan optimasi grafis.', 'salary' => 'Rp 10.000.000 - Rp 25.000.000'],
                            'Automation Test Engineer' => ['desc' => 'Membuat skrip otomatis untuk menguji kualitas dan keamanan perangkat lunak.', 'jobdesk' => 'Menyusun skenario testing, menjalankan automated test, dan melacak bug/error.', 'salary' => 'Rp 8.000.000 - Rp 18.000.000'],
                            'Backend Developer' => ['desc' => 'Membangun dan memelihara logika server, database, dan API.', 'jobdesk' => 'Merancang arsitektur database, membuat RESTful API, dan memastikan keamanan server.', 'salary' => 'Rp 9.000.000 - Rp 25.000.000'],
                            'Blockchain Developer' => ['desc' => 'Membangun arsitektur dan smart contract berbasis teknologi blockchain.', 'jobdesk' => 'Menulis smart contract, mengembangkan dApps, dan memastikan keamanan kriptografi.', 'salary' => 'Rp 15.000.000 - Rp 40.000.000'],
                            'Business Analyst' => ['desc' => 'Menjadi jembatan antara kebutuhan bisnis perusahaan dengan solusi teknologi IT.', 'jobdesk' => 'Menganalisis proses bisnis, membuat requirement document, dan merancang solusi IT.', 'salary' => 'Rp 9.000.000 - Rp 22.000.000'],
                            'Business Intelligence Analyst' => ['desc' => 'Mengubah data mentah perusahaan menjadi insight bisnis yang mudah dipahami.', 'jobdesk' => 'Membuat visualisasi data, menyusun laporan performa, dan memberikan rekomendasi strategis.', 'salary' => 'Rp 10.000.000 - Rp 25.000.000'],
                            'Cloud Engineer' => ['desc' => 'Merancang dan memelihara infrastruktur komputasi awan (AWS, Google Cloud, Azure).', 'jobdesk' => 'Migrasi server lokal ke cloud, manajemen arsitektur cloud, dan optimasi biaya server.', 'salary' => 'Rp 12.000.000 - Rp 28.000.000'],
                            'Computer Vision Engineer' => ['desc' => 'Mengembangkan AI yang memungkinkan komputer mengenali dan memproses gambar/video.', 'jobdesk' => 'Melatih model image recognition, object detection, dan optimasi algoritma visual.', 'salary' => 'Rp 15.000.000 - Rp 30.000.000'],
                            'Cryptographer' => ['desc' => 'Menciptakan sistem enkripsi dan algoritma untuk melindungi data sensitif.', 'jobdesk' => 'Merancang protokol keamanan, enkripsi data, dan mencegah peretasan sistem.', 'salary' => 'Rp 15.000.000 - Rp 35.000.000'],
                            'Cybersecurity Analyst' => ['desc' => 'Melindungi jaringan dan sistem komputer perusahaan dari ancaman siber dan hacker.', 'jobdesk' => 'Monitoring lalu lintas jaringan, investigasi insiden keamanan, dan audit firewall.', 'salary' => 'Rp 10.000.000 - Rp 25.000.000'],
                            'Data Analyst' => ['desc' => 'Mengumpulkan, membersihkan, dan menafsirkan kumpulan data untuk menjawab pertanyaan bisnis.', 'jobdesk' => 'Eksplorasi data, membuat query SQL, dan menyajikan insight melalui visualisasi.', 'salary' => 'Rp 8.000.000 - Rp 20.000.000'],
                            'Data Engineer' => ['desc' => 'Membangun infrastruktur agar data dapat mengalir lancar dari sumber ke database.', 'jobdesk' => 'Merancang arsitektur ETL, merawat data warehouse, dan optimasi query.', 'salary' => 'Rp 12.000.000 - Rp 28.000.000'],
                            'Data Entry Operator' => ['desc' => 'Memasukkan, memperbarui, dan memelihara informasi di dalam sistem database perusahaan.', 'jobdesk' => 'Input data pelanggan/transaksi, verifikasi akurasi data, dan manajemen arsip digital.', 'salary' => 'Rp 4.500.000 - Rp 7.000.000'],
                            'Data Scientist' => ['desc' => 'Mengekstraksi makna dari data yang sangat besar menggunakan statistik dan machine learning.', 'jobdesk' => 'Membangun model prediktif, analisis statistik mendalam, dan memberikan insight prediktif.', 'salary' => 'Rp 12.000.000 - Rp 30.000.000'],
                            'Database Administrator (DBA)' => ['desc' => 'Memastikan database perusahaan berjalan cepat, aman, dan data tidak hilang.', 'jobdesk' => 'Backup data rutin, optimasi performa database, dan mengatur hak akses pengguna.', 'salary' => 'Rp 9.000.000 - Rp 22.000.000'],
                            'DevOps Engineer' => ['desc' => 'Menjembatani tim developer dan operasional agar rilis aplikasi lebih cepat dan otomatis.', 'jobdesk' => 'Membangun pipeline CI/CD, manajemen server otomatis, dan monitoring sistem.', 'salary' => 'Rp 12.000.000 - Rp 30.000.000'],
                            'Embedded Systems Engineer' => ['desc' => 'Menulis software yang ditanamkan langsung pada perangkat keras.', 'jobdesk' => 'Pemrograman C/C++, desain firmware, dan integrasi sensor dengan hardware.', 'salary' => 'Rp 10.000.000 - Rp 25.000.000'],
                            'Enterprise Architect' => ['desc' => 'Merancang arsitektur IT secara menyeluruh untuk mendukung visi strategis perusahaan besar.', 'jobdesk' => 'Menyusun standar teknologi, mengawasi integrasi sistem kompleks, dan tata kelola IT.', 'salary' => 'Rp 25.000.000 - Rp 50.000.000'],
                            'Firmware Engineer' => ['desc' => 'Membuat perangkat lunak tingkat rendah yang mengontrol perangkat keras elektronik.', 'jobdesk' => 'Menulis kode untuk chip memori, debugging hardware, dan optimasi daya perangkat.', 'salary' => 'Rp 10.000.000 - Rp 25.000.000'],
                            'Frontend Developer' => ['desc' => 'Membangun antarmuka pengguna aplikasi web agar interaktif dan menarik secara visual.', 'jobdesk' => 'Slicing UI dari Figma ke kode, integrasi dengan API, dan optimasi web.', 'salary' => 'Rp 8.000.000 - Rp 22.000.000'],
                            'Full Stack Developer' => ['desc' => 'Menguasai pengembangan aplikasi web secara utuh, baik sisi Frontend maupun Backend.', 'jobdesk' => 'Membangun API, merancang UI/UX, dan mengelola database sekaligus.', 'salary' => 'Rp 10.000.000 - Rp 28.000.000'],
                            'Game Developer' => ['desc' => 'Menciptakan dan memprogram video game untuk berbagai platform.', 'jobdesk' => 'Membuat logika permainan, pergerakan karakter, dan integrasi aset visual/audio.', 'salary' => 'Rp 7.000.000 - Rp 25.000.000'],
                            'Infrastructure Engineer' => ['desc' => 'Membangun dan memelihara kerangka kerja server dan jaringan.', 'jobdesk' => 'Konfigurasi server fisik/virtual, load balancing, dan penanganan disaster recovery.', 'salary' => 'Rp 10.000.000 - Rp 24.000.000'],
                            'IoT Engineer' => ['desc' => 'Mengembangkan perangkat pintar yang saling terhubung melalui internet.', 'jobdesk' => 'Menghubungkan sensor ke cloud, pemrograman mikrokontroler, dan pengolahan data IoT.', 'salary' => 'Rp 10.000.000 - Rp 25.000.000'],
                            'IT Consultant' => ['desc' => 'Memberikan saran profesional kepada perusahaan tentang cara menggunakan teknologi.', 'jobdesk' => 'Audit sistem IT klien, memberikan solusi strategis, dan memimpin transformasi digital.', 'salary' => 'Rp 10.000.000 - Rp 35.000.000'],
                            'IT Project Manager' => ['desc' => 'Memimpin dan memastikan kelancaran proyek teknologi dari awal hingga rilis.', 'jobdesk' => 'Mengelola tim IT, menyusun timeline, mengawasi budget, dan komunikasi dengan klien.', 'salary' => 'Rp 12.000.000 - Rp 30.000.000'],
                            'IT Support / Help Desk' => ['desc' => 'Memberikan bantuan teknis harian terkait masalah komputer, jaringan, atau software.', 'jobdesk' => 'Troubleshooting laptop karyawan, instalasi OS/software, dan reset password/akses.', 'salary' => 'Rp 5.000.000 - Rp 10.000.000'],
                            'Machine Learning Engineer' => ['desc' => 'Mendeploy model machine learning dari lingkungan riset ke sistem produksi.', 'jobdesk' => 'Menulis production code, optimasi model ML, dan membuat API untuk model AI.', 'salary' => 'Rp 15.000.000 - Rp 35.000.000'],
                            'ML Engineer' => ['desc' => 'Mendeploy model machine learning dari lingkungan riset ke sistem produksi.', 'jobdesk' => 'Menulis production code, optimasi model ML, dan membuat API untuk model AI.', 'salary' => 'Rp 15.000.000 - Rp 35.000.000'],
                            'Mobile Developer (iOS / Android)' => ['desc' => 'Membangun aplikasi mobile untuk platform iOS atau Android.', 'jobdesk' => 'Membuat UI aplikasi mobile, integrasi API, dan memastikan performa aplikasi lancar.', 'salary' => 'Rp 9.000.000 - Rp 25.000.000'],
                            'Network Engineer' => ['desc' => 'Merancang, membangun, dan memelihara jaringan komunikasi data perusahaan.', 'jobdesk' => 'Konfigurasi router/switch, pasang kabel jaringan, dan memastikan internet stabil.', 'salary' => 'Rp 7.000.000 - Rp 18.000.000'],
                            'NLP Engineer' => ['desc' => 'Mengembangkan AI yang mampu memahami dan memproses bahasa manusia.', 'jobdesk' => 'Membangun chatbot cerdas, analisis sentimen teks, dan pemrosesan data linguistik.', 'salary' => 'Rp 15.000.000 - Rp 35.000.000'],
                            'Penetration Tester (Ethical Hacker)' => ['desc' => 'Secara legal meretas sistem perusahaan untuk menemukan celah keamanan.', 'jobdesk' => 'Simulasi serangan siber, mencari vulnerability, dan membuat laporan celah sistem.', 'salary' => 'Rp 12.000.000 - Rp 30.000.000'],
                            'Platform Engineer' => ['desc' => 'Membangun internal tools dan platform agar tim developer bisa bekerja lebih mandiri.', 'jobdesk' => 'Membangun portal self-service, standarisasi infrastruktur, dan otomatisasi workflow.', 'salary' => 'Rp 15.000.000 - Rp 35.000.000'],
                            'Product Designer' => ['desc' => 'Merancang pengalaman keseluruhan sebuah produk dari riset user hingga desain akhir.', 'jobdesk' => 'Riset pengguna, membuat wireframe, prototipe interaktif, dan visual design.', 'salary' => 'Rp 9.000.000 - Rp 25.000.000'],
                            'Product Manager' => ['desc' => 'Menentukan arah dan fitur produk digital yang harus dibuat.', 'jobdesk' => 'Riset pasar, menyusun backlog prioritas fitur, dan mengkoordinir tim developer & desain.', 'salary' => 'Rp 12.000.000 - Rp 35.000.000'],
                            'QA Engineer / Software Tester' => ['desc' => 'Menjaga standar kualitas aplikasi dengan melakukan uji coba sistematis sebelum rilis.', 'jobdesk' => 'Membuat test case, mencari celah/bug manual, dan memastikan aplikasi bebas error.', 'salary' => 'Rp 7.000.000 - Rp 18.000.000'],
                            'Research Scientist' => ['desc' => 'Melakukan penelitian inovatif untuk memecahkan masalah komputasi yang sangat kompleks.', 'jobdesk' => 'Riset fundamental, menciptakan teknologi baru, dan publikasi jurnal akademik.', 'salary' => 'Rp 15.000.000 - Rp 35.000.000'],
                            'Scrum Master / Agile Coach' => ['desc' => 'Fasilitator yang memastikan tim IT bekerja efisien menggunakan metode Agile/Scrum.', 'jobdesk' => 'Memimpin meeting harian, menghilangkan hambatan tim, dan memantau sprint.', 'salary' => 'Rp 10.000.000 - Rp 25.000.000'],
                            'Security Engineer' => ['desc' => 'Merancang dan membangun sistem keamanan yang kokoh untuk melindungi data dan jaringan.', 'jobdesk' => 'Implementasi sistem kriptografi, manajemen kerentanan, dan merespons insiden peretasan.', 'salary' => 'Rp 12.000.000 - Rp 28.000.000'],
                            'Site Reliability Engineer (SRE)' => ['desc' => 'Menerapkan pola pikir software engineer ke masalah operasional agar sistem tidak pernah down.', 'jobdesk' => 'Mengelola skalabilitas server, otomatisasi infrastruktur, dan merespons kegagalan sistem.', 'salary' => 'Rp 15.000.000 - Rp 35.000.000'],
                            'SOC Analyst' => ['desc' => 'Menjadi garda terdepan di Security Operations Center untuk memantau ancaman siber 24/7.', 'jobdesk' => 'Menganalisis log sistem, mendeteksi aktivitas mencurigakan, dan eskalasi insiden ancaman.', 'salary' => 'Rp 8.000.000 - Rp 20.000.000'],
                            'Software Engineer' => ['desc' => 'Menerapkan prinsip rekayasa perangkat lunak untuk merancang dan memelihara sistem kompleks.', 'jobdesk' => 'Menulis kode berkualitas, arsitektur sistem, dan memastikan aplikasi scalable.', 'salary' => 'Rp 9.000.000 - Rp 25.000.000'],
                            'Software Engineer / Developer' => ['desc' => 'Menerapkan prinsip rekayasa perangkat lunak untuk merancang dan memelihara sistem kompleks.', 'jobdesk' => 'Menulis kode berkualitas, arsitektur sistem, dan memastikan aplikasi scalable.', 'salary' => 'Rp 9.000.000 - Rp 25.000.000'],
                            'Solutions Architect' => ['desc' => 'Menerjemahkan masalah bisnis yang rumit menjadi desain arsitektur teknis yang komprehensif.', 'jobdesk' => 'Memilih teknologi yang tepat, merancang blue-print arsitektur, dan presentasi ke klien.', 'salary' => 'Rp 20.000.000 - Rp 45.000.000'],
                            'System Administrator' => ['desc' => 'Mengelola, memelihara, dan mengoperasikan sistem komputer dan jaringan internal perusahaan.', 'jobdesk' => 'Setup akun karyawan, merawat server internal, dan melakukan backup sistem rutin.', 'salary' => 'Rp 7.000.000 - Rp 15.000.000'],
                            'Technical Support Specialist' => ['desc' => 'Pakar teknis spesifik yang menyelesaikan masalah kompleks.', 'jobdesk' => 'Investigasi error sistem mendalam, panduan teknis ke user, dan kolaborasi dengan developer.', 'salary' => 'Rp 6.000.000 - Rp 12.000.000'],
                            'Technical Writer' => ['desc' => 'Mengubah informasi teknis yang sangat rumit menjadi dokumentasi yang mudah dipahami.', 'jobdesk' => 'Menulis panduan penggunaan aplikasi, dokumentasi API untuk developer, dan help-center.', 'salary' => 'Rp 7.000.000 - Rp 15.000.000'],
                            'UI/UX Designer' => ['desc' => 'Merancang alur pengguna yang intuitif (UX) dan antarmuka visual yang estetik (UI).', 'jobdesk' => 'Membuat user journey, merancang wireframe/prototipe interaktif di Figma, dan riset desain.', 'salary' => 'Rp 8.000.000 - Rp 20.000.000'],
                        ];
                        $defaultDetail = ['desc' => 'Menganalisis, mengembangkan, dan memelihara sistem teknologi informasi perusahaan.', 'jobdesk' => 'Menyelesaikan permasalahan teknis dan berkolaborasi dengan tim lintas divisi.', 'salary' => 'Rp 8.000.000 - Rp 15.000.000'];
                        $topDetail = $dummyDetails[$top->career_name] ?? $defaultDetail;
                    @endphp

                    {{-- Top result highlight --}}
                    <div class="relative bg-gradient-to-br from-[#1A2B6B] to-[#0D1B4B] rounded-3xl p-6 md:p-8 text-white overflow-hidden shadow-lg">
                        <div class="absolute top-0 right-0 w-48 h-48 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
                        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/3 pointer-events-none"></div>
                        <div class="relative z-10 flex flex-col md:flex-row md:items-start md:justify-between gap-6">
                            <div class="flex-1">
                                <div class="inline-flex items-center gap-1.5 bg-[#F5A524]/20 text-[#F5A524] text-[0.72rem] font-bold uppercase tracking-wider px-3 py-1 rounded-full border border-[#F5A524]/30 mb-4">
                                    🏆 Rekomendasi Utama
                                </div>
                                <h3 class="text-3xl font-extrabold mb-2">{{ $top->career_name }}</h3>
                                <p class="text-white/80 text-sm mb-6 leading-relaxed">{{ $topDetail['desc'] }}</p>
                                <details class="group/topdetail">
                                    <summary class="inline-flex items-center gap-2 text-sm font-bold text-white/80 cursor-pointer list-none hover:text-[#F5A524] transition-colors bg-white/10 px-4 py-2 rounded-xl border border-white/20">
                                        <span>Lihat Detail Karir</span>
                                        <svg class="w-4 h-4 transform group-open/topdetail:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </summary>
                                    <div class="mt-4 space-y-4 text-sm text-white/90 bg-white/5 backdrop-blur-sm p-5 rounded-2xl border border-white/10">
                                        <div>
                                            <div class="font-bold text-[#F5A524] flex items-center gap-2"><span class="text-lg">🎯</span> Jobdesk Utama:</div>
                                            <p class="mt-1 leading-relaxed pl-7">{{ $topDetail['jobdesk'] }}</p>
                                        </div>
                                        <div>
                                            <div class="font-bold text-[#F5A524] flex items-center gap-2"><span class="text-lg">💰</span> Estimasi Gaji:</div>
                                            <p class="mt-1 font-bold text-emerald-400 pl-7">{{ $topDetail['salary'] }}</p>
                                        </div>
                                    </div>
                                </details>
                            </div>
                            <div class="shrink-0 bg-white/10 backdrop-blur rounded-2xl px-8 py-5 text-center border border-white/20 self-start md:self-center mt-4 md:mt-0">
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
                    @if(isset($histories) && $histories->count() > 0)
                        <div class="rounded-2xl border border-blue-200 bg-[#EEF1FB] p-6 flex flex-col sm:flex-row items-center gap-4 shadow-sm">
                            <div class="w-12 h-12 shrink-0 bg-white rounded-full flex items-center justify-center text-xl shadow-sm border border-blue-100">💡</div>
                            <div>
                                <p class="font-bold text-[#1A2B6B] text-lg">Siap untuk analisis baru?</p>
                                <p class="text-sm text-[#374151] mt-1">Kamu belum menjalankan analisis di sesi ini. Klik tombol <b>"Ubah Pencarian"</b> di pojok kanan atas untuk memasukkan skill baru, atau lihat riwayat analisismu di bawah.</p>
                            </div>
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
                @endif

                {{-- Riwayat Analisis --}}
                @if(isset($histories) && $histories->count() > 0)
                    <div class="pt-8 mt-8 border-t border-[#E5E7EB]">
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-8 h-8 rounded-full bg-[#EEF1FB] flex items-center justify-center text-[#1A2B6B]">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-extrabold text-[#111827]">Riwayat Analisis Kamu</h3>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($histories as $history)
                                @php
                                    $topHistory = $history->results[0] ?? null;
                                    $hCriteria = $history->criteria ?? [];
                                @endphp
                                <div class="bg-white rounded-2xl border border-[#E5E7EB] p-5 shadow-sm hover:border-[#C7D0EE] hover:shadow-md transition group relative overflow-hidden flex flex-col">
                                    <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-[#F5F7FA] to-[#EEF1FB] rounded-bl-full pointer-events-none -z-10 group-hover:scale-110 transition-transform"></div>
                                    <div class="text-xs font-bold text-[#6B7280] mb-3">
                                        {{ $history->created_at->format('d M Y • H:i') }}
                                    </div>
                                    @if($topHistory)
                                        <div class="text-xs text-[#6B7280] mb-1">Rekomendasi Tertinggi:</div>
                                        <h4 class="font-extrabold text-[#111827] text-base truncate">{{ $topHistory['career_name'] }}</h4>
                                        <div class="mt-2 mb-4 flex items-center gap-2">
                                            <div class="flex-1 h-1.5 bg-[#F5F7FA] rounded-full overflow-hidden">
                                                <div class="h-full rounded-full {{ $topHistory['score'] >= 80 ? 'bg-emerald-500' : 'bg-[#1A2B6B]' }}" style="width: {{ $topHistory['score'] }}%"></div>
                                            </div>
                                            <span class="text-xs font-extrabold {{ $topHistory['score'] >= 80 ? 'text-emerald-600' : 'text-[#1A2B6B]' }}">
                                                {{ number_format($topHistory['score'], 1) }}%
                                            </span>
                                        </div>
                                    @else
                                        <div class="text-sm text-[#6B7280] italic mt-2 mb-4">Tidak ada hasil kecocokan</div>
                                    @endif
                                    <div class="mt-auto pt-3 border-t border-gray-100">
                                        <p class="text-[10px] font-bold text-[#6B7280] uppercase tracking-wider mb-2">Kriteria:</p>
                                        <div class="flex flex-wrap gap-1.5">
                                            @if (!empty($hCriteria['education_id']))
                                                @php $edu = collect($educations)->firstWhere('education_id', $hCriteria['education_id']); @endphp
                                                @if ($edu)
                                                    <span class="inline-flex items-center bg-[#EEF1FB] text-[#1A2B6B] border border-[#C7D0EE] text-[10px] font-bold px-2 py-0.5 rounded-md">
                                                        🎓 {{ $edu->education_level }}
                                                    </span>
                                                @endif
                                            @endif
                                            @foreach (($hCriteria['skill_ids'] ?? []) as $sid)
                                                @php $sk = collect($skills)->firstWhere('skill_id', $sid); @endphp
                                                @if ($sk)
                                                    <span class="inline-flex items-center bg-orange-50 text-orange-700 border border-orange-200 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                                        ⚡ {{ $sk->skill_name }}
                                                    </span>
                                                @endif
                                            @endforeach
                                            @foreach (($hCriteria['specialization_ids'] ?? []) as $spid)
                                                @php $sp = collect($specializations)->firstWhere('specialization_id', $spid); @endphp
                                                @if ($sp)
                                                    <span class="inline-flex items-center bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                                        🎯 {{ $sp->specialization_name }}
                                                    </span>
                                                @endif
                                            @endforeach
                                            @if (!empty($hCriteria['certification_id']))
                                                @php $cert = collect($certifications)->firstWhere('certification_id', $hCriteria['certification_id']); @endphp
                                                @if ($cert)
                                                    <span class="inline-flex items-center bg-purple-50 text-purple-700 border border-purple-200 text-[10px] font-bold px-2 py-0.5 rounded-md">
                                                        📜 {{ $cert->certification_name }}
                                                    </span>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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

        // ===== SCORE BAR ANIMATION =====
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