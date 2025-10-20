<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OneSubmit Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
        }
        .sidebar {
            height: 100vh;
            width: 250px;
            background-color: #212529;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 60px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 10px 20px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            margin-left: 250px;
            padding: 40px;
        }
        .navbar {
            position: fixed;
            width: 100%;
            z-index: 1000;
        }
        main {
            margin-left: 250px;
            margin-top: 100px; /* ✅ Tambahkan jarak dari navbar biar tidak kepotong */
            padding: 20px;
            width: calc(100% - 250px);
        }
    </style>
</head>
<body>
    <!-- Navbar atas -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">OneSubmit</a>
            <div class="d-flex">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar kiri -->
    <div class="sidebar">
        <h5 class="text-center fw-bold mb-4">Menu</h5>
        <a href="{{ route('dashboard') }}">🏠 Dashboard</a>

        @if(Auth::user()->role == 'mahasiswa')
            <a href="{{ route('mahasiswa.dashboard') }}">Ajukan Proposal</a>
            <a href="{{ route('mahasiswa.status') }}">📄 Status Proposal</a>
        @endif

        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}">Kelola Data</a>
        @endif

        @if(Auth::user()->role == 'ketua_jurusan')
            <a href="{{ route('jurusan.dashboard') }}">Validasi Jurusan</a>
        @endif

        @if(Auth::user()->role == 'ketua_kjfd')
            <a href="{{ route('kjfd.dashboard') }}">Validasi KJFD</a>
        @endif

        <a href="{{ route('profile.edit') }}">👤 Profil</a>
    </div>

    <!-- Konten utama -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
