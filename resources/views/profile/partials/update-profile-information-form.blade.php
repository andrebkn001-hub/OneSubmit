<section>
    <header>
        {{-- Mengganti kelas Tailwind dengan Heading Bootstrap --}}
        <h2 class="h5 fw-bold text-dark">
            {{ __('Profile Information') }}
        </h2>

        <p class="text-secondary mb-3">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Photo Section -->
        <div class="mb-4 text-center">
            <label class="form-label fw-bold">{{ __('Profile Photo') }}</label>
            <div class="d-flex flex-column align-items-center gap-3">
                <div id="photo-preview" class="mb-2">
                    @if ($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo" 
                             class="rounded-circle" 
                             style="width: 100px; height: 100px; object-fit: cover; border: 3px solid #0d6efd;">
                    @else
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" 
                             style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div>
                    <input type="file" name="profile_photo" id="profile_photo" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">JPG, PNG, atau GIF (Max. 2MB)</small>
                </div>
            </div>
            @error('profile_photo')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            {{-- Ganti <x-text-input> dengan <input class="form-control"> --}}
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            @error('name')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            {{-- Ganti <x-text-input> dengan <input class="form-control"> --}}
                 <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username"
                     oninvalid="this.setCustomValidity(this.validity.valueMissing ? 'Email wajib diisi.' : 'Masukkan alamat email yang valid.')"
                     oninput="this.setCustomValidity('')" />
            @error('email')
                <div class="text-danger mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-muted mt-2">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3 mt-4">
            {{-- Tombol "Save" Biru Solid dengan icon --}}
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-2"></i>{{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> Profil berhasil diperbarui!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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
</script>