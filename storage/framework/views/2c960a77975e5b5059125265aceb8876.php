<section>
    <header>
        
        <h2 class="h5 fw-bold text-dark">
            <?php echo e(__('Profile Information')); ?>

        </h2>

        <p class="text-secondary mb-3">
            <?php echo e(__("Update your account's profile information and email address.")); ?>

        </p>
    </header>

    <form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>">
        <?php echo csrf_field(); ?>
    </form>

    <form method="post" action="<?php echo e(route('profile.update')); ?>" class="mt-4" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('patch'); ?>

        <!-- Profile Photo Section -->
        <div class="mb-4 text-center">
            <label class="form-label fw-bold"><?php echo e(__('Profile Photo')); ?></label>
            <div class="d-flex flex-column align-items-center gap-3">
                <div id="photo-preview" class="mb-2">
                    <?php if($user->profile_photo): ?>
                        <img src="<?php echo e(asset('storage/' . $user->profile_photo)); ?>" alt="Profile Photo" 
                             class="rounded-circle" 
                             style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #0d6efd;">
                    <?php else: ?>
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold;">
                            <?php echo e(strtoupper(substr($user->name, 0, 1))); ?>

                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">JPG, PNG, atau GIF (Max. 2MB)</small>
                </div>
            </div>
            <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label"><?php echo e(__('Name')); ?></label>
            
            <input id="name" name="name" type="text" class="form-control" value="<?php echo e(old('name', $user->name)); ?>" required autofocus autocomplete="name" />
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label"><?php echo e(__('Email')); ?></label>
            
            <input id="email" name="email" type="email" class="form-control" value="<?php echo e(old('email', $user->email)); ?>" required autocomplete="username" />
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="text-danger mt-1"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()): ?>
                <div>
                    <p class="text-muted mt-2">
                        <?php echo e(__('Your email address is unverified.')); ?>


                        <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                            <?php echo e(__('Click here to re-send the verification email.')); ?>

                        </button>
                    </p>

                    <?php if(session('status') === 'verification-link-sent'): ?>
                        <p class="mt-2 text-success">
                            <?php echo e(__('A new verification link has been sent to your email address.')); ?>

                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i><?php echo e(__('Save')); ?>

            </button>

            <?php if(session('status') === 'profile-updated'): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Profil berhasil diperbarui!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
        </div>
    </form>
</section>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photo-preview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #0d6efd;">`;
        }
        reader.readAsDataURL(file);
    }
}
</script><?php /**PATH C:\laragon\www\OneSubmit\resources\views/profile/partials/update-profile-information-form.blade.php ENDPATH**/ ?>