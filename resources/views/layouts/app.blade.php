<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OneSubmit Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            overflow-x: hidden;
            background: linear-gradient(135deg, #87ceeb 0%, #4682b4 50%, #1e90ff 100%);
            background-attachment: fixed;
        }
        .sidebar {
            height: 100vh;
            width: 280px;
            background: linear-gradient(135deg, #87ceeb 0%, #4682b4 50%, #1e90ff 100%);
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding-top: 80px;
            z-index: 999;
            box-shadow: 4px 0 15px rgba(0,0,0,0.1);
        }
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 15px 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 5px 15px;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.2);
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .sidebar a i {
            margin-right: 10px;
            width: 20px;
        }
        .content {
            margin-left: 280px;
            padding: 90px 30px 30px 30px;
            min-height: 100vh;
            background: #f8fafc;
        }
        .navbar {
            position: fixed;
            width: 100%;
            z-index: 1000;
            background: linear-gradient(135deg, #87ceeb 0%, #4682b4 50%, #1e90ff 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.5rem;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                padding-top: 0;
                display: none;
            }
            .sidebar.show {
                display: block;
            }
            .content {
                margin-left: 0;
                width: 100%;
                padding: 80px 15px 15px 15px;
            }
            .navbar-toggler {
                display: block;
            }
        }

        @media (min-width: 769px) {
            .navbar-toggler {
                display: none;
            }
        }

        .navbar-toggler {
            border: none;
            background: none;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .card {
            margin-bottom: 1rem;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, #87ceeb 0%, #4682b4 50%, #1e90ff 100%);
            border: none;
            border-radius: 8px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4682b4 0%, #1e90ff 50%, #4169e1 100%);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler d-md-none" type="button" onclick="toggleSidebar()">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/unri.png') }}" alt="Universitas Riau Logo">
                OneSubmit
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">Selamat datang, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <div class="sidebar-header">
            <h5 class="fw-bold mb-1">OneSubmit</h5>
            <p class="mb-0 opacity-75 small">Menu Dashboard</p>
        </div>
        <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>

        @if(Auth::user()->role == 'mahasiswa')
            <a href="{{ route('mahasiswa.proposal.create') }}"><i class="bi bi-send"></i> Ajukan Proposal</a>
            <a href="{{ route('mahasiswa.status') }}"><i class="bi bi-envelope-paper"></i> Status Proposal</a>
            <a href="{{ route('mahasiswa.layanan') }}"><i class="bi bi-file-earmark-text"></i> Layanan</a>
        @endif

        @if(Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}"><i class="bi bi-person-gear"></i> Kelola Data</a>
        @endif

        @if(Auth::user()->role == 'ketua_jurusan')
            <a href="{{ route('jurusan.proposals.kjfd') }}"><i class="bi bi-file-earmark-check"></i> Daftar Proposal</a>
        @endif

        @if(Auth::user()->role == 'ketua_kjfd')
            <a href="{{ route('kjfd.dashboard') }}"><i class="bi bi-clipboard2-check"></i> Validasi KJFD</a>
        @endif

        <a href="{{ route('profile.edit') }}"><i class="bi bi-person"></i> Profil</a>
    </div>

    <div class="content">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('show');
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const navbarToggler = document.querySelector('.navbar-toggler');
            if (!sidebar.contains(event.target) && !navbarToggler.contains(event.target) && window.innerWidth <= 768) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</body>
</html>
