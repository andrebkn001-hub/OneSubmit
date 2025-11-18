

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <h3>Kelola Kuota KJFD</h3>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table id="quotasTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Bidang</th>
                    <th class="text-center">Kuota</th>
                    <th class="text-center">Sudah ACC</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $quotas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($q->bidang); ?></td>
                    <td class="text-center"><?php echo e($q->quota); ?></td>
                    <td class="text-center">
                        <?php
                            $accepted = \App\Models\Proposal::whereHas('dosenKjfd', function($query) use ($q) {
                                $query->where('bidang', $q->bidang);
                            })->where('status', 'disetujui')->count();
                        ?>
                        <?php echo e($accepted); ?>

                    </td>
                    <td class="text-center">
                        <a href="<?php echo e(route('admin.quotas.edit', $q->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary mt-3">Kembali</a>
</div>

<script>
$(document).ready(function() {
    $('#quotasTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        searching: true,
        paging: false,
        info: false,
        columnDefs: [
            { orderable: false, targets: [3] }
        ]
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/admin/quotas/index.blade.php ENDPATH**/ ?>