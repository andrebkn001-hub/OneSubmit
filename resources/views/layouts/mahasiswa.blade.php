<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Mahasiswa - OneSubmit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
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
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-header .profile-photo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ffffff;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
        }
        .sidebar-header .profile-placeholder {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background-color: #ffffff;
            color: #0d6efd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
        }
        .sidebar h4 {
            margin: 0;
            font-size: 1.3rem;
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
        <div class="sidebar-header">
            @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="profile-photo">
            @else
                <div class="profile-placeholder">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            @endif
            <h4>OneSubmit</h4>
        </div>
        <div class="px-2 mt-3">
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

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

</body>
</html>
