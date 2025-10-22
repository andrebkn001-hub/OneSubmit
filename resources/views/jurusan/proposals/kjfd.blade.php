@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="text-center mb-4">
        <h2>Pilih Bidang KJFD</h2>
        <p>Pilih bidang KJFD untuk melihat daftar proposal mahasiswa</p>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">DE</h5>
                    <p class="card-text">Data Engineering</p>
                    <a href="{{ route('jurusan.proposals.index', 'DE') }}" class="btn btn-primary">Lihat Proposal</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">IR</h5>
                    <p class="card-text">Information Retrieval</p>
                    <a href="{{ route('jurusan.proposals.index', 'IR') }}" class="btn btn-primary">Lihat Proposal</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">IM</h5>
                    <p class="card-text">Information Management</p>
                    <a href="{{ route('jurusan.proposals.index', 'IM') }}" class="btn btn-primary">Lihat Proposal</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card h-100">
                <div class="card-body text-center">
                    <h5 class="card-title">BI</h5>
                    <p class="card-text">Business Intelligence</p>
                    <a href="{{ route('jurusan.proposals.index', 'BI') }}" class="btn btn-primary">Lihat Proposal</a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ route('jurusan.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
    </div>
</div>
@endsection
