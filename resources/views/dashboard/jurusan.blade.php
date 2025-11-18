@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Ketua Jurusan</h1>
        <div class="d-none d-sm-inline-block">
            <span class="mr-2 d-none d-lg-inline text-gray-600">
                Selamat datang, <strong>{{ Auth::user()->name }}</strong>
            </span>
        </div>
    </div>

    <!-- Ringkasan Total -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Proposal::count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Proposal Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Proposal::where('status', 'disetujui')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Proposal::whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ \App\Models\Proposal::where('status', 'ditolak')->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Bidang KJFD -->
    <div class="row">
        <!-- Business Intelligence -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-primary">
                    <h6 class="m-0 font-weight-bold text-white">Business Intelligence</h6>
                    <div class="dropdown no-arrow">
                        <a href="{{ route('jurusan.proposals.index', 'bi') }}" class="text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $biProposals = \App\Models\Proposal::where('bidang_minat', 'Business Intelligence')->get();
                        $biTotal = $biProposals->count();
                        $biApproved = $biProposals->where('status', 'disetujui')->count();
                        $biPending = $biProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                        $biRejected = $biProposals->where('status', 'ditolak')->count();
                    @endphp
                    <div class="no-gutters align-items-center">
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $biTotal }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $biApproved }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $biPending }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $biRejected }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Engineering -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-success">
                    <h6 class="m-0 font-weight-bold text-white">Data Engineering</h6>
                    <div class="dropdown no-arrow">
                        <a href="{{ route('jurusan.proposals.index', 'de') }}" class="text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $deProposals = \App\Models\Proposal::where('bidang_minat', 'Data Engineering')->get();
                        $deTotal = $deProposals->count();
                        $deApproved = $deProposals->where('status', 'disetujui')->count();
                        $dePending = $deProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                        $deRejected = $deProposals->where('status', 'ditolak')->count();
                    @endphp
                    <div class="no-gutters align-items-center">
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deTotal }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deApproved }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dePending }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $deRejected }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Management -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-info">
                    <h6 class="m-0 font-weight-bold text-white">Information Management</h6>
                    <div class="dropdown no-arrow">
                        <a href="{{ route('jurusan.proposals.index', 'im') }}" class="text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $imProposals = \App\Models\Proposal::where('bidang_minat', 'Information Management')->get();
                        $imTotal = $imProposals->count();
                        $imApproved = $imProposals->where('status', 'disetujui')->count();
                        $imPending = $imProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                        $imRejected = $imProposals->where('status', 'ditolak')->count();
                    @endphp
                    <div class="no-gutters align-items-center">
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $imTotal }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $imApproved }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $imPending }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $imRejected }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Information Retrieval -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-warning">
                    <h6 class="m-0 font-weight-bold text-white">Information Retrieval</h6>
                    <div class="dropdown no-arrow">
                        <a href="{{ route('jurusan.proposals.index', 'ir') }}" class="text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @php
                        $irProposals = \App\Models\Proposal::where('bidang_minat', 'Information Retrieval')->get();
                        $irTotal = $irProposals->count();
                        $irApproved = $irProposals->where('status', 'disetujui')->count();
                        $irPending = $irProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                        $irRejected = $irProposals->where('status', 'ditolak')->count();
                    @endphp
                    <div class="no-gutters align-items-center">
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $irTotal }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $irApproved }}</div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $irPending }}</div>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $irRejected }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Charts & Activity Feed -->
    <div class="row mt-4">
        <!-- Grafik Distribusi Status -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-pie"></i> Distribusi Status Proposal
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height:250px;">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="mt-3 small text-center">
                        <span class="mr-3"><i class="fas fa-circle text-success"></i> Disetujui</span>
                        <span class="mr-3"><i class="fas fa-circle text-info"></i> Proses</span>
                        <span class="mr-3"><i class="fas fa-circle text-warning"></i> Menunggu</span>
                        <span><i class="fas fa-circle text-danger"></i> Ditolak</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity Feed -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-history"></i> Aktivitas Terbaru
                    </h6>
                    <a href="{{ route('jurusan.inbox.index') }}" class="btn btn-sm btn-primary">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body" style="max-height: 320px; overflow-y: auto;">
                    @php
                        $recentActivities = \App\Models\Proposal::with('user')
                            ->orderBy('updated_at', 'desc')
                            ->limit(8)
                            ->get();
                    @endphp
                    
                    @forelse($recentActivities as $activity)
                        <div class="d-flex align-items-start mb-3 pb-3 border-bottom">
                            <div class="mr-3">
                                @if($activity->status === 'disetujui')
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                @elseif($activity->status === 'ditolak')
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-times text-white"></i>
                                    </div>
                                @elseif($activity->status === 'revisi')
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-redo text-white"></i>
                                    </div>
                                @else
                                    <div class="icon-circle bg-info">
                                        <i class="fas fa-clock text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="font-weight-bold text-gray-800">{{ $activity->user->name }}</div>
                                <div class="small text-gray-600">{{ Str::limit($activity->judul, 50) }}</div>
                                <div class="small">
                                    <span class="badge text-bg-{{ $activity->getStatusBadgeColor() }}">
                                        {{ $activity->getStatusLabel() }}
                                    </span>
                                    <span class="text-muted ml-2">
                                        <i class="far fa-clock"></i> {{ $activity->updated_at->diffForHumans() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>Belum ada aktivitas</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Aging Alerts & Processing Time -->
    <div class="row mt-4">
        <!-- Aging Proposals Alert -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow border-left-danger h-100">
                <div class="card-header bg-gradient-danger py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-exclamation-triangle"></i> Proposal Aging (>3 Hari)
                    </h6>
                </div>
                <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                    @php
                        $agingProposals = \App\Models\Proposal::with('user')
                            ->needsKetuaAction()
                            ->aging(3)
                            ->orderBy('created_at', 'asc')
                            ->limit(5)
                            ->get();
                    @endphp
                    
                    @forelse($agingProposals as $aging)
                        <div class="alert alert-danger mb-2 d-flex align-items-center justify-content-between">
                            <div>
                                <div class="font-weight-bold">{{ $aging->user->name }}</div>
                                <div class="small">{{ Str::limit($aging->judul, 40) }}</div>
                                <div class="small text-muted">
                                    <i class="fas fa-calendar-times"></i> {{ $aging->getDaysSinceSubmission() }} hari yang lalu
                                </div>
                            </div>
                            <a href="{{ route('jurusan.inbox.show', $aging->id) }}" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                            <p>Tidak ada proposal yang aging</p>
                            <small>Semua proposal diproses dengan baik!</small>
                        </div>
                    @endforelse
                    
                    @if($agingProposals->count() > 0)
                        <div class="text-center mt-3">
                            <a href="{{ route('jurusan.inbox.index', ['aging' => 3]) }}" class="btn btn-sm btn-danger">
                                Lihat Semua ({{ \App\Models\Proposal::needsKetuaAction()->aging(3)->count() }})
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Average Processing Time -->
        <div class="col-xl-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-gradient-info">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-tachometer-alt"></i> Waktu Pemrosesan Rata-rata
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $processedProposals = \App\Models\Proposal::whereIn('status', ['disetujui', 'ditolak'])->get();
                        $avgDays = $processedProposals->count() > 0 
                            ? round($processedProposals->avg(function($p) {
                                return $p->created_at->diffInDays($p->updated_at);
                            }), 1)
                            : 0;
                        
                        // Breakdown by status
                        $approvedProposals = \App\Models\Proposal::where('status', 'disetujui')->get();
                        $avgApproved = $approvedProposals->count() > 0
                            ? round($approvedProposals->avg(function($p) {
                                return $p->created_at->diffInDays($p->updated_at);
                            }), 1)
                            : 0;
                            
                        $rejectedProposals = \App\Models\Proposal::where('status', 'ditolak')->get();
                        $avgRejected = $rejectedProposals->count() > 0
                            ? round($rejectedProposals->avg(function($p) {
                                return $p->created_at->diffInDays($p->updated_at);
                            }), 1)
                            : 0;
                    @endphp
                    
                    <div class="text-center mb-4">
                        <div class="display-4 font-weight-bold text-info">{{ $avgDays }}</div>
                        <div class="text-muted">Hari (Overall)</div>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6 border-right">
                            <div class="h3 font-weight-bold text-success mb-0">{{ $avgApproved }}</div>
                            <div class="small text-muted">Hari (Disetujui)</div>
                            <div class="mt-2">
                                <i class="fas fa-check-circle fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="h3 font-weight-bold text-danger mb-0">{{ $avgRejected }}</div>
                            <div class="small text-muted">Hari (Ditolak)</div>
                            <div class="mt-2">
                                <i class="fas fa-times-circle fa-2x text-danger"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-light mt-3 mb-0">
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> 
                            Dihitung dari waktu pengajuan hingga keputusan final
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<!-- Font Awesome untuk icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- Custom CSS untuk card effects -->
<style>
.border-left-primary {
    border-left: .25rem solid #4e73df!important;
}
.border-left-success {
    border-left: .25rem solid #1cc88a!important;
}
.border-left-info {
    border-left: .25rem solid #36b9cc!important;
}
.border-left-warning {
    border-left: .25rem solid #f6c23e!important;
}
.border-left-danger {
    border-left: .25rem solid #e74a3b!important;
}
.card {
    transition: transform .2s;
}
.card:hover {
    transform: translateY(-5px);
}
.text-xs {
    font-size: .7rem;
}
.card-header {
    transition: all .2s;
}
.card:hover .card-header {
    box-shadow: 0 .15rem 1.75rem 0 rgba(58,59,69,.15);
}

/* Activity Feed Styles */
.icon-circle {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Removed custom badge-* colors; using Bootstrap contextual text-bg-* classes now */

/* Gradient headers */
.bg-gradient-danger {
    background: linear-gradient(180deg, #e74a3b 10%, #be2617 100%);
    background-size: cover;
}
.bg-gradient-info {
    background: linear-gradient(180deg, #36b9cc 10%, #258391 100%);
    background-size: cover;
}

/* Scrollbar custom */
.card-body::-webkit-scrollbar {
    width: 6px;
}
.card-body::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.card-body::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 3px;
}
.card-body::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk Pie Chart
    @php
        $totalProposals = \App\Models\Proposal::count();
        $disetujui = \App\Models\Proposal::where('status', 'disetujui')->count();
        $menungguVerifikasi = \App\Models\Proposal::where('status', 'menunggu_verifikasi')->count();
        $menungguKjfd = \App\Models\Proposal::where('status', 'menunggu_verifikasi_dosen_kjfd')->count();
        $revisi = \App\Models\Proposal::where('status', 'revisi')->count();
        $ditolak = \App\Models\Proposal::where('status', 'ditolak')->count();
        $dalamProses = $menungguVerifikasi + $menungguKjfd + $revisi;
    @endphp
    
    const ctx = document.getElementById('statusChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Disetujui', 'Dalam Proses', 'Menunggu Verifikasi', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $disetujui }},
                        {{ $dalamProses }},
                        {{ $menungguVerifikasi }},
                        {{ $ditolak }}
                    ],
                    backgroundColor: [
                        '#1cc88a',  // success
                        '#36b9cc',  // info
                        '#f6c23e',  // warning
                        '#e74a3b'   // danger
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                let value = context.parsed || 0;
                                let total = {{ $totalProposals }};
                                let percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return label + ': ' + value + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }
});
</script>
@endsection
