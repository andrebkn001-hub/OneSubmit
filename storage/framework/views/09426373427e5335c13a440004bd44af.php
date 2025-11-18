<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-3">Daftar Proposal Mahasiswa</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <!-- Form Pencarian -->
    <form method="GET" action="<?php echo e(route('admin.proposals.index')); ?>" class="mb-3">
        <div class="input-group">
            <input type="text" name="nim" class="form-control" placeholder="Cari berdasarkan NIM..." value="<?php echo e(request('nim')); ?>">
            <button class="btn btn-primary" type="submit">Cari</button>
            <?php if(request('nim')): ?>
                <a href="<?php echo e(route('admin.proposals.index')); ?>" class="btn btn-secondary">Reset</a>
            <?php endif; ?>
        </div>
    </form>

    <table id="proposalsTable" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIM</th>
                <th>Judul Proposal</th>
                <th>Bidang Minat</th>
                <th>Status</th>
                <th>Berkas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($proposal->nama_lengkap); ?></td>
                    <td><?php echo e($proposal->nim); ?></td>
                    <td><?php echo e($proposal->judul); ?></td>
                    <td><?php echo e($proposal->bidang_minat); ?></td>
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
                            <a href="<?php echo e(asset('storage/'.$proposal->file_path)); ?>" target="_blank" class="btn btn-sm btn-primary">
                                Lihat File
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada file</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(strtolower($proposal->status) == 'menunggu_verifikasi'): ?>
                            <form action="<?php echo e(route('admin.proposals.approve', $proposal->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success btn-sm">Teruskan ke KJFD</button>
                            </form>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo e($proposal->id); ?>">Tolak</button>
                        <?php else: ?>
                            <button type="button" class="btn btn-secondary btn-sm" disabled>Aksi Tidak Tersedia</button>
                        <?php endif; ?>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal<?php echo e($proposal->id); ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?php echo e($proposal->id); ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel<?php echo e($proposal->id); ?>">Tolak Proposal: <?php echo e($proposal->judul); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?php echo e(route('admin.proposals.reject', $proposal->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="rejection_message_<?php echo e($proposal->id); ?>" class="form-label">Alasan Penolakan</label>
                                                <textarea class="form-control" id="rejection_message_<?php echo e($proposal->id); ?>" name="rejection_message" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak Proposal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="8" class="text-center">Belum ada proposal yang diajukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#proposalsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12 col-md-6"B>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ],
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [6, 7] }
        ]
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/admin/proposals/index.blade.php ENDPATH**/ ?>