<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold">Pilih Bidang KJFD</h2>
        <p class="text-muted">Pilih bidang untuk melihat daftar proposal mahasiswa. Setiap bidang memiliki kuota maksimal <strong>50</strong> proposal yang dapat diterima.</p>
    </div>

    

    <div class="row g-3">
        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <div class="col-12 col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <div class="bg-<?php echo e($field['color']); ?> text-white rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px;">
                                    <i class="fas fa-<?php echo e($field['icon']); ?> fa-lg"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="mb-1"><?php echo e($field['name']); ?></h5>
                                <small class="text-muted">Kode: <strong><?php echo e($field['short']); ?></strong></small>
                            </div>
                        </div>

                        <div class="mt-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Kuota</small>
                                <small class="text-muted"><?php echo e($field['accepted']); ?> / <?php echo e($field['limit']); ?></small>
                            </div>
                            <div class="progress" style="height:10px;">
                                <div class="progress-bar bg-<?php echo e($field['color']); ?>" role="progressbar" style="width: <?php echo e($field['pct']); ?>%;" aria-valuenow="<?php echo e($field['pct']); ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="mt-2 d-flex justify-content-between align-items-center">
                                <div>
                                    <?php if($field['remaining'] > 0): ?>
                                        <span class="badge bg-info">Sisa <?php echo e($field['remaining']); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Kuota Penuh</span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo e(route('jurusan.proposals.index', $field['code'])); ?>" class="btn btn-sm btn-outline-<?php echo e($field['color']); ?>">Lihat Proposal</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="text-center mt-4">
        <a href="<?php echo e(route('jurusan.dashboard')); ?>" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/jurusan/proposals/kjfd.blade.php ENDPATH**/ ?>