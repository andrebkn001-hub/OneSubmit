<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Akses Ditolak</h4>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-1 text-danger">403</h1>
                    <h3 class="card-title">Forbidden</h3>
                    <p class="card-text">
                        Anda tidak memiliki izin untuk mengakses halaman ini.
                    </p>
                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-secondary ml-2">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/errors/403.blade.php ENDPATH**/ ?>