<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - OneSubmit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 240px;
            background-color: #0d6efd;
            color: white;
            flex-shrink: 0;
        }
        .sidebar h4 {
            padding: 20px;
            font-size: 1.3rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background-color: rgba(255,255,255,0.2);
        }
        .content {
            flex-grow: 1;
            padding: 20px;
        }
        .navbar-custom {
            background-color: white;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4>OneSubmit</h4>
        <div class="px-2">
            <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
            <a href="{{ route('profile.edit') }}">👤 Profil</a>
            <a href="{{ route('pengajuan.index') }}">📄 Proposal Tugas Akhir</a>
            <a href="#">🗓️ Pengajuan Sidang</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-light w-100">🚪 Logout</button>
            </form>
        </div>
    </div>

    <!-- Konten -->
    <div class="content">
        <nav class="navbar navbar-custom d-flex justify-content-between align-items-center mb-3">
            <h5>Halo, {{ Auth::user()->name }}</h5>
        </nav>
        @yield('content')
    </div>

</body>
</html>
