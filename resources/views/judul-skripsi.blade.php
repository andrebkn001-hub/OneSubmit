<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Judul Proposal Skripsi Mahasiswa - Sistem OneSubmit</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/unri22.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/unri22.webp') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        
        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out;
        }
        
        .animate-slideInLeft {
            animation: slideInLeft 0.7s ease-out;
        }
        
        .animate-slideInRight {
            animation: slideInRight 0.7s ease-out;
        }
        
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Custom DataTables Styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #4b5563;
            padding: 0.5rem;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            margin: 0 0.25rem;
            transition: all 0.2s;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: linear-gradient(to right, #3b82f6, #8b5cf6);
            color: white !important;
            border: none;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(to right, #2563eb, #7c3aed) !important;
            color: white !important;
            border: none;
        }
        
        /* Gradient Text */
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Badge Animation */
        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: .8; }
        }
        
        .badge-pulse {
            animation: pulse-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Custom Select Dropdown Styling */
        #bidangMinatFilter {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        #bidangMinatFilter option {
            padding: 12px 16px;
            font-weight: 600;
            color: #1f2937;
        }
        
        #bidangMinatFilter option[value=""] {
            background: #eff6ff;
            color: #1e40af;
        }
        
        #bidangMinatFilter option[value="Information Management"] {
            background: #dbeafe;
            color: #1e40af;
        }
        
        #bidangMinatFilter option[value="Data Engineering"] {
            background: #f3e8ff;
            color: #6b21a8;
        }
        
        #bidangMinatFilter option[value="Information Retrieval"] {
            background: #d1fae5;
            color: #065f46;
        }
        
        #bidangMinatFilter option[value="Business Intelligence"] {
            background: #fef3c7;
            color: #92400e;
        }
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search');
            const tableRows = document.querySelectorAll('tbody tr');

            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();

                tableRows.forEach(row => {
                    const titleCell = row.cells[1]; // Judul Proposal column
                    const title = titleCell.textContent.toLowerCase();

                    if (title.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
</head>
<body class="antialiased bg-gradient-to-br from-gray-50 via-blue-50 to-purple-50 min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-lg rounded-xl mx-4 sm:mx-8 lg:mx-16 mt-4 relative z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
                <div class="flex flex-col">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/unri.png') }}" alt="Universitas Riau Logo" class="h-[52px] xs:h-[62px] sm:h-[73px] align-middle">
                        <a href="{{ url('/') }}" class="text-sm xs:text-base sm:text-lg md:text-xl font-bold text-gray-900 hover:text-blue-600 transition-colors">Sistem OneSubmit</a>
                    </div>
                    <p class="hidden xs:block text-xs xs:text-sm text-gray-600">Universitas Riau</p>
                </div>
                <div class="flex flex-wrap justify-center sm:justify-end space-x-1 xs:space-x-2 sm:space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-2 xs:py-1 xs:px-3 sm:py-2 sm:px-6 rounded-lg transition duration-300 text-xs xs:text-sm sm:text-base">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('judul-skripsi') }}" class="bg-blue-400 hover:bg-blue-500 text-white font-semibold py-1 px-2 xs:py-1 xs:px-3 sm:py-2 sm:px-6 rounded-lg transition duration-300 text-xs xs:text-sm sm:text-base">
                            Judul Skripsi
                        </a>
                        <a href="{{ route('dosen-staff') }}" class="bg-blue-400 hover:bg-blue-500 text-white font-semibold py-1 px-2 xs:py-1 xs:px-3 sm:py-2 sm:px-6 rounded-lg transition duration-300 text-xs xs:text-sm sm:text-base">
                            Dosen dan Staff
                        </a>
                        <a href="{{ route('login') }}" class="bg-blue-400 hover:bg-blue-500 text-white font-semibold py-1 px-2 xs:py-1 xs:px-3 sm:py-2 sm:px-6 rounded-lg transition duration-300 text-xs xs:text-sm sm:text-base">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-400 hover:bg-blue-500 text-white font-semibold py-1 px-2 xs:py-1 xs:px-3 sm:py-2 sm:px-6 rounded-lg transition duration-300 text-xs xs:text-sm sm:text-base">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="py-6 sm:py-8 lg:py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Hero Section with Page Header -->
            <div class="relative mb-8 sm:mb-10 overflow-hidden">
                <!-- Background Decoration -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 rounded-3xl transform -rotate-1 opacity-10"></div>
                <div class="absolute inset-0 bg-gradient-to-l from-blue-500 via-purple-500 to-indigo-500 rounded-3xl transform rotate-1 opacity-5"></div>
                
                <!-- Content -->
                <div class="relative bg-white rounded-3xl shadow-2xl p-6 sm:p-8 lg:p-12 animate-fadeIn">
                    <div class="flex items-center gap-6 max-w-5xl mx-auto">
                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="inline-flex items-center justify-center w-16 h-16 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-3xl shadow-lg transform hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Text Content -->
                        <div class="flex-1 text-center">
                            <!-- Title -->
                            <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold mb-2">
                                <span class="gradient-text">Judul Proposal Skripsi Mahasiswa</span>
                            </h1>
                            
                            <!-- Description -->
                            <p class="text-xs sm:text-sm lg:text-base text-gray-600 leading-relaxed">
                                Daftar judul proposal skripsi yang telah <span class="font-semibold text-blue-600">disetujui</span> di Program Studi <span class="font-semibold text-purple-600">Sistem Informasi</span> Universitas Riau
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="mb-6 sm:mb-8 animate-fadeIn">
                <div class="max-w-2xl mx-auto">
                    <label for="search" class="block text-base sm:text-lg font-semibold text-gray-800 mb-3 text-center sm:text-left">
                        <span class="flex items-center justify-center sm:justify-start">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari Judul Proposal
                        </span>
                    </label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 sm:pl-5 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="search" 
                            name="search" 
                            class="block w-full pl-12 sm:pl-14 pr-4 py-4 sm:py-5 text-base sm:text-lg border-2 border-gray-300 rounded-2xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:placeholder-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-lg hover:shadow-xl transition-all duration-300" 
                            placeholder="Ketik kata kunci judul proposal..."
                        >
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                            <kbd class="hidden sm:inline-flex items-center px-2 py-1 bg-gray-100 border border-gray-300 rounded text-xs font-semibold text-gray-600">
                                Ctrl + K
                            </kbd>
                        </div>
                    </div>
                    <p class="mt-2 text-xs sm:text-sm text-gray-500 text-center sm:text-left">
                        💡 Tip: Gunakan kata kunci seperti nama, teknologi, atau topik untuk pencarian lebih akurat
                    </p>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden animate-fadeIn border border-gray-200">
                <!-- Table Header -->
                <div class="px-6 sm:px-8 py-6 bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div>
                            <h2 class="text-2xl sm:text-3xl font-bold text-white mb-2 flex items-center">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Daftar Judul Skripsi
                            </h2>
                            <p class="text-sm sm:text-base text-blue-100 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Total: <span class="font-bold ml-1" id="totalCount">{{ $approvedProposals->count() }}</span> judul terverifikasi
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="relative inline-block">
                                <select id="bidangMinatFilter" class="appearance-none backdrop-blur-sm text-white text-sm font-semibold rounded-xl border border-white/30 px-4 py-2 pr-10 cursor-pointer hover:bg-white/30 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-white/50">
                                    <option value="">Semua Bidang Minat</option>
                                    <option value="Information Management">Information Management</option>
                                    <option value="Data Engineering">Data Engineering</option>
                                    <option value="Information Retrieval">Information Retrieval</option>
                                    <option value="Business Intelligence">Business Intelligence</option>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($approvedProposals->count() > 0)
                    <div class="overflow-x-auto">
                        <table id="judulSkripsiTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-blue-50">
                                <tr>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                            </svg>
                                            No
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Judul Proposal
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-5 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            Bidang Minat
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach($approvedProposals as $index => $proposal)
                                    <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-300 group">
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <div class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 text-white font-bold rounded-xl shadow-md group-hover:shadow-lg group-hover:scale-110 transition-all duration-300">
                                                {{ $index + 1 }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <div class="flex items-start">
                                                <svg class="w-5 h-5 mr-3 mt-1 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <p class="text-sm sm:text-base text-gray-900 font-medium leading-relaxed group-hover:text-blue-700 transition-colors">
                                                    {{ $proposal->judul }}
                                                </p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5 whitespace-nowrap">
                                            <span class="inline-flex items-center px-4 py-2 text-xs sm:text-sm font-semibold rounded-xl shadow-sm
                                                {{ $proposal->bidang_minat === 'Information Management' ? 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border-2 border-blue-300' : '' }}
                                                {{ $proposal->bidang_minat === 'Data Engineering' ? 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 border-2 border-purple-300' : '' }}
                                                {{ $proposal->bidang_minat === 'Information Retrieval' ? 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border-2 border-green-300' : '' }}
                                                {{ $proposal->bidang_minat === 'Business Intelligence' ? 'bg-gradient-to-r from-amber-100 to-amber-200 text-amber-800 border-2 border-amber-300' : '' }}
                                                {{ !in_array($proposal->bidang_minat, ['Information Management', 'Data Engineering', 'Information Retrieval', 'Business Intelligence']) ? 'bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border-2 border-gray-300' : '' }}
                                            ">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                                {{ $proposal->bidang_minat }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-16 sm:py-20 text-center">
                        <div class="inline-flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full mb-6">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3">Belum Ada Judul Skripsi</h3>
                        <p class="text-sm sm:text-base text-gray-600 max-w-md mx-auto">
                            Saat ini belum ada proposal skripsi yang telah disetujui. Silakan cek kembali nanti.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Back Button -->
            <div class="text-center mt-10 sm:mt-12 animate-fadeIn">
                <a href="{{ url('/') }}" class="inline-flex items-center px-8 py-4 border-2 border-transparent text-base sm:text-lg font-semibold rounded-2xl text-white bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 hover:from-blue-700 hover:via-purple-700 hover:to-indigo-700 transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:-translate-y-1 group">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 mr-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

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
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTables
            var table = $('#judulSkripsiTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                    search: "_INPUT_",
                    searchPlaceholder: "Cari dalam tabel...",
                    lengthMenu: "Tampilkan _MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ judul",
                    infoEmpty: "Tidak ada data",
                    infoFiltered: "(difilter dari _MAX_ total judul)",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                },
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                dom: '<"flex flex-col sm:flex-row justify-between items-center mb-4 gap-4"lf>rtip',
                drawCallback: function() {
                    // Add animation to rows
                    $('#judulSkripsiTable tbody tr').each(function(index) {
                        $(this).css({
                            'animation': 'fadeIn 0.5s ease-out ' + (index * 0.05) + 's both'
                        });
                    });
                    
                    // Update total count
                    var info = table.page.info();
                    $('#totalCount').text(info.recordsDisplay);
                }
            });

            // Bidang Minat Filter
            $('#bidangMinatFilter').on('change', function() {
                var selectedBidang = $(this).val();
                
                console.log('Filter dipilih:', selectedBidang); // Debug
                
                // Filter berdasarkan kolom bidang minat (kolom index 2)
                if (selectedBidang === '') {
                    // Tampilkan semua data
                    table.search('').columns().search('').draw();
                } else {
                    // Filter kolom bidang minat (index 2)
                    table.column(2).search(selectedBidang, false, false).draw();
                }
                
                // Debug: tampilkan jumlah hasil
                var info = table.page.info();
                console.log('Hasil filter:', info.recordsDisplay, 'dari', info.recordsTotal);
                
                // Add visual feedback
                $(this).addClass('ring-2 ring-white/50');
                setTimeout(() => {
                    $(this).removeClass('ring-2 ring-white/50');
                }, 300);
            });

            // Keyboard shortcut for search (Ctrl + K)
            $(document).on('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
                    e.preventDefault();
                    $('#search').focus();
                }
            });

            // Enhanced search functionality
            $('#search').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Smooth scroll to top button
            var scrollToTopBtn = $('<button></button>')
                .addClass('fixed bottom-8 right-8 bg-gradient-to-r from-blue-600 to-purple-600 text-white p-4 rounded-full shadow-2xl hover:shadow-3xl transform hover:scale-110 transition-all duration-300 z-50 hidden')
                .html('<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>')
                .appendTo('body');

            $(window).scroll(function() {
                if ($(this).scrollTop() > 300) {
                    scrollToTopBtn.fadeIn().removeClass('hidden');
                } else {
                    scrollToTopBtn.fadeOut();
                }
            });

            scrollToTopBtn.click(function() {
                $('html, body').animate({scrollTop: 0}, 600);
                return false;
            });

            // Add tooltip for keyboard shortcut
            var tooltip = $('<div></div>')
                .addClass('fixed bottom-24 right-8 bg-gray-900 text-white text-xs px-3 py-2 rounded-lg shadow-lg hidden')
                .text('Tekan Ctrl + K untuk mencari')
                .appendTo('body');

            setTimeout(function() {
                tooltip.fadeIn().removeClass('hidden');
                setTimeout(function() {
                    tooltip.fadeOut();
                }, 3000);
            }, 2000);

            // Highlight search terms
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    return true;
                }
            );
        });
    </script>
</body>
</html>
