@extends('layouts.app')

@section('content')
<div class="container-fluid safe-top px-2 px-sm-3 px-md-4">
    <!-- Welcome Header -->
    <div class="row mb-2 mb-md-4">
        <div class="col-12">
            <div class="text-center">
                <h1 class="dashboard-title fw-bold text-primary mb-1 mb-md-2" style="color: #1e90ff !important;">
                    <i class="bi bi-speedometer2 me-1 me-md-2 d-none d-md-inline"></i>Dashboard Mahasiswa
                </h1>
                <p class="lead-text text-muted mb-2">Selamat datang, <strong class="text-primary">{{ Auth::user()->name }}</strong></p>
                <div class="mt-2 d-none d-md-block">
                    <img src="{{ asset('images/unri.png') }}" alt="UNRI Logo" class="img-fluid unri-logo">
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-2 mb-md-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Action Cards -->
    <div class="row g-2 g-md-4 mb-2 mb-md-5">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow hover-card action-card gradient-blue rounded-3">
                <div class="card-body text-center card-body-responsive unified-card">
                    <div class="icon-wrapper mb-2">
                        <i class="bi bi-plus-circle-fill icon-responsive" style="color: #1976d2;"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-1 mb-md-2 card-title-responsive" style="color: #1565c0;">Ajukan Proposal Baru</h5>
                    <p class="card-text text-muted mb-2 card-text-responsive">Buat pengajuan proposal tugas akhir baru dengan mudah dan cepat.</p>
                    <a href="{{ route('mahasiswa.proposal.create') }}" class="btn action-btn btn-responsive w-100 fw-bold">
                        <i class="bi bi-plus-circle me-1"></i>Ajukan Proposal
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow hover-card action-card gradient-purple rounded-3">
                <div class="card-body text-center card-body-responsive unified-card">
                    <div class="icon-wrapper mb-2">
                        <i class="bi bi-list-check icon-responsive" style="color: #7b1fa2;"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-1 mb-md-2 card-title-responsive" style="color: #6a1b9a;">Lihat Status Proposal</h5>
                    <p class="card-text text-muted mb-2 card-text-responsive">Pantau status proposal yang sudah Anda ajukan secara real-time.</p>
                    <a href="{{ route('mahasiswa.status') }}" class="btn action-btn-purple btn-responsive w-100 fw-bold">
                        <i class="bi bi-eye me-1"></i>Lihat Status
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow hover-card action-card gradient-green rounded-3">
                <div class="card-body text-center card-body-responsive unified-card">
                    <div class="icon-wrapper mb-2">
                        <i class="bi bi-person-fill icon-responsive" style="color: #388e3c;"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-1 mb-md-2 card-title-responsive" style="color: #2e7d32;">Kelola Profil</h5>
                    <p class="card-text text-muted mb-2 card-text-responsive">Update informasi profil dan data pribadi Anda dengan lengkap.</p>
                    <a href="{{ route('profile.edit') }}" class="btn action-btn-green btn-responsive w-100 fw-bold">
                        <i class="bi bi-pencil me-1"></i>Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-2 mb-md-4">
        <div class="col-12">
            <div class="card border-0 shadow" style="border-radius: 10px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <div class="card-header border-0 bg-transparent px-2 px-md-4 py-2">
                    <h4 class="mb-0 fw-bold text-primary stats-header-title">
                        <i class="bi bi-bar-chart-line me-1"></i>Ringkasan Proposal
                    </h4>
                </div>
                <div class="card-body p-2 p-sm-3 p-md-4">
                    <div class="row g-2 g-md-3">
                        <div class="col-6 col-md-3">
                            <div class="stats-card text-center stats-card-responsive rounded-3" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border: 2px solid #ffc107;">
                                <div class="stats-number fw-bold stats-number-responsive mb-1 mb-md-2" style="color: #856404;">
                                    {{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'menunggu_verifikasi')->count() }}
                                </div>
                                <div class="stats-label small fw-semibold text-muted stats-label-responsive">Menunggu Verifikasi</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card text-center stats-card-responsive rounded-3" style="background: linear-gradient(135deg, #cce5ff 0%, #99d6ff 100%); border: 2px solid #0d6efd;">
                                <div class="stats-number fw-bold stats-number-responsive mb-1 mb-md-2" style="color: #0a58ca;">
                                    {{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'menunggu_verifikasi_dosen_kjfd')->count() }}
                                </div>
                                <div class="stats-label small fw-semibold text-muted stats-label-responsive">Verifikasi KJFD</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card text-center stats-card-responsive rounded-3" style="background: linear-gradient(135deg, #d1ecf1 0%, #a3daff 100%); border: 2px solid #198754;">
                                <div class="stats-number fw-bold stats-number-responsive mb-1 mb-md-2" style="color: #0f5132;">
                                    {{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'disetujui')->count() }}
                                </div>
                                <div class="stats-label small fw-semibold text-muted stats-label-responsive">Disetujui</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card text-center stats-card-responsive rounded-3" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border: 2px solid #dc3545;">
                                <div class="stats-number fw-bold stats-number-responsive mb-1 mb-md-2" style="color: #b02a37;">
                                    {{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'ditolak')->count() }}
                                </div>
                                <div class="stats-label small fw-semibold text-muted stats-label-responsive">Ditolak</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KJFD Quota Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                <div class="card-header border-0 bg-primary text-white header-responsive" style="border-radius: 15px 15px 0 0 !important; background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%) !important;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2">
                        <h4 class="mb-0 fw-bold table-header-title">
                            <i class="bi bi-people-fill me-2"></i>Kuota Proposal per Bidang KJFD
                        </h4>
                        <div class="badge bg-light text-primary badge-responsive px-3 py-2">
                            <i class="bi bi-info-circle me-1"></i><span class="d-none d-sm-inline">Kuota dinamis per bidang</span><span class="d-inline d-sm-none">Info Kuota</span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    @php
                        $kjfdBidang = [
                            'KJFD Business Intelligence',
                            'KJFD Data Engineering',
                            'KJFD Information Management',
                            'KJFD Information Retrieval'
                        ];
                        $kjfdList = \App\Models\User::where('role', 'dosen_kjfd')
                            ->whereIn('name', $kjfdBidang)
                            ->orderBy('name')
                            ->get();
                    @endphp

                    @if($kjfdList->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-info-circle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada data Dosen KJFD</h5>
                            <p class="text-muted">Data dosen KJFD akan segera ditambahkan.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="kjfdQuotasTable" class="table table-hover mb-0">
                                <thead class="table-primary" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                    <tr>
                                        <th class="border-0 fw-bold table-header-cell">
                                            <i class="bi bi-person-badge me-1 me-md-2"></i><span class="d-none d-sm-inline">Nama Dosen KJFD</span><span class="d-inline d-sm-none">Dosen</span>
                                        </th>
                                        <th class="border-0 fw-bold table-header-cell text-center">
                                            <i class="bi bi-dash-circle me-1 me-md-2"></i><span class="d-none d-sm-inline">Kuota</span><span class="d-inline d-sm-none">Max</span>
                                        </th>
                                        <th class="border-0 fw-bold table-header-cell text-center">
                                            <i class="bi bi-check-circle me-1 me-md-2"></i><span class="d-none d-sm-inline">Sudah ACC</span><span class="d-inline d-sm-none">ACC</span>
                                        </th>
                                        <th class="border-0 fw-bold table-header-cell text-center">
                                            <i class="bi bi-arrow-right-circle me-1 me-md-2"></i>Sisa
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kjfdList as $kjfd)
                                        @php
                                            $accepted = \App\Models\Proposal::where('dosen_kjfd_id', $kjfd->id)
                                                ->where('status', 'disetujui')
                                                ->count();
                                            $bidang = str_replace('KJFD ', '', $kjfd->name);
                                            $quota = \App\Models\KjfdQuota::where('bidang', $bidang)->first();
                                            $limit = $quota ? $quota->quota : 50;
                                            $remaining = max(0, $limit - $accepted);
                                        @endphp
                                        <tr class="border-bottom border-light">
                                            <td class="table-cell-responsive fw-semibold">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle avatar-responsive me-2 me-md-3" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                        {{ substr($kjfd->name, 0, 1) }}
                                                    </div>
                                                    <span class="dosen-name">{{ $kjfd->name }}</span>
                                                </div>
                                            </td>
                                            <td class="table-cell-responsive text-center">
                                                <span class="badge badge-table-responsive" style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); border-radius: 20px;">
                                                    {{ $limit }}
                                                </span>
                                            </td>
                                            <td class="table-cell-responsive text-center">
                                                <span class="badge badge-table-responsive" style="background: linear-gradient(135deg, #198754 0%, #157347 100%); border-radius: 20px;">
                                                    {{ $accepted }}
                                                </span>
                                            </td>
                                            <td class="table-cell-responsive text-center">
                                                @if($remaining > 0)
                                                    <span class="badge badge-table-responsive" style="background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%); border-radius: 20px;">
                                                        {{ $remaining }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-table-responsive" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 20px;">
                                                        <i class="bi bi-x-circle me-1"></i><span class="d-none d-sm-inline">Penuh</span><span class="d-inline d-sm-none">0</span>
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* ===== GENERAL OPTIMIZATIONS ===== */
* {
    -webkit-tap-highlight-color: rgba(0,0,0,0.1);
}

html {
    scroll-behavior: smooth;
}

/* ===== RESPONSIVE TYPOGRAPHY ===== */
.dashboard-title {
    font-size: 1.4rem;
    line-height: 1.2;
}

.lead-text {
    font-size: 0.85rem;
}

.unri-logo {
    height: 50px;
    opacity: 0.8;
}

/* ===== RESPONSIVE CARDS ===== */
.card-body-responsive {
    padding: 0.9rem;
}

.icon-responsive {
    font-size: 1.85rem;
}

.card-title-responsive {
    font-size: 0.95rem;
    line-height: 1.2;
}

.card-text-responsive {
    font-size: 0.75rem;
    line-height: 1.3;
}

.btn-responsive {
    padding: 0.6rem 0.75rem;
    font-size: 0.85rem;
    min-height: 42px;
}

/* ===== RESPONSIVE STATISTICS ===== */
.stats-header-title {
    font-size: 0.95rem;
}

.stats-card-responsive {
    padding: 0.65rem 0.4rem;
}

.stats-number-responsive {
    font-size: 1.4rem;
    line-height: 1;
}

.stats-label-responsive {
    font-size: 0.6rem;
    line-height: 1.15;
}

/* ===== RESPONSIVE TABLE ===== */
.table-header-title {
    font-size: 0.95rem;
}

.badge-responsive {
    font-size: 0.7rem;
}

.header-responsive {
    padding: 0.75rem 0.5rem;
}

.table-header-cell {
    padding: 0.6rem 0.4rem;
    font-size: 0.75rem;
}

.table-cell-responsive {
    padding: 0.6rem 0.4rem;
    font-size: 0.75rem;
}

.avatar-responsive {
    width: 28px;
    height: 28px;
    font-size: 0.8rem;
}

.badge-table-responsive {
    font-size: 0.7rem;
    padding: 0.3rem 0.5rem;
}

.dosen-name {
    font-size: 0.8rem;
    line-height: 1.2;
}

/* ===== TABLET BREAKPOINT (768px+) ===== */
@media (min-width: 768px) {
    .dashboard-title {
        font-size: 2.25rem;
    }
    
    .lead-text {
        font-size: 1.15rem;
    }
    
    .unri-logo {
        height: 55px;
    }
    
    .card-body-responsive {
        padding: 1.75rem;
    }
    
    .icon-responsive {
        font-size: 3.25rem;
    }
    
    .card-title-responsive {
        font-size: 1.2rem;
    }
    
    .card-text-responsive {
        font-size: 0.95rem;
    }
    
    .btn-responsive {
        padding: 0.7rem 1.15rem;
        font-size: 0.975rem;
    }
    
    .stats-header-title {
        font-size: 1.4rem;
    }
    
    .stats-card-responsive {
        padding: 1.25rem;
    }
    
    .stats-number-responsive {
        font-size: 2.25rem;
    }
    
    .stats-label-responsive {
        font-size: 0.85rem;
    }
    
    .table-header-title {
        font-size: 1.2rem;
    }
    
    .badge-responsive {
        font-size: 0.875rem;
    }
    
    .header-responsive {
        padding: 1.15rem 1.35rem;
    }
    
    .table-header-cell {
        padding: 0.9rem 1.15rem;
        font-size: 0.925rem;
    }
    
    .table-cell-responsive {
        padding: 0.9rem 1.15rem;
        font-size: 0.875rem;
    }
    
    .avatar-responsive {
        width: 38px;
        height: 38px;
        font-size: 0.95rem;
    }
    
    .badge-table-responsive {
        font-size: 0.875rem;
        padding: 0.45rem 0.8rem;
    }
    
    .dosen-name {
        font-size: 0.95rem;
    }
}

/* ===== DESKTOP BREAKPOINT (992px+) ===== */
@media (min-width: 992px) {
    .dashboard-title {
        font-size: 2.5rem;
    }
    
    .lead-text {
        font-size: 1.25rem;
    }
    
    .unri-logo {
        height: 60px;
    }
    
    .card-body-responsive {
        padding: 2rem;
    }
    
    .icon-responsive {
        font-size: 3.5rem;
    }
    
    .stats-card-responsive {
        padding: 1.75rem;
    }
    
    .stats-number-responsive {
        font-size: 2.5rem;
    }
}

/* ===== HOVER EFFECTS ===== */
.hover-card {
    transition: all 0.3s ease;
    transform: translateY(0);
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
}

.icon-wrapper {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.stats-card {
    transition: all 0.3s ease;
    cursor: default;
}

.stats-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.stats-number {
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* ===== TABLE STYLING ===== */
.table th {
    border-top: none !important;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-weight: 600;
    letter-spacing: 0.5px;
}

/* ===== GRADIENT UTILS ===== */
.gradient-blue { background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); }
.gradient-purple { background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); }
.gradient-green { background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); }

