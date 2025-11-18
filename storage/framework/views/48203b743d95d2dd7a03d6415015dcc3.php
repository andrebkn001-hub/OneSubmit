<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h2 class="mb-3">Daftar Proposal Mahasiswa untuk Verifikasi</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <form method="GET" action="<?php echo e(route('kjfd.proposals.index')); ?>" class="mb-3">
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="nim" class="form-control" placeholder="Cari NIM..." value="<?php echo e(request('nim')); ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Cari Nama Mahasiswa..." value="<?php echo e(request('nama_lengkap')); ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="judul" class="form-control" placeholder="Cari Judul Proposal..." value="<?php echo e(request('judul')); ?>">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="menunggu_verifikasi_dosen_kjfd" <?php echo e(request('status') == 'menunggu_verifikasi_dosen_kjfd' ? 'selected' : ''); ?>>Menunggu Verifikasi</option>
                    <option value="revisi" <?php echo e(request('status') == 'revisi' ? 'selected' : ''); ?>>Revisi</option>
                    <option value="disetujui" <?php echo e(request('status') == 'disetujui' ? 'selected' : ''); ?>>Disetujui</option>
                    <option value="ditolak" <?php echo e(request('status') == 'ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100" type="submit">Cari</button>
            </div>
            <?php if(request('nim') || request('nama_lengkap') || request('judul') || request('status')): ?>
                <div class="col-md-1">
                    <a href="<?php echo e(route('kjfd.proposals.index')); ?>" class="btn btn-secondary w-100">Reset</a>
                </div>
            <?php endif; ?>
        </div>
    </form>

    <div class="table-responsive">
        <table id="kjfdProposalsTable" class="table table-striped align-middle">
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
            <?php if($proposals->count() > 0): ?>
            <?php $__currentLoopData = $proposals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $proposal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($proposal->nama_lengkap); ?></td>
                    <td><?php echo e($proposal->nim); ?></td>
                    <td><?php echo e($proposal->judul); ?></td>
                    <td><?php echo e($proposal->bidang_minat); ?></td>
                    <td>
                        <span class="badge bg-info">
                            <?php echo e(ucfirst($proposal->status)); ?>

                        </span>
                    </td>
                    <td>
                        <?php if($proposal->file_path): ?>
                            <a href="<?php echo e(route('kjfd.proposals.view-file', $proposal->id)); ?>" target="_blank" class="btn btn-sm btn-primary">
                                Lihat File
                            </a>
                        <?php else: ?>
                            <span class="text-muted">Tidak ada file</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal<?php echo e($proposal->id); ?>">Detail</button>
                        <?php if($proposal->status === 'menunggu_verifikasi_dosen_kjfd'): ?>
                            <form action="<?php echo e(route('kjfd.proposals.approve', $proposal->id)); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success btn-sm">Terima</button>
                            </form>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reviseModal<?php echo e($proposal->id); ?>">Revisi</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal<?php echo e($proposal->id); ?>">Tolak</button>
                        <?php elseif($proposal->status === 'revisi'): ?>
                            <span class="text-muted">Menunggu upload revisi mahasiswa</span>
                        <?php else: ?>
                            <span class="text-muted">Sudah diproses</span>
                        <?php endif; ?>

                        <!-- Modal Detail Riwayat Proposal -->
                        <div class="modal fade" id="detailModal<?php echo e($proposal->id); ?>" tabindex="-1" aria-labelledby="detailModalLabel<?php echo e($proposal->id); ?>" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel<?php echo e($proposal->id); ?>">Detail Riwayat Proposal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item"><strong>Status Saat Ini:</strong> <?php echo e(ucfirst($proposal->status)); ?></li>
                                            <?php if($proposal->revision_message): ?>
                                                <li class="list-group-item"><strong>Pesan Revisi:</strong> <?php echo e($proposal->revision_message); ?></li>
                                            <?php endif; ?>
                                            <?php if($proposal->rejection_message): ?>
                                                <li class="list-group-item"><strong>Alasan Penolakan:</strong> <?php echo e($proposal->rejection_message); ?></li>
                                            <?php endif; ?>
                                            <?php if($proposal->acc_letter_path): ?>
                                                <li class="list-group-item"><strong>Surat ACC:</strong> <a href="<?php echo e(Storage::url($proposal->acc_letter_path)); ?>" target="_blank">Download</a></li>
                                            <?php endif; ?>
                                        </ul>
                                        <div><strong>Judul Proposal:</strong> <?php echo e($proposal->judul); ?></div>
                                        <div><strong>Bidang Minat:</strong> <?php echo e($proposal->bidang_minat); ?></div>
                                        <div><strong>Nama Mahasiswa:</strong> <?php echo e($proposal->nama_lengkap); ?></div>
                                        <div><strong>NIM:</strong> <?php echo e($proposal->nim); ?></div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Revisi -->
                        <div class="modal fade" id="reviseModal<?php echo e($proposal->id); ?>" tabindex="-1" aria-labelledby="reviseModalLabel<?php echo e($proposal->id); ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reviseModalLabel<?php echo e($proposal->id); ?>">Revisi Proposal: <?php echo e($proposal->judul); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?php echo e(route('kjfd.proposals.revise', $proposal->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="revision_message_<?php echo e($proposal->id); ?>" class="form-label">Pesan Revisi (Minimal 10 Karakter)</label>
                                                <textarea class="form-control" id="revision_message_<?php echo e($proposal->id); ?>" name="revision_message" rows="3" required minlength="10"></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">Kirim Revisi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Penolakan -->
                        <div class="modal fade" id="rejectModal<?php echo e($proposal->id); ?>" tabindex="-1" aria-labelledby="rejectModalLabel<?php echo e($proposal->id); ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel<?php echo e($proposal->id); ?>">Tolak Proposal: <?php echo e($proposal->judul); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?php echo e(route('kjfd.proposals.reject', $proposal->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="rejection_message_<?php echo e($proposal->id); ?>" class="form-label">Alasan Penolakan (Minimal 10 Karakter)</label>
                                                <textarea class="form-control" id="rejection_message_<?php echo e($proposal->id); ?>" name="rejection_message" rows="3" required minlength="10"></textarea>
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
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </tbody>
        </table>
    </div>
</div>

<?php $__env->startSection('footer-scripts'); ?>
<script>
$(document).ready(function() {
    const table = $('#kjfdProposalsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        stateSave: true,
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [6, 7] }
        ]
    });
    // Penyesuaian margin/padding untuk mobile
    if(window.innerWidth <= 768){
        $('.container').css({'padding':'0 2px','margin':'0'});
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/dosen_kjfd/proposals/index.blade.php ENDPATH**/ ?>