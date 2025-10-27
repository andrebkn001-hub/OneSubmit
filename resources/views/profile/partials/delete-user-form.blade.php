<section>
    <header>
        <h2 class="h5 fw-bold text-dark">
            {{ __('Delete Account') }}
        </h2>

        <p class="text-secondary mb-3">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    {{-- Tombol utama untuk membuka modal, Biru Solid --}}
    <button type="button" 
        class="btn btn-primary" 
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
            @csrf
            @method('delete')

            <h2 class="h5 fw-bold text-dark mb-2">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="text-secondary mb-4">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mb-3">
                <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                {{-- Ganti <x-text-input> dengan <input class="form-control"> --}}
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-control"
                    placeholder="{{ __('Password') }}"
                />

                @error('password', 'userDeletion')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                {{-- Tombol Batal (Secondary/Abu-abu) --}}
                <button type="button" class="btn btn-secondary me-2" x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </button>

                {{-- Tombol Hapus --}}
                <button type="submit" class="btn btn-info">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>