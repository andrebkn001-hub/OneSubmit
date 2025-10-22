@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">Akses Ditolak</h4>
                </div>
                <div class="card-body text-center">
                    <h1 class="display-1 text-danger">403</h1>
                    <h3 class="card-title">Forbidden</h3>
                    <p class="card-text">
                        Anda tidak memiliki izin untuk mengakses halaman ini.
                    </p>
                    <a href="{{ url()->previous() }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
