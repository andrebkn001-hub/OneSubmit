@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-primary mb-3" style="color: #1e90ff !important;">
                    <i class="bi bi-person-circle me-3"></i>Kelola Profil
                </h1>
                <p class="lead text-muted">Kelola informasi akun dan pengaturan keamanan Anda</p>
                <div class="mt-4">
                    <img src="{{ asset('images/unri.png') }}" alt="UNRI Logo" class="img-fluid" style="height: 60px; opacity: 0.8;">
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Cards -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">

            <!-- Profile Information Card -->
            <div class="card border-0 shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border-radius: 20px 20px 0 0 !important; color: white;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-person-fill fs-4 me-3"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Informasi Profil</h4>
                            <small class="opacity-75">Update your account's profile information and email address.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Password Update Card -->
            <div class="card border-0 shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #ff9800 0%, #f57c00 100%); border-radius: 20px 20px 0 0 !important; color: white;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-shield-lock-fill fs-4 me-3"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Perbarui Kata Sandi</h4>
                            <small class="opacity-75">Ensure your account is using a long, random password to stay secure.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account Card -->
            <div class="card border-0 shadow-lg mb-5" style="border-radius: 20px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border-radius: 20px 20px 0 0 !important; color: white;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Hapus Akun</h4>
                            <small class="opacity-75">Once your account is deleted, all of its resources and data will be permanently deleted.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-5">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }

    .card-body {
        padding: 2rem !important;
    }
}
</style>
@endsection
