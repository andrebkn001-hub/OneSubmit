@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="text-center">
        <h1 class="mb-4">Dashboard Ketua Jurusan</h1>
        <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
    </div>

    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Daftar Proposal Mahasiswa</h5>
                    <p class="card-text">Lihat dan kelola proposal mahasiswa berdasarkan bidang KJFD</p>
                    <a href="{{ route('jurusan.proposals.kjfd') }}" class="btn btn-primary">Lihat Proposal</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
