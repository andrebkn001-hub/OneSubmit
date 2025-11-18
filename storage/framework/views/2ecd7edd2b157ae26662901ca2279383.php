<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Proposal Mahasiswa - Bidang <?php echo e($bidang); ?></h2>
        <a href="<?php echo e(route('jurusan.proposals.kjfd')); ?>" class="btn btn-secondary">Kembali</a>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <form method="GET" action="<?php echo e(route('jurusan.proposals.index', $bidang)); ?>" class="mb-3">
        <div class="input-group">
            <input type="text" name="nim" class="form-control" placeholder="Cari berdasarkan NIM..." value="<?php echo e(request('nim')); ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
            <?php if(request('nim')): ?>
                <a href="<?php echo e(route('jurusan.proposals.index', $bidang)); ?>" class="btn btn-secondary">Reset</a>
            <?php endif; ?>
        </div>
    </form>

    <table id="jurusanProposalsTable" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Judul Proposal</th>
                <th>Tanggal Upload Proposal</th>
                <th>Status Proposal</th>
                <th>File Proposal</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($proposal->nama_lengkap); ?></td>
                    <td><?php echo e($proposal->nim); ?></td>
                    <td><?php echo e($proposal->judul); ?></td>
                    <td><?php echo e($proposal->created_at->format('d/m/Y H:i')); ?></td>
                    <td>
                        <?php
                            $badgeClass = 'secondary';
                            $statusText = ucfirst($proposal->status);
                            if (strtolower($proposal->status) == 'disetujui') {
                                $badgeClass = 'success';
                            } elseif (strtolower($proposal->status) == 'ditolak') {
                                $badgeClass = 'danger';
                            } elseif (strtolower($proposal->status) == 'menunggu_verifikasi_dosen_kjfd') {
                                $badgeClass = 'info';
                                $statusText = 'Menunggu Verifikasi Dosen KJFD';
                            } elseif (strtolower($proposal->status) == 'revisi') {
                                $badgeClass = 'warning';
                                $statusText = 'Revisi';
                            }
                        ?>
                        <span class="badge bg-<?php echo e($badgeClass); ?>">
                            <?php echo e($statusText); ?>

                        </span>
                    </td>
                    <td>
                        
                        <?php if($proposal->file_path): ?>
                            <a href="<?php echo e(route('jurusan.proposals.view-file', $proposal->id)); ?>" target="_blank" class="btn btn-sm btn-primary">
                                Lihat File
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada file</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" class="text-center">Belum ada proposal yang diajukan untuk bidang <?php echo e($bidang); ?>.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#jurusanProposalsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [6] }
        ]
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/jurusan/proposals/index.blade.php ENDPATH**/ ?>