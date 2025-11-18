@extends('layouts.admin')

@section('content')

    <h2>Dashboard Admin</h2>
    <p>Selamat datang di halaman dashboard admin!</p>

    <!-- System Alerts -->
    @php
        $pendingProposals = \App\Models\Proposal::where('status', 'menunggu_verifikasi')->count();
        $pendingKjfd = \App\Models\Proposal::where('status', 'menunggu_verifikasi_dosen_kjfd')->count();
        $revisiProposals = \App\Models\Proposal::where('status', 'revisi')->count();
    @endphp

    @if($pendingProposals > 0 || $pendingKjfd > 0 || $revisiProposals > 0)
        <div class="row mb-3">
            <div class="col-12">
                @if($pendingProposals > 0)
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                        <strong>Perhatian!</strong> Ada <strong>{{ $pendingProposals }}</strong> proposal yang menunggu verifikasi dari Anda.
                        <a href="{{ route('admin.proposals.index') }}" class="alert-link">Lihat Sekarang</a>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($pendingKjfd > 0)
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle-fill"></i>
                        Ada <strong>{{ $pendingKjfd }}</strong> proposal sedang dalam verifikasi Dosen KJFD.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if($revisiProposals > 0)
                    <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                        <i class="bi bi-arrow-repeat"></i>
                        Ada <strong>{{ $revisiProposals }}</strong> proposal yang perlu direvisi oleh mahasiswa.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- KPI Cards -->
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-primary mb-3 shadow-sm hover-card">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-file-earmark-text" style="font-size: 3rem; opacity: 0.3; position: absolute; right: 15px;"></i>
                    <div style="position: relative; z-index: 1;">
                        <h6 class="card-title mb-1">
                            <i class="bi bi-folder2-open"></i> Total Proposal
                        </h6>
                        <h2 class="card-text mb-0 fw-bold">{{ $kpi['total'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-success mb-3 shadow-sm hover-card">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-check-circle-fill" style="font-size: 3rem; opacity: 0.3; position: absolute; right: 15px;"></i>
                    <div style="position: relative; z-index: 1;">
                        <h6 class="card-title mb-1">
                            <i class="bi bi-check-lg"></i> Disetujui
                        </h6>
                        <h2 class="card-text mb-0 fw-bold">{{ $kpi['approved'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-warning mb-3 shadow-sm hover-card">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-clock-history" style="font-size: 3rem; opacity: 0.3; position: absolute; right: 15px;"></i>
                    <div style="position: relative; z-index: 1;">
                        <h6 class="card-title mb-1">
                            <i class="bi bi-hourglass-split"></i> Menunggu
                        </h6>
                        <h2 class="card-text mb-0 fw-bold">{{ $kpi['pending'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="card text-white bg-danger mb-3 shadow-sm hover-card">
                <div class="card-body d-flex align-items-center">
                    <i class="bi bi-x-circle-fill" style="font-size: 3rem; opacity: 0.3; position: absolute; right: 15px;"></i>
                    <div style="position: relative; z-index: 1;">
                        <h6 class="card-title mb-1">
                            <i class="bi bi-x-lg"></i> Ditolak
                        </h6>
                        <h2 class="card-text mb-0 fw-bold">{{ $kpi['rejected'] ?? 0 }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Statistik Status Proposal -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0">
                            <i class="bi bi-bar-chart-fill text-primary"></i> Statistik Status Proposal
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col">
                                <div class="status-box">
                                    <i class="bi bi-hourglass-split text-warning" style="font-size: 2rem;"></i>
                                    <span class="badge bg-warning d-block mt-2">Menunggu Verifikasi</span>
                                    <h4 class="mt-2 mb-0 fw-bold">{{ $statusStats['menunggu_verifikasi'] ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="status-box">
                                    <i class="bi bi-person-check text-info" style="font-size: 2rem;"></i>
                                    <span class="badge bg-info d-block mt-2">Menunggu Verifikasi Dosen KJFD</span>
                                    <h4 class="mt-2 mb-0 fw-bold">{{ $statusStats['menunggu_verifikasi_dosen_kjfd'] ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="status-box">
                                    <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                                    <span class="badge bg-success d-block mt-2">Disetujui</span>
                                    <h4 class="mt-2 mb-0 fw-bold">{{ $statusStats['disetujui'] ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="status-box">
                                    <i class="bi bi-x-circle-fill text-danger" style="font-size: 2rem;"></i>
                                    <span class="badge bg-danger d-block mt-2">Ditolak</span>
                                    <h4 class="mt-2 mb-0 fw-bold">{{ $statusStats['ditolak'] ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="col">
                                <div class="status-box">
                                    <i class="bi bi-arrow-repeat text-secondary" style="font-size: 2rem;"></i>
                                    <span class="badge bg-secondary d-block mt-2">Revisi</span>
                                    <h4 class="mt-2 mb-0 fw-bold">{{ $statusStats['revisi'] ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Chart Proposal per Bidang Minat -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-pie-chart-fill text-primary"></i> Distribusi Proposal per Bidang Minat
                    </h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="bidangChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-graph-up text-info"></i> Tren Proposal per Bulan
                    </h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Management Statistics -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-people-fill text-success"></i> Statistik Pengguna
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <i class="bi bi-people-fill text-primary" style="font-size: 2rem;"></i>
                            <h4 class="mt-2 fw-bold">{{ $userStats['total'] }}</h4>
                            <small class="text-muted">Total User</small>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-mortarboard-fill text-success" style="font-size: 2rem;"></i>
                            <h4 class="mt-2 fw-bold">{{ $userStats['mahasiswa'] }}</h4>
                            <small class="text-muted">Mahasiswa</small>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-person-badge-fill text-info" style="font-size: 2rem;"></i>
                            <h4 class="mt-2 fw-bold">{{ $userStats['dosen_kjfd'] }}</h4>
                            <small class="text-muted">Dosen KJFD</small>
                        </div>
                        <div class="col-3">
                            <i class="bi bi-shield-fill-check text-warning" style="font-size: 2rem;"></i>
                            <h4 class="mt-2 fw-bold">{{ $userStats['admin'] }}</h4>
                            <small class="text-muted">Admin</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <span class="badge bg-success">
                                <i class="bi bi-clock"></i> Aktif 7 Hari
                            </span>
                            <h5 class="mt-2 fw-bold">{{ $userStats['active_7days'] }}</h5>
                        </div>
                        <div class="col-6">
                            <span class="badge bg-info">
                                <i class="bi bi-calendar"></i> Aktif 30 Hari
                            </span>
                            <h5 class="mt-2 fw-bold">{{ $userStats['active_30days'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-bar-chart-line-fill text-warning"></i> Pertumbuhan Pengguna
                    </h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Filter & Search Section -->
    <div class="row mt-4 mb-3">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0">
                        <i class="bi bi-funnel-fill text-primary"></i> Filter & Pencarian Proposal
                    </h6>
                </div>
                <div class="card-body">
                    <form id="filterForm" method="GET" action="{{ route('admin.dashboard') }}">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="filterStatus" class="form-label">
                                    <i class="bi bi-bookmark"></i> Status
                                </label>
                                <select name="status" id="filterStatus" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                                    <option value="menunggu_verifikasi_dosen_kjfd" {{ request('status') == 'menunggu_verifikasi_dosen_kjfd' ? 'selected' : '' }}>Menunggu Verifikasi Dosen KJFD</option>
                                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Revisi</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="filterBidang" class="form-label">
                                    <i class="bi bi-tags"></i> Bidang Minat
                                </label>
                                <select name="bidang" id="filterBidang" class="form-select">
                                    <option value="">Semua Bidang</option>
                                    @foreach($counts as $bidang => $total)
                                        <option value="{{ $bidang }}" {{ request('bidang') == $bidang ? 'selected' : '' }}>{{ $bidang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="filterDateFrom" class="form-label">
                                    <i class="bi bi-calendar-event"></i> Dari Tanggal
                                </label>
                                <input type="date" name="date_from" id="filterDateFrom" class="form-control" value="{{ request('date_from') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="filterDateTo" class="form-label">
                                    <i class="bi bi-calendar-check"></i> Sampai Tanggal
                                </label>
                                <input type="date" name="date_to" id="filterDateTo" class="form-control" value="{{ request('date_to') }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label d-block">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-10">
                                <input type="text" name="search" id="searchBox" class="form-control" placeholder="🔍 Cari judul proposal, NIM, atau nama mahasiswa..." value="{{ request('search') }}">
                            </div>
                            <div class="col-md-2">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary w-100">
                                    <i class="bi bi-x-circle"></i> Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Proposal dengan Export -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-table text-primary"></i> Daftar Proposal
                    </h5>
                    <div>
                        <button id="exportExcel" class="btn btn-success btn-sm">
                            <i class="bi bi-file-earmark-excel"></i> Export Excel
                        </button>
                        <button id="exportPDF" class="btn btn-danger btn-sm">
                            <i class="bi bi-file-earmark-pdf"></i> Export PDF
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(!empty($allProposals) && $allProposals->isNotEmpty())
                        <div class="table-responsive">
                            <table id="proposalTable" class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="bi bi-hash"></i> No</th>
                                        <th><i class="bi bi-credit-card"></i> NIM</th>
                                        <th><i class="bi bi-person"></i> Nama</th>
                                        <th><i class="bi bi-file-text"></i> Judul</th>
                                        <th><i class="bi bi-bookmark"></i> Bidang Minat</th>
                                        <th><i class="bi bi-flag"></i> Status</th>
                                        <th><i class="bi bi-calendar"></i> Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allProposals as $proposal)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $proposal->nim }}</td>
                                            <td>{{ $proposal->user->name ?? $proposal->nama_lengkap }}</td>
                                            <td>
                                                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#quickViewModal" 
                                                   data-id="{{ $proposal->id }}"
                                                   data-nim="{{ $proposal->nim }}"
                                                   data-nama="{{ $proposal->user->name ?? $proposal->nama_lengkap }}"
                                                   data-judul="{{ $proposal->judul }}"
                                                   data-bidang="{{ $proposal->bidang_minat }}"
                                                   data-status="{{ $proposal->getStatusLabel() }}"
                                                   data-tanggal="{{ $proposal->created_at->format('d M Y H:i') }}"
                                                   data-file="{{ $proposal->file_path }}"
                                                   onclick="loadQuickView(this)">
                                                    {{ $proposal->judul }}
                                                </a>
                                            </td>
                                            <td>{{ $proposal->bidang_minat }}</td>
                                            <td><span class="badge text-bg-{{ $proposal->getStatusBadgeColor() }}">{{ $proposal->getStatusLabel() }}</span></td>
                                            <td>{{ $proposal->created_at->format('d M Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem; color: #ccc;"></i>
                            <p class="text-muted mt-2">Belum ada proposal yang sesuai dengan filter.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="quickViewModalLabel">
                    <i class="bi bi-eye-fill"></i> Detail Proposal
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="bi bi-credit-card"></i> NIM:</strong> <span id="modalNim"></span></p>
                        <p><strong><i class="bi bi-person"></i> Nama:</strong> <span id="modalNama"></span></p>
                        <p><strong><i class="bi bi-bookmark"></i> Bidang Minat:</strong> <span id="modalBidang"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="bi bi-flag"></i> Status:</strong> <span id="modalStatus"></span></p>
                        <p><strong><i class="bi bi-calendar"></i> Tanggal Pengajuan:</strong> <span id="modalTanggal"></span></p>
                    </div>
                </div>
                <hr>
                <p><strong><i class="bi bi-file-text"></i> Judul Proposal:</strong></p>
                <p id="modalJudul" class="text-muted"></p>
                <hr>
                <div class="d-flex justify-content-between">
                    <a id="viewFileBtn" href="#" target="_blank" class="btn btn-primary btn-sm">
                        <i class="bi bi-file-earmark-pdf"></i> Lihat File Proposal
                    </a>
                    <a id="manageProposalBtn" href="#" class="btn btn-secondary btn-sm">
                        <i class="bi bi-gear"></i> Kelola Proposal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    /* Hover Card Effect */
    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }

    /* Status Box */
    .status-box {
        padding: 15px;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }
    .status-box:hover {
        background-color: #f8f9fa;
    }

    /* Timeline Styles */
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
        border-left: 2px solid #e9ecef;
    }
    .timeline-item:last-child {
        border-left: none;
    }
    .timeline-marker {
        position: absolute;
        left: -6px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid white;
    }
    .timeline-content {
        padding-left: 20px;
        padding-bottom: 10px;
    }

    /* Table Hover Effect */
    .table-hover tbody tr:hover {
        background-color: #f1f3f5;
        cursor: pointer;
        transition: background-color 0.2s ease;
    }

    /* Badge Animations */
    .badge {
        transition: transform 0.2s ease;
    }
    .badge:hover {
        transform: scale(1.1);
    }

    /* Loading Spinner (jika digunakan) */
    .spinner-border-sm {
        width: 1rem;
        height: 1rem;
        border-width: 0.15em;
    }

    /* Card Shadow Enhancement */
    .card.shadow-sm {
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        transition: box-shadow 0.3s ease;
    }
    .card.shadow-sm:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }

    /* Empty State Icon */
    .bi-inbox {
        animation: float 3s ease-in-out infinite;
    }
    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* Progress Bar Animation */
    .progress-bar {
        transition: width 0.6s ease;
    }

    /* Alert Animation */
    .alert {
        animation: slideInDown 0.5s ease;
    }
    @keyframes slideInDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    /* Button Hover Effects */
    .btn {
        transition: all 0.3s ease;
    }
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Form Control Focus */
    .form-control:focus, .form-select:focus {
        border-color: #4682b4;
        box-shadow: 0 0 0 0.2rem rgba(70, 130, 180, 0.25);
    }

    /* Status Badge - Text hitam untuk semua warna background */
    #proposalTable .badge {
        color: #000 !important;
    }
</style>

@push('scripts')
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<!-- SheetJS untuk Export Excel -->
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

<!-- jsPDF untuk Export PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
// Tunggu sampai semua library loaded
window.addEventListener('load', function() {
    console.log('Chart.js loaded:', typeof Chart !== 'undefined');
    
    // Initialize Charts setelah semua library siap
    initializeCharts();
});

function initializeCharts() {
    // Chart Proposal per Bidang Minat
    var bidangLabels = {!! json_encode(array_keys($counts->toArray())) !!};
    var bidangData = {!! json_encode(array_values($counts->toArray())) !!};
    
    console.log('Bidang Labels:', bidangLabels);
    console.log('Bidang Data:', bidangData);
    
    var bidangCanvas = document.getElementById('bidangChart');
    if (bidangCanvas && bidangLabels.length > 0 && bidangData.length > 0) {
        try {
            var bidangChart = new Chart(bidangCanvas, {
                type: 'pie',
                data: {
                    labels: bidangLabels,
                    datasets: [{
                        data: bidangData,
                        backgroundColor: [
                            '#007bff',
                            '#28a745', 
                            '#ffc107',
                            '#dc3545',
                            '#6c757d',
                            '#17a2b8',
                            '#e83e8c',
                            '#fd7e14'
                        ],
                        borderWidth: 2,
                        borderColor: '#fff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                font: {
                                    size: 12
                                }
                            }
                        },
                        title: {
                            display: false
                        }
                    }
                }
            });
            console.log('Bidang Chart created successfully');
        } catch (error) {
            console.error('Error creating bidang chart:', error);
            bidangCanvas.parentElement.innerHTML = '<p class="text-center text-muted">Error loading chart</p>';
        }
    } else if (bidangCanvas) {
        bidangCanvas.parentElement.innerHTML = '<p class="text-center text-muted py-5">Belum ada data proposal</p>';
    }

    // Chart Tren Proposal per Bulan
    var trendLabels = {!! json_encode($trend['labels'] ?? []) !!};
    var trendData = {!! json_encode($trend['data'] ?? []) !!};
    
    console.log('Trend Labels:', trendLabels);
    console.log('Trend Data:', trendData);
    
    var trendCanvas = document.getElementById('trendChart');
    if (trendCanvas && trendLabels.length > 0 && trendData.length > 0) {
        try {
            var trendChart = new Chart(trendCanvas, {
                type: 'line',
                data: {
                    labels: trendLabels,
                    datasets: [{
                        label: 'Proposal Masuk',
                        data: trendData,
                        borderColor: '#007bff',
                        backgroundColor: 'rgba(0,123,255,0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 4,
                        pointBackgroundColor: '#007bff',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { 
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            console.log('Trend Chart created successfully');
        } catch (error) {
            console.error('Error creating trend chart:', error);
            trendCanvas.parentElement.innerHTML = '<p class="text-center text-muted">Error loading chart</p>';
        }
    } else if (trendCanvas) {
        trendCanvas.parentElement.innerHTML = '<p class="text-center text-muted py-5">Belum ada data tren proposal</p>';
    }

    // Chart User Growth
    var userGrowthLabels = {!! json_encode($userGrowth['labels'] ?? []) !!};
    var userGrowthData = {!! json_encode($userGrowth['data'] ?? []) !!};
    
    console.log('User Growth Labels:', userGrowthLabels);
    console.log('User Growth Data:', userGrowthData);
    
    var userGrowthCanvas = document.getElementById('userGrowthChart');
    if (userGrowthCanvas && userGrowthLabels.length > 0 && userGrowthData.length > 0) {
        try {
            var userGrowthChart = new Chart(userGrowthCanvas, {
                type: 'bar',
                data: {
                    labels: userGrowthLabels,
                    datasets: [{
                        label: 'User Baru',
                        data: userGrowthData,
                        backgroundColor: 'rgba(40, 167, 69, 0.8)',
                        borderColor: '#28a745',
                        borderWidth: 2,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { 
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0
                            },
                            grid: {
                                color: 'rgba(0,0,0,0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            console.log('User Growth Chart created successfully');
        } catch (error) {
            console.error('Error creating user growth chart:', error);
            userGrowthCanvas.parentElement.innerHTML = '<p class="text-center text-muted">Error loading chart</p>';
        }
    } else if (userGrowthCanvas) {
        userGrowthCanvas.parentElement.innerHTML = '<p class="text-center text-muted py-5">Belum ada data pertumbuhan pengguna</p>';
    }
}

$(document).ready(function() {
    // Initialize DataTable untuk tabel proposal
    var proposalTable = $('#proposalTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[6, 'desc']],
        searching: false, // Menggunakan search box kustom
        paging: true,
        info: true,
        dom: 'Bfrtip',
        buttons: []
    });


    function stripHtmlToText(html) {
        return $('<div>').html(html).text().trim();
    }

    function buildAoAFromDataTable(dt) {
        var header = ['No', 'NIM', 'Nama', 'Judul', 'Bidang Minat', 'Status', 'Tanggal'];
        var body = [];
        var index = 1;
        dt.rows({ search: 'applied', order: 'applied' }).every(function() {
            var data = this.data();
            // data is an array of column HTML/text since table sourced from DOM
            var nim = stripHtmlToText(data[1] ?? '');
            var nama = stripHtmlToText(data[2] ?? '');
            var judul = stripHtmlToText(data[3] ?? '');
            var bidang = stripHtmlToText(data[4] ?? '');
            var status = stripHtmlToText(data[5] ?? '');
            var tanggal = stripHtmlToText(data[6] ?? '');
            body.push([index++, nim, nama, judul, bidang, status, tanggal]);
        });
        return { header: header, body: body };
    }

    // Export to Excel (semua baris hasil filter)
    $('#exportExcel').on('click', function(e) {
        e.preventDefault();
        try {
            if (typeof XLSX === 'undefined') {
                console.error('SheetJS (XLSX) not loaded');
                alert('Export Excel gagal: library belum termuat. Coba muat ulang halaman.');
                return;
            }
            var aoa = buildAoAFromDataTable(proposalTable);
            var wsData = [aoa.header].concat(aoa.body);
            var wb = XLSX.utils.book_new();
            var ws = XLSX.utils.aoa_to_sheet(wsData);
            XLSX.utils.book_append_sheet(wb, ws, 'Proposal');
            XLSX.writeFile(wb, 'Daftar_Proposal_' + new Date().toISOString().slice(0,10) + '.xlsx');
        } catch (err) {
            console.error('Export Excel error:', err);
            alert('Terjadi kesalahan saat export Excel.');
        }
    });

    // Export to PDF (semua baris hasil filter)
    $('#exportPDF').on('click', function(e) {
        e.preventDefault();
        try {
            if (!window.jspdf || !window.jspdf.jsPDF) {
                console.error('jsPDF not loaded');
                alert('Export PDF gagal: library belum termuat. Coba muat ulang halaman.');
                return;
            }
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            doc.text('Daftar Proposal', 14, 15);

            var aoa = buildAoAFromDataTable(proposalTable);
            doc.autoTable({
                head: [aoa.header],
                body: aoa.body,
                startY: 20,
                styles: { fontSize: 8 },
                headStyles: { fillColor: [0, 123, 255] }
            });

            doc.save('Daftar_Proposal_' + new Date().toISOString().slice(0,10) + '.pdf');
        } catch (err) {
            console.error('Export PDF error:', err);
            alert('Terjadi kesalahan saat export PDF.');
        }
    });
});

// Function to load quick view modal
function loadQuickView(element) {
    document.getElementById('modalNim').textContent = element.getAttribute('data-nim');
    document.getElementById('modalNama').textContent = element.getAttribute('data-nama');
    document.getElementById('modalJudul').textContent = element.getAttribute('data-judul');
    document.getElementById('modalBidang').textContent = element.getAttribute('data-bidang');
    document.getElementById('modalStatus').innerHTML = '<span class="badge text-bg-primary">' + element.getAttribute('data-status') + '</span>';
    document.getElementById('modalTanggal').textContent = element.getAttribute('data-tanggal');
    
    const proposalId = element.getAttribute('data-id');
    document.getElementById('viewFileBtn').href = '{{ route("admin.proposals.view-file", ":id") }}'.replace(':id', proposalId);
    document.getElementById('manageProposalBtn').href = '{{ route("admin.proposals.index") }}?id=' + proposalId;
}
</script>
@endpush
@endsection
