

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Detail Proposal</h2>
        <div class="btn-group">
            <a href="<?php echo e(route('jurusan.inbox.index')); ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Inbox
            </a>
            <form method="POST" action="<?php echo e(route('jurusan.inbox.notify', $proposal->id)); ?>" class="ms-2">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-warning">
                    <i class="bi bi-bell"></i> Kirim Notifikasi
                </button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <div><strong>Nama Mahasiswa:</strong> <?php echo e($proposal->nama_lengkap); ?></div>
                    <div><strong>NIM:</strong> <?php echo e($proposal->nim); ?></div>
                    <div><strong>Bidang Minat:</strong> <span class="badge bg-secondary"><?php echo e($proposal->bidang_minat); ?></span></div>
                    <div><strong>Status:</strong> <span class="badge bg-<?php echo e($proposal->getStatusBadgeColor()); ?>"><?php echo e($proposal->getStatusLabel()); ?></span></div>
                </div>
                <div class="col-md-6">
                    <div><strong>Diajukan:</strong> <?php echo e($proposal->created_at->format('d M Y H:i')); ?> (<?php echo e($proposal->created_at->diffForHumans()); ?>)</div>
                    <div><strong>Dosen KJFD:</strong> <?php echo e($proposal->dosenKjfd?->name ?? '-'); ?></div>
                </div>
            </div>
            <div class="mb-3">
                <strong>Judul Proposal:</strong>
                <div class="border rounded p-3 bg-light"><?php echo e($proposal->judul); ?></div>
            </div>

            <div class="d-flex gap-2">
                <?php if($proposal->file_path): ?>
                    <a href="<?php echo e(route('jurusan.proposals.view-file', $proposal->id)); ?>" class="btn btn-primary" target="_blank">
                        <i class="bi bi-file-earmark-pdf"></i> Lihat Berkas
                    </a>
                <?php endif; ?>
                <?php
                    $bidangCode = match($proposal->bidang_minat) {
                        'Business Intelligence' => 'bi',
                        'Data Engineering' => 'de',
                        'Information Management' => 'im',
                        'Information Retrieval' => 'ir',
                        default => strtolower(str_replace(' ', '-', $proposal->bidang_minat))
                    };
                ?>
                <a href="<?php echo e(route('jurusan.proposals.index', $bidangCode)); ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-list-task"></i> Lihat Daftar Bidang
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/jurusan/inbox/show.blade.php ENDPATH**/ ?>