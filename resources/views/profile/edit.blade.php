@extends('layouts.app') 

@section('content')
    <div class="container-fluid">
        
        {{-- Header Page --}}
        <h2 class="fw-bold mb-4 text-center">
            Kelola Profil
        </h2>

        {{-- Baris untuk Konten Profil --}}
        <div class="row">
            
            {{-- KOLOM PEMBUNGKUS: col-md-8 mx-auto (Rata Tengah) --}}
            <div class="col-md-8 mx-auto">
                
                {{-- Bagian Update Profil Information --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">
                        Informasi Profil
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                {{-- Bagian Update Password --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">
                        Perbarui Kata Sandi
                    </div>
                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- Bagian Delete User --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white fw-bold">
                        Hapus Akun
                    </div>
                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div> {{-- Akhir dari col-md-8 mx-auto --}}
        </div>
    </div>
@endsection