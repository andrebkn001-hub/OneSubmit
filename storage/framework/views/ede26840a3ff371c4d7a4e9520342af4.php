

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-primary mb-3" style="color: #1e90ff !important;">
                    <i class="bi bi-file-earmark-plus-fill me-3"></i>Pengajuan Proposal
                </h1>
                <p class="lead text-muted">Ajukan proposal tugas akhir Anda dengan lengkap dan mudah</p>
                <div class="mt-4">
                    <img src="<?php echo e(asset('images/unri.png')); ?>" alt="UNRI Logo" class="img-fluid" style="height: 60px; opacity: 0.8;">
                </div>
            </div>
        </div>
    </div>

    <!-- Main Form Card -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border-radius: 20px 20px 0 0 !important; color: white;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-clipboard-data-fill fs-4 me-3"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Form Pengajuan Proposal</h4>
                            <small class="opacity-75">Lengkapi data proposal tugas akhir Anda</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <?php if(session('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?php echo e(session('error')); ?>

                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(route('mahasiswa.proposal.store')); ?>" method="POST" enctype="multipart/form-data" id="proposalForm">
                        <?php echo csrf_field(); ?>

                        <!-- Personal Information Section -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4" style="color: #1976d2 !important;">
                                <i class="bi bi-person-circle me-2"></i>Informasi Pribadi
                            </h5>

                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-light" id="nama_lengkap" name="nama_lengkap"
                                               value="<?php echo e(Auth::user()->name); ?>" readonly
                                               style="border-radius: 10px; border: 2px solid #e9ecef;">
                                        <label for="nama_lengkap" class="text-muted">
                                            <i class="bi bi-person-fill me-1"></i>Nama Lengkap
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control bg-light" id="nim" name="nim"
                                               value="<?php echo e(Auth::user()->nim ?? ''); ?>" readonly
                                               style="border-radius: 10px; border: 2px solid #e9ecef;">
                                        <label for="nim" class="text-muted">
                                            <i class="bi bi-upc-scan me-1"></i>NIM
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Proposal Information Section -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4" style="color: #1976d2 !important;">
                                <i class="bi bi-file-earmark-text-fill me-2"></i>Informasi Proposal
                            </h5>

                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="judul" name="judul"
                                               placeholder="Masukkan judul proposal Anda" required
                                               style="border-radius: 10px; border: 2px solid #e9ecef; transition: all 0.3s ease;"
                                               onfocus="this.style.borderColor='#1976d2'; this.style.boxShadow='0 0 0 0.2rem rgba(25, 118, 210, 0.25)';"
                                               onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none';">
                                        <label for="judul" class="text-muted">
                                            <i class="bi bi-type-bold me-1"></i>Judul Proposal
                                        </label>
                                    </div>
                                    <div class="mt-2">
                                        <div class="alert alert-warning py-2 px-3 mb-2" style="border-radius: 8px; background-color: #fff3cd; border-left: 4px solid #ffc107;">
                                            <small><i class="bi bi-exclamation-triangle-fill me-1"></i><strong>Penting:</strong> Judul harus terdiri dari minimal 7 kata dan maksimal 15 kata</small>
                                        </div>
                                        <div id="judulHelp" class="small text-muted"><i class="bi bi-chat-square-text me-1"></i>Jumlah kata saat ini: <strong>0</strong></div>
                                    </div>
                                    <?php $__errorArgs = ['judul'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1">
                                            <i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <select class="form-select" id="bidang_minat" name="bidang_minat" required
                                                style="border-radius: 10px; border: 2px solid #e9ecef; transition: all 0.3s ease;"
                                                onfocus="this.style.borderColor='#1976d2'; this.style.boxShadow='0 0 0 0.2rem rgba(25, 118, 210, 0.25)';"
                                                onblur="this.style.borderColor='#e9ecef'; this.style.boxShadow='none';">
                                            <option value="">-- Pilih Bidang Minat --</option>
                                            <option value="Business Intelligence">Business Intelligence</option>
                                            <option value="Data Engineering">Data Engineering</option>
                                            <option value="Information Management">Information Management</option>
                                            <option value="Information Retrieval">Information Retrieval</option>
                                        </select>
                                        <label for="bidang_minat" class="text-muted">
                                            <i class="bi bi-diagram-3 me-1"></i>Bidang Minat
                                        </label>
                                    </div>
                                    <?php $__errorArgs = ['bidang_minat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1">
                                            <i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <!-- File Upload Section -->
                        <div class="mb-5">
                            <h5 class="fw-bold text-primary mb-4" style="color: #1976d2 !important;">
                                <i class="bi bi-cloud-upload-fill me-2"></i>Unggah Berkas Proposal
                            </h5>

                            <div class="upload-area border-2 border-dashed rounded-3 p-5 text-center"
                                 style="border-color: #e9ecef !important; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%); transition: all 0.3s ease;"
                                 onmouseover="this.style.borderColor='#1976d2'; this.style.background='linear-gradient(135deg, #e3f2fd 0%, #bbdefb 50%, #e3f2fd 100%)';"
                                 onmouseout="this.style.borderColor='#e9ecef'; this.style.background='linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%)';">
                                <div class="mb-3">
                                    <i class="bi bi-file-earmark-pdf-fill fs-1 text-primary" style="color: #1976d2 !important;"></i>
                                </div>
                                <h6 class="fw-bold text-muted mb-2">Pilih File Proposal</h6>
                                <p class="text-muted small mb-3">Format: PDF, DOC, DOCX | Ukuran: 200 KB - 5 MB</p>

                                <div class="custom-file-upload">
                                    <input type="file" class="form-control d-none" id="file_proposal" name="file_proposal"
                                           accept=".pdf,.doc,.docx" required
                                           onchange="updateFileName(this)">
                                    <label for="file_proposal" class="btn btn-primary fw-bold px-4 py-2"
                                           style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border: none; border-radius: 10px;">
                                        <i class="bi bi-folder2-open me-2"></i>Pilih File
                                    </label>
                                    <div class="file-name-display mt-3">
                                        <small class="text-muted" id="fileName">No file chosen</small>
                                    </div>
                                </div>
                            </div>

                            <?php $__errorArgs = ['file_proposal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-2">
                                    <i class="bi bi-exclamation-circle me-1"></i><?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <div class="alert alert-info mt-3 border-0" style="background: linear-gradient(135deg, #cce5ff 0%, #99d6ff 100%); border-radius: 10px;">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <strong>Catatan:</strong> Minimal ukuran file 200 KB, maksimal 5120 KB (5 MB).
                                Pastikan file dalam format PDF, DOC, atau DOCX.
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg fw-bold px-5 py-3" id="submitBtn"
                                    style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border: none; border-radius: 15px; color: white; transition: all 0.3s ease;">
                                <i class="bi bi-send-fill me-2"></i>Ajukan Proposal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-floating > .form-control {
    height: calc(3.5rem + 2px);
    line-height: 1.25;
}

.form-floating > .form-control:focus ~ label,
.form-floating > .form-control:not(:placeholder-shown) ~ label {
    opacity: 0.65;
    transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
}

.upload-area:hover {
    cursor: pointer;
}

.custom-file-upload .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(25, 118, 210, 0.3);
}

#submitBtn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(25, 118, 210, 0.4);
}

#submitBtn:active {
    transform: translateY(0);
}

.alert {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }

    .card-body {
        padding: 2rem !important;
    }

    .upload-area {
        padding: 2rem !important;
    }
}
</style>

<script>
function updateFileName(input) {
    const fileName = input.files[0] ? input.files[0].name : 'No file chosen';
    document.getElementById('fileName').textContent = fileName;

    // Add visual feedback
    const uploadArea = input.closest('.upload-area');
    if (input.files[0]) {
        uploadArea.style.borderColor = '#198754';
        uploadArea.style.background = 'linear-gradient(135deg, #d1ecf1 0%, #a3daff 50%, #d1ecf1 100%)';
    } else {
        uploadArea.style.borderColor = '#e9ecef';
        uploadArea.style.background = 'linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #f8f9fa 100%)';
    }
}

// Form validation enhancement
document.getElementById('proposalForm').addEventListener('submit', function(e) {
    const submitBtn = document.getElementById('submitBtn');
    const originalText = submitBtn.innerHTML;

    // Prevent submit if word count invalid (defensive client-side)
    const judulInput = document.getElementById('judul');
    const words = judulInput.value.trim().replace(/\s+/g, ' ').split(' ').filter(w => w.length > 0);
    const count = words.length;
    if (count < 7 || count > 15) {
        e.preventDefault();
        const help = document.getElementById('judulHelp');
        help.classList.remove('text-muted');
        help.classList.add('text-danger');
        help.innerHTML = 'Jumlah kata judul saat ini ' + count + '. Harus 7 - 15 kata.';
        return; // Do not show loading state if invalid
    }

    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';
    submitBtn.disabled = true;

    // Re-enable after 3 seconds (in case of error)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});

// Live word count feedback
const judulField = document.getElementById('judul');
const judulHelp = document.getElementById('judulHelp');
const submitBtn = document.getElementById('submitBtn');
judulField.addEventListener('input', () => {
    const words = judulField.value.trim().replace(/\s+/g, ' ').split(' ').filter(w => w.length > 0);
    const count = judulField.value.trim() === '' ? 0 : words.length;
    const valid = count >= 7 && count <= 15;
    
    // Update counter with status icon
    let statusIcon = '<i class="bi bi-chat-square-text me-1"></i>';
    let statusClass = 'text-muted';
    let statusText = 'Jumlah kata saat ini: <strong>' + count + '</strong>';
    
    if (count > 0 && count < 7) {
        statusIcon = '<i class="bi bi-exclamation-circle-fill me-1"></i>';
        statusClass = 'text-danger';
        statusText += ' <span class="fw-bold">(Kurang ' + (7 - count) + ' kata lagi)</span>';
    } else if (count > 15) {
        statusIcon = '<i class="bi bi-exclamation-circle-fill me-1"></i>';
        statusClass = 'text-danger';
        statusText += ' <span class="fw-bold">(Kelebihan ' + (count - 15) + ' kata)</span>';
    } else if (count >= 7 && count <= 15) {
        statusIcon = '<i class="bi bi-check-circle-fill me-1"></i>';
        statusClass = 'text-success';
        statusText += ' <span class="fw-bold">✓ Sesuai ketentuan</span>';
    }
    
    judulHelp.innerHTML = statusIcon + statusText;
    judulHelp.className = 'small ' + statusClass;
    submitBtn.disabled = !valid;
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/proposals/create.blade.php ENDPATH**/ ?>