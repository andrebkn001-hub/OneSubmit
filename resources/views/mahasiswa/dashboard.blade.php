@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Dashboard Mahasiswa</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm text-center p-3">
                <h5 class="card-title">Ajukan Proposal Baru</h5>
                <p class="card-text">Buat pengajuan proposal tugas akhir baru.</p>
                <a href="{{ route('mahasiswa.proposal.create') }}" class="btn btn-success">Ajukan Proposal</a>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm text-center p-3">
                <h5 class="card-title">Lihat Status Proposal</h5>
                <p class="card-text">Cek status proposal yang sudah dikirim.</p>
                <a href="{{ route('mahasiswa.status') }}" class="btn btn-primary">Lihat Status</a>
            </div>
        </div>
    </div>
</div>
@endsection
