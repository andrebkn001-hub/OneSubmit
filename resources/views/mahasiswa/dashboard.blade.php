@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-center">Dashboard Mahasiswa</h1>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <i class="fas fa-plus-circle fa-3x text-success"></i>
                    </div>
                    <h5 class="card-title">Ajukan Proposal Baru</h5>
                    <p class="card-text flex-grow-1">Buat pengajuan proposal tugas akhir baru.</p>
                    <a href="{{ route('mahasiswa.proposal.create') }}" class="btn btn-success btn-lg w-100">Ajukan Proposal</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <i class="fas fa-list-check fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">Lihat Status Proposal</h5>
                    <p class="card-text flex-grow-1">Cek status proposal yang sudah dikirim.</p>
                    <a href="{{ route('mahasiswa.status') }}" class="btn btn-primary btn-lg w-100">Lihat Status</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-lg-4">
            <div class="card shadow-sm h-100 text-center">
                <div class="card-body d-flex flex-column">
                    <div class="mb-3">
                        <i class="fas fa-user fa-3x text-info"></i>
                    </div>
                    <h5 class="card-title">Kelola Profil</h5>
                    <p class="card-text flex-grow-1">Update informasi profil Anda.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-info btn-lg w-100">Edit Profil</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ringkasan Proposal</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <h3 class="text-warning">{{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'menunggu_verifikasi')->count() }}</h3>
                                <small class="text-muted">Menunggu Verifikasi</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <h3 class="text-info">{{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'menunggu_verifikasi_dosen_kjfd')->count() }}</h3>
                                <small class="text-muted">Verifikasi KJFD</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <h3 class="text-success">{{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'disetujui')->count() }}</h3>
                                <small class="text-muted">Disetujui</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="border rounded p-3">
                                <h3 class="text-danger">{{ \App\Models\Proposal::where('user_id', auth()->id())->where('status', 'ditolak')->count() }}</h3>
                                <small class="text-muted">Ditolak</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kuota per KJFD -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Kuota Proposal per Bidang KJFD</h5>
                    <small class="text-muted">Batas kuota per bidang : <strong>50</strong> proposal</small>
                </div>
                <div class="card-body">
                    @php
                        $kjfdBidang = [
                            'KJFD Business Intelligence',
                            'KJFD Data Engineering',
                            'KJFD Information Management',
                            'KJFD Information Retrieval'
                        ];
                        $kjfdList = \App\Models\User::where('role', 'dosen_kjfd')
                            ->whereIn('name', $kjfdBidang)
                            ->orderBy('name')
                            ->get();
                    @endphp

                    @if($kjfdList->isEmpty())
                        <div class="alert alert-info">Belum ada data Dosen KJFD.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Dosen KJFD</th>
                                        <th class="text-center">Kuota</th>
                                        <th class="text-center">Sudah ACC</th>
                                        <th class="text-center">Sisa Kuota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($kjfdList as $kjfd)
                                        @php
                                            $accepted = \App\Models\Proposal::where('dosen_kjfd_id', $kjfd->id)
                                                ->where('status', 'disetujui')
                                                ->count();
                                            $limit = 50;
                                            $remaining = max(0, $limit - $accepted);
                                        @endphp
                                        <tr>
                                            <td>{{ $kjfd->name }}</td>
                                            <td class="text-center"><span class="badge bg-secondary">{{ $limit }}</span></td>
                                            <td class="text-center"><span class="badge bg-success">{{ $accepted }}</span></td>
                                            <td class="text-center">
                                                @if($remaining > 0)
                                                    <span class="badge bg-info">{{ $remaining }}</span>
                                                @else
                                                    <span class="badge bg-danger">Penuh</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
