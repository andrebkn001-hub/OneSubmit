

<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard Ketua Jurusan</h1>
        <div class="d-none d-sm-inline-block">
            <span class="mr-2 d-none d-lg-inline text-gray-600">
                Selamat datang, <strong><?php echo e(Auth::user()->name); ?></strong>
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
                                <?php echo e(\App\Models\Proposal::count()); ?>

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
                                <?php echo e(\App\Models\Proposal::where('status', 'disetujui')->count()); ?>

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
                                <?php echo e(\App\Models\Proposal::whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count()); ?>

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
                                <?php echo e(\App\Models\Proposal::where('status', 'ditolak')->count()); ?>

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
                        <a href="<?php echo e(route('jurusan.proposals.index', 'bi')); ?>" class="text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                        $biProposals = \App\Models\Proposal::where('bidang_minat', 'Business Intelligence')->get();
                        $biTotal = $biProposals->count();
                        $biApproved = $biProposals->where('status', 'disetujui')->count();
                        $biPending = $biProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                    ?>
                    <div class="no-gutters align-items-center">
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($biTotal); ?></div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($biApproved); ?></div>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($biPending); ?></div>
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
                        <a href="<?php echo e(route('jurusan.proposals.index', 'de')); ?>" class="text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                        $deProposals = \App\Models\Proposal::where('bidang_minat', 'Data Engineering')->get();
                        $deTotal = $deProposals->count();
                        $deApproved = $deProposals->where('status', 'disetujui')->count();
                        $dePending = $deProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                    ?>
                    <div class="no-gutters align-items-center">
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($deTotal); ?></div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($deApproved); ?></div>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($dePending); ?></div>
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
                        <a href="<?php echo e(route('jurusan.proposals.index', 'im')); ?>" class="text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                        $imProposals = \App\Models\Proposal::where('bidang_minat', 'Information Management')->get();
                        $imTotal = $imProposals->count();
                        $imApproved = $imProposals->where('status', 'disetujui')->count();
                        $imPending = $imProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                    ?>
                    <div class="no-gutters align-items-center">
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($imTotal); ?></div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($imApproved); ?></div>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($imPending); ?></div>
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
                        <a href="<?php echo e(route('jurusan.proposals.index', 'ir')); ?>" class="text-white">
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php
                        $irProposals = \App\Models\Proposal::where('bidang_minat', 'Information Retrieval')->get();
                        $irTotal = $irProposals->count();
                        $irApproved = $irProposals->where('status', 'disetujui')->count();
                        $irPending = $irProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                    ?>
                    <div class="no-gutters align-items-center">
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Proposal</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($irTotal); ?></div>
                        </div>
                        <div class="mb-3">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disetujui</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($irApproved); ?></div>
                        </div>
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Dalam Proses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($irPending); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/dashboard/jurusan.blade.php ENDPATH**/ ?>