<?php $__env->startSection('content'); ?>
<div class="container-fluid mt-4 px-4">
    <!-- Header Section with Gradient -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; overflow: hidden;">
                <div class="card-body p-4 p-md-5 text-white">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                    <i class="fas fa-layer-group fa-2x"></i>
                                </div>
                                <div>
                                    <h2 class="mb-0 fw-bold">Daftar Proposal per Bidang KJFD</h2>
                                    <p class="mb-0 opacity-75">Kelola dan monitor proposal mahasiswa berdasarkan bidang keahlian</p>
                                </div>
                            </div>
                            <p class="mb-0 lead">
                                <i class="fas fa-info-circle me-2"></i>Setiap bidang memiliki kuota yang dapat disesuaikan oleh Admin. 
                                Pantau progress dan kelola proposal dengan mudah.
                            </p>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <?php
                                $totalProposals = \App\Models\Proposal::count();
                                $totalAccepted = \App\Models\Proposal::where('status', 'disetujui')->count();
                                $totalPending = \App\Models\Proposal::whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                            ?>
                            <div class="stats-box p-3" style="background: rgba(255,255,255,0.15); border-radius: 15px; backdrop-filter: blur(10px);">
                                <div class="row text-center g-2">
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <h3 class="mb-0 fw-bold"><?php echo e($totalProposals); ?></h3>
                                            <small class="opacity-75">Total</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <h3 class="mb-0 fw-bold text-success-light"><?php echo e($totalAccepted); ?></h3>
                                            <small class="opacity-75">Disetujui</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-item">
                                            <h3 class="mb-0 fw-bold text-warning-light"><?php echo e($totalPending); ?></h3>
                                            <small class="opacity-75">Pending</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- KJFD Bidang Cards -->
    <div class="row g-4">
        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card kjfd-card h-100 border-0 shadow-sm" 
                     style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease; animation: fadeInUp 0.5s ease-out <?php echo e($index * 0.1); ?>s both;">
                    
                    <!-- Card Header with Gradient -->
                    <div class="card-header border-0 text-white p-4" 
                         style="background: linear-gradient(135deg, 
                         <?php if($field['color'] == 'primary'): ?> #4e73df 0%, #224abe 100%
                         <?php elseif($field['color'] == 'success'): ?> #1cc88a 0%, #13855c 100%
                         <?php elseif($field['color'] == 'info'): ?> #36b9cc 0%, #258391 100%
                         <?php elseif($field['color'] == 'warning'): ?> #f6c23e 0%, #dda20a 100%
                         <?php else: ?> #6c757d 0%, #545b62 100%
                         <?php endif; ?>);">
                        
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="icon-wrapper" style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-<?php echo e($field['icon']); ?> fa-lg"></i>
                            </div>
                            <div class="badge bg-white bg-opacity-25 px-3 py-2">
                                <span class="fw-bold"><?php echo e($field['short']); ?></span>
                            </div>
                        </div>
                        
                        <h5 class="mb-0 fw-bold"><?php echo e($field['name']); ?></h5>
                    </div>

                    <div class="card-body p-4">
                        <!-- Quota Progress -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted small fw-semibold">
                                    <i class="fas fa-chart-pie me-1"></i>Progress Kuota
                                </span>
                                <span class="fw-bold text-<?php echo e($field['color']); ?>">
                                    <?php echo e($field['accepted']); ?><span class="text-muted">/<?php echo e($field['limit']); ?></span>
                                </span>
                            </div>
                            
                            <div class="progress mb-2" style="height: 12px; border-radius: 10px; background-color: #e9ecef;">
                                <div class="progress-bar bg-<?php echo e($field['color']); ?> progress-bar-striped progress-bar-animated" 
                                     role="progressbar" 
                                     style="width: <?php echo e($field['pct']); ?>%; border-radius: 10px;" 
                                     aria-valuenow="<?php echo e($field['pct']); ?>" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-percentage me-1"></i><?php echo e($field['pct']); ?>% terisi
                                </small>
                                <?php if($field['remaining'] > 0): ?>
                                    <span class="badge bg-success-subtle text-success px-2 py-1">
                                        <i class="fas fa-check-circle me-1"></i>Sisa <?php echo e($field['remaining']); ?>

                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger-subtle text-danger px-2 py-1">
                                        <i class="fas fa-exclamation-circle me-1"></i>Kuota Penuh
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Statistics Grid -->
                        <?php
                            $bidangProposals = \App\Models\Proposal::where('bidang_minat', $field['name'])->get();
                            $bidangTotal = $bidangProposals->count();
                            $bidangPending = $bidangProposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
                            $bidangRejected = $bidangProposals->where('status', 'ditolak')->count();
                        ?>
                        
                        <div class="row g-2 mb-3">
                            <div class="col-4">
                                <div class="stat-box text-center p-2 rounded" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                                    <div class="stat-value text-primary fw-bold"><?php echo e($bidangTotal); ?></div>
                                    <div class="stat-label text-muted" style="font-size: 0.7rem;">Total</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box text-center p-2 rounded" style="background: linear-gradient(135deg, #fff3cd 0%, #ffe69c 100%);">
                                    <div class="stat-value text-warning fw-bold"><?php echo e($bidangPending); ?></div>
                                    <div class="stat-label text-muted" style="font-size: 0.7rem;">Pending</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="stat-box text-center p-2 rounded" style="background: linear-gradient(135deg, #f8d7da 0%, #f1aeb5 100%);">
                                    <div class="stat-value text-danger fw-bold"><?php echo e($bidangRejected); ?></div>
                                    <div class="stat-label text-muted" style="font-size: 0.7rem;">Ditolak</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="<?php echo e(route('jurusan.proposals.index', $field['code'])); ?>" 
                           class="btn btn-<?php echo e($field['color']); ?> btn-block w-100 fw-semibold py-2 position-relative overflow-hidden"
                           style="border-radius: 12px;">
                            <span class="btn-text position-relative" style="z-index: 2;">
                                <i class="fas fa-folder-open me-2"></i>Lihat Proposal
                            </span>
                            <span class="btn-shine"></span>
                        </a>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-light border-0 p-3">
                        <div class="d-flex justify-content-between align-items-center text-muted small">
                            <span>
                                <i class="fas fa-clock me-1"></i>Update real-time
                            </span>
                            <?php if($field['remaining'] > 0): ?>
                                <span class="text-success">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Tersedia
                                </span>
                            <?php else: ?>
                                <span class="text-danger">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Penuh
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-5 mb-4">
        <a href="<?php echo e(route('jurusan.dashboard')); ?>" class="btn btn-lg btn-outline-secondary px-5 py-3" style="border-radius: 15px; border-width: 2px;">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Card Hover Effect */
.kjfd-card {
    transition: all 0.3s ease !important;
}

.kjfd-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15) !important;
}

