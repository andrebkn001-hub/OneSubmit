<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OneSubmit</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #212529;
            color: white;
            padding: 1rem;
            position: fixed;
            width: 250px;
        }
        .sidebar h4 {
            color: #fff;
            margin-bottom: 1rem;
        }
        .sidebar a {
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #343a40;
            border-radius: 8px;
        }
        .content {
            margin-left: 250px;
            padding: 2rem;
        }
        .topbar {
            background-color: #212529;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h4><strong>OneSubmit</strong></h4>
        <p class="fw-bold">Menu</p>
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="text-white d-block py-2 px-3">
                    <i class="bi bi-house-door"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.proposals.index') }}" class="text-white d-block py-2 px-3">
                    <i class="bi bi-folder2-open"></i> Kelola Data
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}" class="text-white d-block py-2 px-3">
                    <i class="bi bi-person"></i> Profil
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="topbar">
            <span class="fw-bold">Dashboard Admin</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
            </form>
        </div>

        <div class="mt-4">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
