<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="theme-color" content="#1e90ff">
    <title>OneSubmit Dashboard</title>
    <link rel="icon" type="image/webp" href="{{ asset('images/unri22.webp') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/unri22.webp') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
    <style>
        * {
            -webkit-tap-highlight-color: rgba(0,0,0,0.1);
        }
        
        body {
            overflow-x: hidden;
            background: linear-gradient(135deg, #87ceeb 0%, #4682b4 50%, #1e90ff 100%);
            background-attachment: fixed;
            -webkit-overflow-scrolling: touch;
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
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 20px;
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
            color: #1e90ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.25rem;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 3px rgba(255,255,255,0.3);
        }
        .sidebar a {
            color: white;
            display: block;
            padding: 15px 25px;
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 5px 15px;
            position: relative;
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
        .sidebar a .badge {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 0.7rem;
            padding: 0.25em 0.5em;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
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
            padding: 0.75rem 1rem;
        }
        .navbar-brand {
            display: flex;
            align-items: center;
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        @media (max-width: 576px) {
            .navbar {
                padding: 0.5rem 0.75rem;
            }
            .navbar-brand {
                font-size: 1rem;
            }
            .navbar-brand img {
                height: 28px;
                margin-right: 6px;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: fixed;
                padding-top: 0;
                display: none;
                top: 60px; /* slightly larger for clearer separation */
                max-height: calc(100vh - 60px);
                overflow-y: auto;
                z-index: 998;
                -webkit-overflow-scrolling: touch;
            }
            .sidebar.show {
                display: block;
            }
            .content {
                margin-left: 0;
                width: 100%;
                padding: 76px 0 18px 0; /* increased top padding to avoid clipped header */
            }
            .navbar-toggler {
                display: block;
            }
            .navbar-brand {
                font-size: 1rem;
            }
            .navbar-brand img {
                height: 28px;
            }
            .navbar {
                padding: 0.55rem 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .content {
                padding: 82px 0 14px 0; /* more top spacing on extra small devices */
            }
            .navbar {
                padding: 0.45rem 0.65rem;
            }
            .navbar-brand {
                font-size: 0.95rem;
            }
            .navbar-brand img {
                height: 26px;
                margin-right: 6px;
            }
        }
        /* utility to ensure safe top offset if needed */
        .safe-top { margin-top: 0; }
        @media (max-width: 768px){ .safe-top { margin-top: 6px; } }
        @media (max-width: 576px){ .safe-top { margin-top: 10px; } }
        /* lock scroll when sidebar open */
        body.lock-scroll { overflow: hidden; }

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

        /* Notification Dropdown Responsive */
        .dropdown-menu {
            min-width: 360px;
            max-height: 420px;
            overflow-y: auto;
        }

        @media (max-width: 576px) {
            .dropdown-menu {
                min-width: 280px;
                max-width: calc(100vw - 30px);
                max-height: 350px;
                font-size: 0.875rem;
            }
            .dropdown-item {
                padding: 0.5rem 0.75rem;
            }
        }

        @media (max-width: 375px) {
            .dropdown-menu {
                min-width: 250px;
                font-size: 0.8rem;
            }
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
                <!-- Notifications Bell -->
                @php
                    $unread = Auth::check() ? Auth::user()->unreadNotifications()->limit(10)->get() : collect();
                @endphp
                <div class="dropdown me-3">
                    <button class="btn btn-outline-light btn-sm dropdown-toggle position-relative" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell"></i>
                        @if($unread->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">{{ $unread->count() }}</span>
                        @endif
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header fw-bold">Notifikasi</li>
                        @forelse($unread as $notif)
                            <li>
                                <a class="dropdown-item small" href="{{ $notif->data['url'] ?? '#' }}">
                                    <div class="fw-semibold">{{ $notif->data['message'] ?? 'Notifikasi' }}</div>
                                    <div class="text-muted">{{ $notif->created_at->diffForHumans() }}</div>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                        @empty
                            <li><span class="dropdown-item text-muted">Tidak ada notifikasi baru</span></li>
                        @endforelse
                        <li>
                            <form method="POST" action="{{ route('notifications.read-all') }}" class="px-3 py-2">
                                @csrf
                                <button class="btn btn-sm btn-outline-secondary w-100">Tandai semua sebagai sudah dibaca</button>
                            </form>
                        </li>
                    </ul>
                </div>
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
            @if(Auth::user()->profile_photo)
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo" class="profile-photo">
            @else
                <div class="profile-placeholder">{{ strtoupper(substr(Auth::user()->name,0,1)) }}</div>
            @endif
            <div>
                <h5 class="fw-bold mb-1">OneSubmit</h5>
                <p class="mb-0 opacity-75 small">Menu Dashboard</p>
            </div>
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
            @php
                $sidebarService = app(\App\Services\SidebarService::class);
                $badges = $sidebarService->getKetuaJurusanBadges();
            @endphp
            <a href="{{ route('jurusan.inbox.index') }}">
                <i class="bi bi-inbox-fill"></i> Inbox Aksi Saya
                @if($badges['inbox_total'] > 0)
                    <span class="badge bg-danger rounded-pill float-end">{{ $badges['inbox_total'] }}</span>
                @endif
            </a>
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

    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    
    <!-- Additional scripts from child views (e.g., DataTables Buttons) -->
    @yield('footer-scripts')
    
    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const body = document.body;
            sidebar.classList.toggle('show');
            body.classList.toggle('lock-scroll', sidebar.classList.contains('show'));
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
    <script src="{{ asset('js/form-validation.js') }}"></script>
</body>
</html>