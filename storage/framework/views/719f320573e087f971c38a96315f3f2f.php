<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OneSubmit - Dashboard Admin</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <style>
        body {
            overflow-x: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #cbd5e1 100%);
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
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                <img src="<?php echo e(asset('images/unri.png')); ?>" alt="Universitas Riau Logo">
                OneSubmit
            </a>
            <div class="d-flex align-items-center">
                <!-- Notification Badge for Pending Approvals -->
                <?php
                    $pendingCount = \App\Models\Proposal::where('status', 'menunggu_verifikasi')->count();
                ?>
                <?php if($pendingCount > 0): ?>
                    <a href="<?php echo e(route('admin.proposals.index')); ?>" class="btn btn-warning btn-sm me-3 position-relative">
                        <i class="bi bi-bell-fill"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo e($pendingCount); ?>

                            <span class="visually-hidden">pending proposals</span>
                        </span>
                    </a>
                <?php endif; ?>
                <span class="text-white me-3">Dashboard Admin</span>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <div class="sidebar-header">
            <?php if(Auth::user()->profile_photo): ?>
                <img src="<?php echo e(asset('storage/' . Auth::user()->profile_photo)); ?>" alt="Profile Photo" class="profile-photo">
            <?php else: ?>
                <div class="profile-placeholder"><?php echo e(strtoupper(substr(Auth::user()->name,0,1))); ?></div>
            <?php endif; ?>
            <div>
                <h5 class="fw-bold mb-1">OneSubmit</h5>
                <p class="mb-0 opacity-75 small">Menu Admin</p>
            </div>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>"><i class="bi bi-house-door"></i> Dashboard</a>
        <a href="<?php echo e(route('admin.proposals.index')); ?>"><i class="bi bi-folder2-open"></i> Kelola Proposal</a>
        <a href="<?php echo e(route('admin.students.index')); ?>"><i class="bi bi-people"></i> Daftar Mahasiswa</a>
        <a href="<?php echo e(route('admin.quotas.index')); ?>"><i class="bi bi-sliders"></i> Kelola Kuota</a>
        <a href="<?php echo e(route('profile.edit')); ?>"><i class="bi bi-person"></i> Profil</a>
    </div>

    <div class="content">
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    
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

    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\OneSubmit\resources\views/layouts/admin.blade.php ENDPATH**/ ?>