/* Button Shine Effect */
.btn {
    position: relative;
    overflow: hidden;
}

.btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s;
}

.btn:hover .btn-shine {
    left: 100%;
}

/* Progress Bar Animation */
.progress-bar-animated {
    animation: progress-bar-stripes 1s linear infinite;
}

/* Stat Box Hover */
.stat-box {
    transition: all 0.3s ease;
}

.stat-box:hover {
    transform: scale(1.05);
}

/* Icon Wrapper Animation */
.icon-wrapper {
    transition: all 0.3s ease;
}

.kjfd-card:hover .icon-wrapper {
    transform: rotate(10deg) scale(1.1);
}

/* Badge Styles */
.bg-success-subtle {
    background-color: #d1e7dd !important;
}

.bg-danger-subtle {
    background-color: #f8d7da !important;
}

/* Responsive Text */
@media (max-width: 768px) {
    .lead {
        font-size: 1rem;
    }
    
    h2 {
        font-size: 1.5rem;
    }
}

/* Custom Scrollbar */
::-webkit-scrollbar {
    width: 10px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 5px;
}

::-webkit-scrollbar-thumb:hover {
    background: #555;
}

/* Light text colors for stats */
.text-success-light {
    color: #90ee90 !important;
}

.text-warning-light {
    color: #ffd700 !important;
}
</style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/jurusan/proposals/kjfd.blade.php ENDPATH**/ ?>