<?php $__env->startSection('content'); ?>
<div class="container-fluid"> 

    <div class="row">
        <div class="col-12 text-center"> 
            <h1 class="mb-2">Dashboard Dosen KJFD</h1>
            <p class="lead text-secondary mb-4">Selamat datang, <strong><?php echo e(Auth::user()->name); ?></strong></p>
        </div>
    </div>

    
    
    <div class="row **d-flex** justify-content-center">
        
        
        <div class="col-lg-5 col-md-6 mb-4">
            
            <div class="card bg-primary text-white h-100 d-flex flex-column shadow">
                <div class="card-body flex-grow-1">
                    <h5 class="card-title fw-bold">Proposal Menunggu Verifikasi</h5>
                    <p class="card-text">Proposal yang perlu Anda verifikasi</p>
                    
                    <h1 class="display-4 fw-bold mb-3">
                         <?php echo e(\App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'menunggu_verifikasi_dosen_kjfd')->count()); ?>

                    </h1>
                    <a href="<?php echo e(route('kjfd.proposals.index')); ?>" class="btn btn-light btn-sm mt-auto">Lihat Proposal</a>
                </div>
            </div>
        </div>

        
        <div class="col-lg-5 col-md-6 mb-4">
            
            <div class="card bg-success text-white h-100 d-flex flex-column shadow">
                <div class="card-body flex-grow-1">
                    <h5 class="card-title fw-bold">Proposal Disetujui</h5>
                    <p class="card-text">Total proposal yang telah Anda setujui</p>
                    <h1 class="display-4 fw-bold mb-3">
                        <?php echo e(\App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'disetujui')->count()); ?>

                    </h1>
                    
                    <a href="<?php echo e(route('kjfd.proposals.index', ['status' => 'disetujui'])); ?>" class="btn btn-light mt-auto">Lihat Proposal</a>
                </div>
            </div>
        </div>

    </div> 
    

    
    
    <div class="row d-flex justify-content-center">

        
        <div class="col-lg-5 col-md-6 mb-4">
            
            <div class="card bg-warning text-dark h-100 d-flex flex-column shadow"> 
                <div class="card-body flex-grow-1">
                    <h5 class="card-title fw-bold">Proposal Direvisi</h5>
                    <p class="card-text">Proposal yang sedang direvisi mahasiswa</p>
                    <h1 class="display-4 fw-bold mb-3">
                        <?php echo e(\App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'revisi')->count()); ?>

                    </h1>
                    <a href="<?php echo e(route('kjfd.proposals.index', ['status' => 'revisi'])); ?>" class="btn btn-light mt-auto">Lihat Proposal</a>
                </div>
            </div>
        </div>

        
        <div class="col-lg-5 col-md-6 mb-4">
            
            <div class="card bg-danger text-white h-100 d-flex flex-column shadow">
                <div class="card-body flex-grow-1">
                    <h5 class="card-title fw-bold">Proposal Ditolak</h5>
                    <p class="card-text">Total proposal yang telah Anda tolak</p>
                    <h1 class="display-4 fw-bold mb-3">
                        <?php echo e(\App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'ditolak')->count()); ?>

                    </h1>
                    <a href="<?php echo e(route('kjfd.proposals.index', ['status' => 'ditolak'])); ?>" class="btn btn-light mt-auto">Lihat Proposal</a>
                </div>
            </div>
        </div>

    </div>
    


    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h5>Proposal Terbaru untuk Verifikasi</h5>
                </div>
                <div class="card-body">
                    <?php
                        $recentProposals = \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())
                            ->where('status', 'menunggu_verifikasi_dosen_kjfd')
                            ->latest()
                            ->take(5)
                            ->get();
                    ?>

                    <?php if($recentProposals->isNotEmpty()): ?>
                        <div class="table-responsive">
                            <table id="kjfdRecentProposalsTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Judul</th>
                                        <th>Bidang</th>
                                        <th>Diajukan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentProposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($proposal->nim); ?></td>
                                            <td><?php echo e($proposal->nama_lengkap); ?></td>
                                            <td><?php echo e($proposal->judul); ?></td>
                                            <td><?php echo e($proposal->bidang_minat); ?></td>
                                            <td><?php echo e($proposal->created_at->format('d M Y')); ?></td>
                                            <td>
                                                <a href="<?php echo e(route('kjfd.proposals.index')); ?>" class="btn btn-sm btn-primary">Verifikasi</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Belum ada proposal baru untuk diverifikasi.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#kjfdRecentProposalsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        pageLength: 5,
        searching: false,
        paging: false,
        info: false,
        order: [[4, 'desc']],
        columnDefs: [
            { orderable: false, targets: [5] }
        ]
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/dashboard/kjfd.blade.php ENDPATH**/ ?>