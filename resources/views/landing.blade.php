<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem OneSubmit - Universitas Riau</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/unri.png') }}" alt="Universitas Riau Logo" class="h-12">
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Sistem OneSubmit</h1>
                        <p class="text-sm text-gray-600">Universitas Riau</p>
                    </div>
                </div>
                <div class="flex space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-300">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-sky-400 via-sky-500 to-sky-600 text-white py-16 overflow-hidden">
        <!-- Background Image -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/hero-bg.jpg') }}');"></div>

        <!-- Background Image Overlay -->
        <div class="absolute inset-0 bg-black/30"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-sky-500/80 via-sky-600/60 to-sky-700/80"></div>

        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute inset-0" style="background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.15) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(255,255,255,0.1) 0%, transparent 50%);"></div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute top-10 left-10 w-16 h-16 bg-white/15 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute bottom-10 right-10 w-24 h-24 bg-white/10 rounded-full blur-2xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/4 w-12 h-12 bg-white/20 rounded-full blur-lg animate-pulse delay-500"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Main Title -->
            <div class="mb-6">
                <h1 class="text-4xl md:text-6xl font-extrabold mb-3 bg-gradient-to-r from-white via-blue-100 to-purple-100 bg-clip-text text-transparent leading-tight">
                    OneSubmit
                </h1>
                <div class="w-24 h-1 bg-gradient-to-r from-blue-300 via-purple-300 to-indigo-300 mx-auto rounded-full mb-4"></div>
            </div>

            <!-- Subtitle -->
            <h2 class="text-xl md:text-3xl font-light mb-3 text-blue-100 leading-relaxed">
                Platform Pengajuan dan Verifikasi
            </h2>
            <h3 class="text-lg md:text-2xl font-semibold mb-6 text-white leading-relaxed">
                Proposal Skripsi
            </h3>

            <!-- Description -->
            <p class="text-base md:text-lg text-blue-100 mb-8 max-w-2xl mx-auto leading-relaxed">
                Sistem terintegrasi untuk mahasiswa Prodi Sistem Informasi, Universitas Riau dalam mengelola dan memverifikasi proposal skripsi dengan mudah dan efisien.
            </p>

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-3xl mx-auto">
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-white mb-1">300+</div>
                    <div class="text-blue-200 text-xs md:text-sm">Proposal Terverifikasi</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-white mb-1">400+</div>
                    <div class="text-blue-200 text-xs md:text-sm">Mahasiswa Aktif</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold text-white mb-1">24/7</div>
                    <div class="text-blue-200 text-xs md:text-sm">Akses Sistem</div>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 animate-bounce">
            <svg class="w-5 h-5 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
    </section>

    <!-- Program Information -->
    <section id="program-info" class="py-20 bg-gradient-to-br from-blue-50 to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-900 mb-4">S1 - SISTEM INFORMASI</h3>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Program Description -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-900 ml-4">Tentang Program</h4>
                    </div>
                    <p class="text-gray-700 leading-relaxed">
                        Prodi Sistem Informasi di Universitas Riau (UNRI) adalah bagian dari Jurusan Ilmu Komputer di Fakultas Matematika dan Ilmu Pengetahuan Alam (FMIPA). Program studi ini memiliki fokus pada perancangan, pengelolaan, dan pengembangan sistem informasi berbasis digital dalam suatu organisasi.
                    </p>
                </div>

                <!-- PPM -->
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <div class="flex items-center mb-6">
                        <div class="bg-purple-100 p-3 rounded-lg">
                            <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-semibold text-gray-900 ml-4">PPM</h4>
                    </div>
                    <p class="text-gray-700 leading-relaxed text-sm">
                        <strong>Profil Profesional Mandiri Program (PPM)</strong> Studi S1 Sistem Informasi Universitas Riau adalah Lulusan Sistem Informasi masa depan yang mampu memahami, menganalisis, merancang, mengimplementasikan, dan mengevaluasi sistem informasi dalam pengelolaan data dan pengembangan solusi organisasi, merancang dan mengelola basis data, memproses dan menganalisis data dengan berbagai teknik, menggunakan metodologi pengembangan sistem, merencanakan infrastruktur TI dan layanan cloud, melindungi akses dan data, menerapkan kode etik berbasis budaya ASRI (Amanah, Santun, Responsif, Inovatif), mengelola proyek sistem informasi, beradaptasi dengan perkembangan teknologi, berkomunikasi dan berkolaborasi secara efektif dalam tim, serta mampu merancang dan mengembangkan aplikasi/sistem informasi untuk mendukung visi dan misi organisasi secara strategis.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Vision & Mission -->
    <section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h3 class="text-4xl font-bold text-gray-900 mb-4">VISI DAN MISI</h3>
                <div class="w-24 h-1 bg-blue-600 mx-auto rounded-full"></div>
            </div>

            <div class="max-w-6xl mx-auto">
                <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                    <!-- Vision -->
                    <div class="mb-8">
                        <div class="flex items-center mb-6">
                            <div class="bg-blue-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-2xl font-semibold text-gray-900 ml-4">Visi</h4>
                        </div>
                        <p class="text-gray-700 leading-relaxed mb-8">
                            Menjadi program studi yang unggul dalam bidang sistem informasi pada transformasi digital cerdas dan berkelanjutan di Asia Tenggara pada tahun 2035
                        </p>
                    </div>

                    <!-- Mission -->
                    <div>
                        <div class="flex items-center mb-6">
                            <div class="bg-green-100 p-3 rounded-lg">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h4 class="text-2xl font-semibold text-gray-900 ml-4">Misi</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-medium mr-4 flex-shrink-0">1</span>
                                    <span class="text-gray-700 leading-relaxed">Menyelenggarakan pendidikan berkualitas di bidang sistem informasi yang mendukung transformasi digital cerdas, adaptif dan berkelanjutan.</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-medium mr-4 flex-shrink-0">2</span>
                                    <span class="text-gray-700 leading-relaxed">Menghasilkan penelitian inovatif yang memberikan kontribusi nyata pada kemajuan ilmu pengetahuan dan implementasi transformasi digital di sektor publik.</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-medium mr-4 flex-shrink-0">3</span>
                                    <span class="text-gray-700 leading-relaxed">Membekali lulusan dengan kompetensi teknis, analitis, dan etis untuk menghadapi tantangan transformasi digital di sektor publik dan swasta.</span>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-medium mr-4 flex-shrink-0">4</span>
                                    <span class="text-gray-700 leading-relaxed">Menjalin kemitraan strategis dengan pemerintah, industri, dan lembaga pendidikan untuk mendukung pengembangan solusi teknologi informasi yang relevan.</span>
                                </div>
                                <div class="flex items-start">
                                    <span class="bg-blue-600 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm font-medium mr-4 flex-shrink-0">5</span>
                                    <span class="text-gray-700 leading-relaxed">Memberikan kontribusi pada masyarakat melalui pengabdian berbasis hasil penelitian di bidang teknologi informasi.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white text-black py-12 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Logo and Basic Info -->
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start mb-4">
                        <img src="{{ asset('images/unri.png') }}" alt="Universitas Riau Logo" class="h-12 mr-3">
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">FMIPA Ilmu Komputer</h4>
                            <p class="text-sm text-gray-600">Universitas Riau</p>
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm mb-3">
                        Alamat: Ilmu Komputer FMIPA
                    </p>
                    <a href="https://www.instagram.com/ilmukomputer.unri/" target="_blank" class="inline-flex items-center text-gray-700 hover:text-blue-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        @ilmukomputer.unri
                    </a>
                </div>

                <!-- Directory Links -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Direktori Web</h4>
                    <div class="space-y-2 text-sm">
                        <a href="https://unri.ac.id/" target="_blank" class="text-gray-700 hover:text-blue-600 transition-colors block">UNRI</a>
                        <a href="https://lib.unri.ac.id/" target="_blank" class="text-gray-700 hover:text-blue-600 transition-colors block">Perpustakaan</a>
                        <a href="https://lppm.unri.ac.id/" target="_blank" class="text-gray-700 hover:text-blue-600 transition-colors block">LPPM</a>
                        <a href="https://sites.google.com/unri.ac.id/satu/" target="_blank" class="text-gray-700 hover:text-blue-600 transition-colors block">Satu Unri</a>
                        <a href="https://selasi.unri.ac.id/" target="_blank" class="text-gray-700 hover:text-blue-600 transition-colors block">Selasi</a>
                    </div>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Kontak</h4>
                    <p class="text-gray-700 text-sm mb-2">Butuh bantuan?</p>
                    <a href="https://helpdesk.unri.ac.id/" target="_blank" class="text-blue-600 hover:text-blue-800 transition-colors text-sm block mb-1">helpdesk.unri.ac.id</a>
                    <p class="text-gray-700 text-sm">Customer care: (0761) 63266</p>
                </div>

                <!-- System Info -->
                <div>
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Sistem</h4>
                    <p class="text-gray-700 text-sm">
                        Sistem OneSubmit v1.0<br>
                        Program Studi Sistem Informasi<br>
                        Universitas Riau
                    </p>
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-gray-300 pt-6 text-center">
                <p class="text-gray-600 text-sm">
                    © 2024 Universitas Riau - FMIPA Ilmu Komputer. All rights reserved.
                </p>
            </div>
        </div>
    </footer>
</body>
</html>
