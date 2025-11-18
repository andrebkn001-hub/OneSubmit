

<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <!-- Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="bi bi-inbox-fill text-primary me-2"></i>Inbox Aksi Saya
            </h1>
            <p class="text-muted small mb-0">Proposal yang membutuhkan perhatian Ketua Jurusan</p>
        </div>
        <a href="<?php echo e(route('jurusan.dashboard')); ?>" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle-fill me-2"></i><?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session('warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?php echo e(session('warning')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if(session('info')): ?>
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <i class="bi bi-info-circle-fill me-2"></i><?php echo e(session('info')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['total']); ?></div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['waiting_verification']); ?></div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['waiting_kjfd']); ?></div>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($stats['needs_revision']); ?></div>
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
            <form method="GET" action="<?php echo e(route('jurusan.inbox.index')); ?>" class="row g-3">
                <!-- Search -->
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Cari Proposal</label>
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Judul, NIM, atau Nama..." 
                           value="<?php echo e(request('search')); ?>">
                </div>

                <!-- Status Filter -->
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="menunggu_verifikasi" <?php echo e(request('status') == 'menunggu_verifikasi' ? 'selected' : ''); ?>>
                            Menunggu Verifikasi
                        </option>
                        <option value="revisi" <?php echo e(request('status') == 'revisi' ? 'selected' : ''); ?>>
                            Perlu Revisi
                        </option>
                    </select>
                </div>

                <!-- Bidang Minat Filter -->
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Bidang Minat</label>
                    <select name="bidang" class="form-select form-select-sm">
                        <option value="">Semua Bidang</option>
                        <option value="Business Intelligence" <?php echo e(request('bidang') == 'Business Intelligence' ? 'selected' : ''); ?>>
                            Business Intelligence
                        </option>
                        <option value="Data Engineering" <?php echo e(request('bidang') == 'Data Engineering' ? 'selected' : ''); ?>>
                            Data Engineering
                        </option>
                        <option value="Information Management" <?php echo e(request('bidang') == 'Information Management' ? 'selected' : ''); ?>>
                            Information Management
                        </option>
                        <option value="Information Retrieval" <?php echo e(request('bidang') == 'Information Retrieval' ? 'selected' : ''); ?>>
                            Information Retrieval
                        </option>
                    </select>
                </div>

                <!-- Aging Filter -->
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Aging</label>
                    <select name="aging" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        <option value="3" <?php echo e(request('aging') == '3' ? 'selected' : ''); ?>>&gt; 3 hari</option>
                        <option value="7" <?php echo e(request('aging') == '7' ? 'selected' : ''); ?>>&gt; 7 hari</option>
                        <option value="14" <?php echo e(request('aging') == '14' ? 'selected' : ''); ?>>&gt; 14 hari</option>
                    </select>
                </div>

                <!-- Submit Buttons -->
                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            
            <?php if(request()->hasAny(['search', 'status', 'bidang', 'aging'])): ?>
                <div class="mt-2">
                    <a href="<?php echo e(route('jurusan.inbox.index')); ?>" class="btn btn-link btn-sm text-decoration-none">
                        <i class="bi bi-x-circle"></i> Reset Filter
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Proposals Table -->
    <div class="card shadow">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="bi bi-list-ul"></i> Daftar Proposal (<?php echo e($proposals->total()); ?>)
            </h6>
            <div class="btn-group btn-group-sm">
                <a href="<?php echo e(route('jurusan.inbox.index', array_merge(request()->all(), ['sort' => 'oldest']))); ?>" 
                   class="btn btn-outline-secondary <?php echo e(request('sort', 'oldest') === 'oldest' ? 'active' : ''); ?>">
                    <i class="bi bi-sort-up"></i> Terlama
                </a>
                <a href="<?php echo e(route('jurusan.inbox.index', array_merge(request()->all(), ['sort' => 'newest']))); ?>" 
                   class="btn btn-outline-secondary <?php echo e(request('sort') === 'newest' ? 'active' : ''); ?>">
                    <i class="bi bi-sort-down"></i> Terbaru
                </a>
            </div>
        </div>
        <div class="card-body">
            <?php if($proposals->count() > 0): ?>
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
                            <?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="<?php echo e($proposal->isAging() ? 'table-warning' : ''); ?>">
                                    <td class="text-center"><?php echo e($proposals->firstItem() + $index); ?></td>
                                    <td><?php echo e($proposal->nim); ?></td>
                                    <td><?php echo e($proposal->nama_lengkap); ?></td>
                                    <td>
                                        <?php echo e(Str::limit($proposal->judul, 50)); ?>

                                        <?php if($proposal->isAging()): ?>
                                            <span class="badge bg-danger ms-1" title="Menunggu lebih dari 3 hari">
                                                <i class="bi bi-exclamation-triangle"></i> <?php echo e($proposal->getDaysSinceSubmission()); ?> hari
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo e($proposal->bidang_minat); ?></span>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-<?php echo e($proposal->getStatusBadgeColor()); ?>">
                                            <?php echo e($proposal->getStatusLabel()); ?>

                                        </span>
                                    </td>
                                    <td>
                                        <small><?php echo e($proposal->created_at->format('d M Y')); ?></small>
                                        <br>
                                        <small class="text-muted"><?php echo e($proposal->created_at->diffForHumans()); ?></small>
                                    </td>
                                    <td class="d-flex gap-1">
                                        <!-- Lihat Detail Proposal (ikon mata) -->
                                        <a href="<?php echo e(route('jurusan.inbox.show', $proposal->id)); ?>"
                                           class="btn btn-sm btn-primary"
                                           title="Lihat detail proposal">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Kirim Notifikasi (ikon bel) -->
                                        <form method="POST" action="<?php echo e(route('jurusan.inbox.notify', $proposal->id)); ?>" id="notify-form-<?php echo e($proposal->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <button type="button" class="btn btn-sm btn-warning" 
                                                    title="Kirim notifikasi ke role terkait"
                                                    onclick="showNotifyModal(<?php echo e($proposal->id); ?>, '<?php echo e(addslashes($proposal->judul_proposal)); ?>')">
                                                <i class="bi bi-bell"></i>
                                            </button>
                                        </form>

                                        <?php
                                            // Map bidang minat ke kode singkat yang dikenali controller
                                            $bidangCode = match($proposal->bidang_minat) {
                                                'Business Intelligence' => 'bi',
                                                'Data Engineering' => 'de',
                                                'Information Management' => 'im',
                                                'Information Retrieval' => 'ir',
                                                default => strtolower(str_replace(' ', '-', $proposal->bidang_minat))
                                            };
                                        ?>
                                        <!-- Buka Daftar Bidang (opsional) -->
                                        <a href="<?php echo e(route('jurusan.proposals.index', $bidangCode)); ?>" 
                                           class="btn btn-sm btn-outline-secondary" 
                                           title="Buka daftar proposal bidang ini">
                                            <i class="bi bi-list-task"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div class="text-muted small">
                        Menampilkan <?php echo e($proposals->firstItem()); ?> - <?php echo e($proposals->lastItem()); ?> dari <?php echo e($proposals->total()); ?> proposal
                    </div>
                    <div>
                        <?php echo e($proposals->withQueryString()->links()); ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-inbox display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Tidak ada proposal yang butuh aksi saat ini</h5>
                    <p class="text-muted">Semua proposal sudah diproses atau tidak ada filter yang cocok.</p>
                </div>
            <?php endif; ?>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/jurusan/inbox/index.blade.php ENDPATH**/ ?>