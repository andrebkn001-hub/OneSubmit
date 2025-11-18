@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-inbox-fill text-primary me-2"></i>Inbox Aksi Saya
            </h1>
            <p class="text-muted small mb-0">Proposal yang membutuhkan perhatian Ketua Jurusan</p>
        </div>
        <a href="{{ route('jurusan.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Butuh Aksi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-inbox fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Menunggu Verifikasi Admin
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['waiting_verification'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Menunggu Verif. KJFD
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['waiting_kjfd'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Perlu Revisi
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['needs_revision'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-arrow-repeat fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-funnel"></i> Filter & Pencarian
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('jurusan.inbox.index') }}" class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Cari Proposal</label>
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Judul, NIM, atau Nama..." 
                           value="{{ request('search') }}">
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="menunggu_verifikasi" {{ request('status') == 'menunggu_verifikasi' ? 'selected' : '' }}>
                            Menunggu Verifikasi
                        </option>
                        <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>
                            Perlu Revisi
                        </option>
                    </select>
                </div>

                <!-- Bidang Minat Filter -->
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Bidang Minat</label>
                    <select name="bidang" class="form-select form-select-sm">
                        <option value="">Semua Bidang</option>
                        <option value="Business Intelligence" {{ request('bidang') == 'Business Intelligence' ? 'selected' : '' }}>
                            Business Intelligence
                        </option>
                        <option value="Data Engineering" {{ request('bidang') == 'Data Engineering' ? 'selected' : '' }}>
                            Data Engineering
                        </option>
                        <option value="Information Management" {{ request('bidang') == 'Information Management' ? 'selected' : '' }}>
                            Information Management
                        </option>
                        <option value="Information Retrieval" {{ request('bidang') == 'Information Retrieval' ? 'selected' : '' }}>
                            Information Retrieval
                        </option>
                    </select>
                </div>

                <!-- Aging Filter -->
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Aging</label>
                    <select name="aging" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <option value="3" {{ request('aging') == '3' ? 'selected' : '' }}>&gt; 3 hari</option>
                        <option value="7" {{ request('aging') == '7' ? 'selected' : '' }}>&gt; 7 hari</option>
                        <option value="14" {{ request('aging') == '14' ? 'selected' : '' }}>&gt; 14 hari</option>
                    </select>
                </div>

                <!-- Submit Buttons -->
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            
            @if(request()->hasAny(['search', 'status', 'bidang', 'aging']))
                <div class="mt-2">
                    <a href="{{ route('jurusan.inbox.index') }}" class="btn btn-link btn-sm text-decoration-none">
                        <i class="bi bi-x-circle"></i> Reset Filter
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Proposals Table -->
    <div class="card shadow">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-ul"></i> Daftar Proposal ({{ $proposals->total() }})
            </h6>
            <div class="btn-group btn-group-sm">
                <a href="{{ route('jurusan.inbox.index', array_merge(request()->all(), ['sort' => 'oldest'])) }}" 
                   class="btn btn-outline-secondary {{ request('sort', 'oldest') === 'oldest' ? 'active' : '' }}">
                    <i class="bi bi-sort-up"></i> Terlama
                </a>
                <a href="{{ route('jurusan.inbox.index', array_merge(request()->all(), ['sort' => 'newest'])) }}" 
                   class="btn btn-outline-secondary {{ request('sort') === 'newest' ? 'active' : '' }}">
                    <i class="bi bi-sort-down"></i> Terbaru
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($proposals->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">NIM</th>
                                <th width="15%">Nama</th>
                                <th width="25%">Judul</th>
                                <th width="15%">Bidang Minat</th>
                                <th width="10%">Status</th>
                                <th width="10%">Diajukan</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposals as $index => $proposal)
                                <tr class="{{ $proposal->isAging() ? 'table-warning' : '' }}">
                                    <td class="text-center">{{ $proposals->firstItem() + $index }}</td>
                                    <td>{{ $proposal->nim }}</td>
                                    <td>{{ $proposal->nama_lengkap }}</td>
                                    <td>
                                        {{ Str::limit($proposal->judul, 50) }}
                                        @if($proposal->isAging())
                                            <span class="badge bg-danger ms-1" title="Menunggu lebih dari 3 hari">
                                                <i class="bi bi-exclamation-triangle"></i> {{ $proposal->getDaysSinceSubmission() }} hari
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary">{{ $proposal->bidang_minat }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $proposal->getStatusBadgeColor() }}">
                                            {{ $proposal->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <small>{{ $proposal->created_at->format('d M Y') }}</small>
                                        <br>
                                        <small class="text-muted">{{ $proposal->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td class="d-flex gap-1">
                                        <!-- Lihat Detail Proposal (ikon mata) -->
                                        <a href="{{ route('jurusan.inbox.show', $proposal->id) }}"
                                           class="btn btn-sm btn-primary"
                                           title="Lihat detail proposal">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Kirim Notifikasi (ikon bel) -->
                                        <form method="POST" action="{{ route('jurusan.inbox.notify', $proposal->id) }}" id="notify-form-{{ $proposal->id }}">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    title="Kirim notifikasi ke role terkait"
                                                    onclick="showNotifyModal({{ $proposal->id }}, '{{ addslashes($proposal->judul_proposal) }}')">
                                                <i class="bi bi-bell"></i>
                                            </button>
                                        </form>

                                        @php
                                            // Map bidang minat ke kode singkat yang dikenali controller
                                            $bidangCode = match($proposal->bidang_minat) {
                                                'Business Intelligence' => 'bi',
                                                'Data Engineering' => 'de',
                                                'Information Management' => 'im',
                                                'Information Retrieval' => 'ir',
                                                default => strtolower(str_replace(' ', '-', $proposal->bidang_minat))
                                            };
                                        @endphp
                                        <!-- Buka Daftar Bidang (opsional) -->
                                        <a href="{{ route('jurusan.proposals.index', $bidangCode) }}" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           title="Buka daftar proposal bidang ini">
                                            <i class="bi bi-list-task"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Menampilkan {{ $proposals->firstItem() }} - {{ $proposals->lastItem() }} dari {{ $proposals->total() }} proposal
                    </div>
                    <div>
                        {{ $proposals->withQueryString()->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Tidak ada proposal yang butuh aksi saat ini</h5>
                    <p class="text-muted">Semua proposal sudah diproses atau tidak ada filter yang cocok.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Kirim Notifikasi -->
<div class="modal fade" id="notifyModal" tabindex="-1" aria-labelledby="notifyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-warning text-white border-0">
                <h5 class="modal-title" id="notifyModalLabel">
                    <i class="bi bi-bell-fill me-2"></i>Konfirmasi Kirim Notifikasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <div class="icon-wrapper mb-3">
                        <i class="bi bi-send-check display-1 text-warning"></i>
                    </div>
                    <h6 class="fw-bold mb-3">Kirim Notifikasi ke Role Terkait?</h6>
                    <p class="text-muted mb-2">Anda akan mengirim notifikasi untuk proposal:</p>
                    <div class="alert alert-light border">
                        <strong id="proposalTitle" class="text-primary"></strong>
                    </div>
                </div>
                <div class="alert alert-info border-0 d-flex align-items-start">
                    <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                    <div>
                        <small>
                            Notifikasi akan dikirim ke semua role yang relevan dengan proposal ini sesuai dengan bidang minat dan status proposal.
                        </small>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i>Batal
                </button>
                <button type="button" class="btn btn-warning" onclick="submitNotifyForm()">
                    <i class="bi bi-send-fill me-1"></i>Ya, Kirim Notifikasi
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Styles -->
<style>
.border-left-primary {
    border-left: .25rem solid #4e73df!important;
}
.border-left-warning {
    border-left: .25rem solid #f6c23e!important;
}
.border-left-info {
    border-left: .25rem solid #36b9cc!important;
}
.border-left-danger {
    border-left: .25rem solid #e74a3b!important;
}
.text-xs {
    font-size: .7rem;
}
.card {
    transition: transform .2s;
}
.table-warning {
    background-color: #fff3cd !important;
}

/* Modal Styles */
#notifyModal .modal-content {
    border-radius: 15px;
    overflow: hidden;
}

#notifyModal .modal-header {
    background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%);
}

#notifyModal .icon-wrapper {
    animation: pulse 2s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

#notifyModal .btn-warning {
    background: linear-gradient(135deg, #f6c23e 0%, #f4b619 100%);
    border: none;
    transition: all 0.3s ease;
}

#notifyModal .btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(246, 194, 62, 0.4);
}

#notifyModal .btn-secondary {
    transition: all 0.3s ease;
}

#notifyModal .btn-secondary:hover {
    transform: translateY(-2px);
}
</style>

<script>
let currentProposalId = null;

function showNotifyModal(proposalId, proposalTitle) {
    currentProposalId = proposalId;
    document.getElementById('proposalTitle').textContent = proposalTitle;
    const modal = new bootstrap.Modal(document.getElementById('notifyModal'));
    modal.show();
}

function submitNotifyForm() {
    if (currentProposalId) {
        document.getElementById('notify-form-' + currentProposalId).submit();
    }
}
</script>
@endsection
