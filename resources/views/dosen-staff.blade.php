<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dosen dan Staff - Sistem OneSubmit</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchJabatanInput = document.getElementById('search-jabatan');
            const searchNamaInput = document.getElementById('search-nama');
            const tableRows = document.querySelectorAll('tbody tr');

            function filterTable() {
                const jabatanTerm = searchJabatanInput.value.toLowerCase();
                const namaTerm = searchNamaInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const namaCell = row.cells[1]; // Nama column
                    const jabatanCell = row.cells[2]; // Jabatan Fungsional column
                    const nama = namaCell.textContent.toLowerCase();
                    const jabatan = jabatanCell.textContent.toLowerCase();

                    const matchesJabatan = jabatan.includes(jabatanTerm);
                    const matchesNama = nama.includes(namaTerm);

                    if (matchesJabatan && matchesNama) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            searchJabatanInput.addEventListener('input', filterTable);
            searchNamaInput.addEventListener('input', filterTable);
        });
    </script>
</head>
<body class="antialiased bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-2 sm:space-y-0">
                <div class="flex flex-col">
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('images/unri.png') }}" alt="Universitas Riau Logo" class="h-10 xs:h-12 sm:h-14">
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
    <main class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Dosen dan Staff</h1>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Susunan Organisasi Jurusan Ilmu Komputer FMIPA Universitas Riau
                </p>
            </div>

            <!-- Search Section -->
            <div class="mb-8">
                <div class="max-w-4xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Search by Name -->
                        <div>
                            <label for="search-nama" class="block text-sm font-medium text-gray-700 mb-2">Cari Berdasarkan Nama</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="search-nama" name="search-nama" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" placeholder="Ketik nama...">
                            </div>
                        </div>

                        <!-- Search by Jabatan Fungsional -->
                        <div>
                            <label for="search-jabatan" class="block text-sm font-medium text-gray-700 mb-2">Cari Berdasarkan Jabatan Fungsional</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" id="search-jabatan" name="search-jabatan" class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" placeholder="Ketik jabatan fungsional...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Section -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Susunan Organisasi</h2>
                    <p class="text-sm text-gray-600 mt-1">Total: {{ count($dosenStaff) }} orang</p>
                </div>

                <div class="overflow-x-auto">
                    <table id="dosenStaffTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-blue-600 to-purple-600">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Nama
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    Jabatan Fungsional
                                </th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                    NIP
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($dosenStaff as $index => $person)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 bg-gray-50">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 font-medium leading-relaxed">
                                        {{ $person['nama'] }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 border border-blue-200">
                                            {{ $person['jabatan'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $person['nip'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Back Button -->
            <div class="text-center mt-8">
                <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white text-black py-12 border-t border-gray-200 mt-12">
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
            $('#dosenStaffTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
                },
                responsive: true,
                pageLength: 10,
                order: [[0, 'asc']],
                dom: 'frtip'
            });
        });
    </script>
</body>
</html>
