@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Dashboard Dosen KJFD</h1>
            <p class="mb-4">Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
        </div>
    </div>

    <div class="row">
        <!-- Card untuk Proposal Menunggu Verifikasi -->
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Proposal Menunggu Verifikasi</h5>
                    <p class="card-text">Proposal yang perlu Anda verifikasi</p>
                    <a href="{{ route('kjfd.proposals.index') }}" class="btn btn-light">Lihat Proposal</a>
                </div>
            </div>
        </div>

        <!-- Card untuk Statistik -->
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Proposal Disetujui</h5>
                    <p class="card-text">Total proposal yang telah Anda setujui</p>
                    <h3>{{ \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'disetujui')->count() }}</h3>
                    <a href="{{ route('kjfd.proposals.index', ['status' => 'disetujui']) }}" class="btn btn-light btn-sm mt-2">Lihat Proposal</a>
                </div>
            </div>
        </div>

        <!-- Card untuk Proposal Direvisi -->
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">Proposal Direvisi</h5>
                    <p class="card-text">Proposal yang sedang direvisi mahasiswa</p>
                    <h3>{{ \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'revisi')->count() }}</h3>
                    <a href="{{ route('kjfd.proposals.index', ['status' => 'revisi']) }}" class="btn btn-light btn-sm mt-2">Lihat Proposal</a>
                </div>
            </div>
        </div>

        <!-- Card untuk Proposal Ditolak -->
        <div class="col-md-4 mb-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Proposal Ditolak</h5>
                    <p class="card-text">Total proposal yang telah Anda tolak</p>
                    <h3>{{ \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'ditolak')->count() }}</h3>
                    <a href="{{ route('kjfd.proposals.index', ['status' => 'ditolak']) }}" class="btn btn-light btn-sm mt-2">Lihat Proposal</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Proposal Terbaru -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Proposal Terbaru untuk Verifikasi</h5>
                </div>
                <div class="card-body">
                    @php
                        $recentProposals = \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())
                            ->where('status', 'menunggu verifikasi dosen kjfd')
                            ->latest()
                            ->take(5)
                            ->get();
                    @endphp

                    @if($recentProposals->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Judul</th>
                                        <th>Bidang</th>
                                        <th>Diajukan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentProposals as $proposal)
                                        <tr>
                                            <td>{{ $proposal->nim }}</td>
                                            <td>{{ $proposal->nama_lengkap }}</td>
                                            <td>{{ $proposal->judul }}</td>
                                            <td>{{ $proposal->bidang_minat }}</td>
                                            <td>{{ $proposal->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('kjfd.proposals.index') }}" class="btn btn-sm btn-primary">Verifikasi</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada proposal baru untuk diverifikasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
