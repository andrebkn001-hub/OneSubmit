@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-primary mb-3" style="color: #1e90ff !important;">
                    <i class="bi bi-speedometer2 me-3"></i>Dashboard Mahasiswa
                </h1>
                <p class="lead text-muted">Selamat datang, <strong class="text-primary">{{ Auth::user()->name }}</strong></p>
                <div class="mt-4">
                    <img src="{{ asset('images/unri.png') }}" alt="UNRI Logo" class="img-fluid" style="height: 60px; opacity: 0.8;">
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Action Cards -->
    <div class="row g-4 mb-5">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-lg hover-card" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-4">
                        <i class="bi bi-plus-circle-fill fa-4x" style="color: #1976d2;"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-3" style="color: #1565c0;">Ajukan Proposal Baru</h5>
                    <p class="card-text text-muted mb-4">Buat pengajuan proposal tugas akhir baru dengan mudah dan cepat.</p>
                    <a href="{{ route('mahasiswa.proposal.create') }}" class="btn btn-primary btn-lg w-100 fw-bold" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border: none; border-radius: 10px;">
                        <i class="bi bi-plus-circle me-2"></i>Ajukan Proposal
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-lg hover-card" style="background: linear-gradient(135deg, #f3e5f5 0%, #e1bee7 100%); border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-4">
                        <i class="bi bi-list-check fa-4x" style="color: #7b1fa2;"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-3" style="color: #6a1b9a;">Lihat Status Proposal</h5>
                    <p class="card-text text-muted mb-4">Pantau status proposal yang sudah Anda ajukan secara real-time.</p>
                    <a href="{{ route('mahasiswa.status') }}" class="btn btn-primary btn-lg w-100 fw-bold" style="background: linear-gradient(135deg, #7b1fa2 0%, #6a1b9a 100%); border: none; border-radius: 10px;">
                        <i class="bi bi-eye me-2"></i>Lihat Status
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-lg hover-card" style="background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%); border-radius: 15px;">
                <div class="card-body text-center p-4">
                    <div class="icon-wrapper mb-4">
                        <i class="bi bi-person-fill fa-4x" style="color: #388e3c;"></i>
                    </div>
                    <h5 class="card-title fw-bold mb-3" style="color: #2e7d32;">Kelola Profil</h5>
                    <p class="card-text text-muted mb-4">Update informasi profil dan data pribadi Anda dengan lengkap.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-lg w-100 fw-bold" style="background: linear-gradient(135deg, #388e3c 0%, #2e7d32 100%); border: none; border-radius: 10px;">
                        <i class="bi bi-pencil me-2"></i>Edit Profil
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                <div class="card-header border-0 bg-transparent">
                    <h4 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-bar-chart-line me-2"></i>Ringkasan Proposal
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-6 col-md-3">
                            <div class="stats-card text-center p-4 rounded-3" style="background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%); border: 2px solid #ffc107;">
                                <div class="stats-number fw-bold fs-1 mb-2" style="color: #856404;">
                                    {{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'menunggu_verifikasi')->count() }}
                                </div>
                                <div class="stats-label small fw-semibold text-muted">Menunggu Verifikasi</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card text-center p-4 rounded-3" style="background: linear-gradient(135deg, #cce5ff 0%, #99d6ff 100%); border: 2px solid #0d6efd;">
                                <div class="stats-number fw-bold fs-1 mb-2" style="color: #0a58ca;">
                                    {{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'menunggu_verifikasi_dosen_kjfd')->count() }}
                                </div>
                                <div class="stats-label small fw-semibold text-muted">Verifikasi KJFD</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card text-center p-4 rounded-3" style="background: linear-gradient(135deg, #d1ecf1 0%, #a3daff 100%); border: 2px solid #198754;">
                                <div class="stats-number fw-bold fs-1 mb-2" style="color: #0f5132;">
                                    {{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'disetujui')->count() }}
                                </div>
                                <div class="stats-label small fw-semibold text-muted">Disetujui</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="stats-card text-center p-4 rounded-3" style="background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%); border: 2px solid #dc3545;">
                                <div class="stats-number fw-bold fs-1 mb-2" style="color: #b02a37;">
                                    {{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'ditolak')->count() }}
                                </div>
                                <div class="stats-label small fw-semibold text-muted">Ditolak</div>
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
                <div class="card-header border-0 bg-primary text-white" style="border-radius: 15px 15px 0 0 !important; background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%) !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fw-bold">
                            <i class="bi bi-people-fill me-2"></i>Kuota Proposal per Bidang KJFD
                        </h4>
                        <div class="badge bg-light text-primary fs-6 px-3 py-2">
                            <i class="bi bi-info-circle me-1"></i>Kuota dinamis per bidang sesuai pengaturan Admin
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
                            <table class="table table-hover mb-0">
                                <thead class="table-primary" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                    <tr>
                                        <th class="border-0 fw-bold py-3 px-4">
                                            <i class="bi bi-person-badge me-2"></i>Nama Dosen KJFD
                                        </th>
                                        <th class="border-0 fw-bold py-3 px-4 text-center">
                                            <i class="bi bi-dash-circle me-2"></i>Kuota
                                        </th>
                                        <th class="border-0 fw-bold py-3 px-4 text-center">
                                            <i class="bi bi-check-circle me-2"></i>Sudah ACC
                                        </th>
                                        <th class="border-0 fw-bold py-3 px-4 text-center">
                                            <i class="bi bi-arrow-right-circle me-2"></i>Sisa Kuota
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
                                            <td class="py-3 px-4 fw-semibold">
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle me-3" style="width: 40px; height: 40px; background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                        {{ substr($kjfd->name, 0, 1) }}
                                                    </div>
                                                    {{ $kjfd->name }}
                                                </div>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); border-radius: 20px;">
                                                    {{ $limit }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #198754 0%, #157347 100%); border-radius: 20px;">
                                                    {{ $accepted }}
                                                </span>
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if($remaining > 0)
                                                    <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%); border-radius: 20px;">
                                                        {{ $remaining }}
                                                    </span>
                                                @else
                                                    <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 20px;">
                                                        <i class="bi bi-x-circle me-1"></i>Penuh
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

.table th {
    border-top: none !important;
    font-size: 0.95rem;
}

.table td {
    vertical-align: middle;
    font-size: 0.9rem;
}

.badge {
    font-weight: 600;
    letter-spacing: 0.5px;
}
</style>
@endsection