/* Unified card inner padding */
.unified-card { display: flex; flex-direction: column; height: 100%; justify-content: flex-start; }
.unified-card .action-btn, .unified-card .action-btn-purple, .unified-card .action-btn-green { margin-top: auto; }

/* Action buttons */
.action-btn { background: linear-gradient(135deg,#1976d2 0%,#1565c0 100%); border:none; border-radius:8px; color:#fff; }
.action-btn:hover { filter: brightness(1.05); }
.action-btn-purple { background: linear-gradient(135deg,#7b1fa2 0%,#6a1b9a 100%); border:none; border-radius:8px; color:#fff; }
.action-btn-purple:hover { filter: brightness(1.05); }
.action-btn-green { background: linear-gradient(135deg,#388e3c 0%,#2e7d32 100%); border:none; border-radius:8px; color:#fff; }
.action-btn-green:hover { filter: brightness(1.05); }

/* ===== MOBILE OPTIMIZATIONS ===== */
@media (max-width: 767.98px) {
    .action-card {
        min-height: auto;
    }
    
    /* Hide icon animation on mobile for better performance */
    .icon-wrapper {
        animation: none;
    }
    
    /* Ensure table text wraps properly */
    .dosen-name {
        word-break: break-word;
        display: block;
    }
    
    /* Adjust table for mobile scrolling */
    .table-responsive {
        -webkit-overflow-scrolling: touch;
    }
    
    /* Alert responsive */
    .alert {
        font-size: 0.85rem;
        padding: 0.65rem 0.85rem;
    }
    
    /* Improve touch targets */
    .btn-close {
        padding: 0.5rem;
    }
    
    /* Card spacing */
    .card {
        border-radius: 10px;
    }
}

/* ===== SMALL MOBILE (< 375px) ===== */
@media (max-width: 374.98px) {
    .dashboard-title {
        font-size: 1.2rem;
    }
    
    .lead-text {
        font-size: 0.8rem;
    }
    
    .icon-responsive {
        font-size: 1.65rem;
    }
    
    .card-title-responsive {
        font-size: 0.9rem;
    }
    
    .card-text-responsive {
        font-size: 0.7rem;
    }
    
    .btn-responsive {
        font-size: 0.78rem;
        padding: 0.5rem 0.65rem;
    }
    
    .stats-number-responsive {
        font-size: 1.25rem;
    }
    
    .stats-label-responsive {
        font-size: 0.58rem;
    }
    
    .card-body-responsive {
        padding: 0.8rem;
    }
    
    .stats-card-responsive {
        padding: 0.55rem 0.35rem;
    }
}
</style>

<script>
$(document).ready(function() {
    $('#kjfdQuotasTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        pageLength: 10,
        searching: false,
        paging: false,
        info: false,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [1, 2, 3] }
        ]
    });
});
</script>
@endsection
