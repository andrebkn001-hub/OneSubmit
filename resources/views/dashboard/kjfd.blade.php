@extends('layouts.app')

@section('content')
<div class="container-fluid"> 

    <div class="row">
        <div class="col-12 text-center"> {{-- Rata Tengah Judul --}}
            <h1 class="mb-2">Dashboard Dosen KJFD</h1>
            <p class="lead text-secondary mb-4">Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
        </div>
    </div>

    {{-- BARIS 1: Proposal Menunggu Verifikasi & Proposal Disetujui --}}
    {{-- Tambahkan d-flex untuk menyamakan tinggi card di baris ini --}}
    <div class="row **d-flex** justify-content-center">
        
        {{-- Card 1: Menunggu Verifikasi --}}
        <div class="col-lg-5 col-md-6 mb-4">
            {{-- Tambahkan h-100 dan d-flex flex-column --}}
            <div class="card bg-primary text-white h-100 d-flex flex-column shadow">
                <div class="card-body flex-grow-1">
                    <h5 class="card-title fw-bold">Proposal Menunggu Verifikasi</h5>
                    <p class="card-text">Proposal yang perlu Anda verifikasi</p>
                    {{-- Di sini Anda bisa menampilkan angka dari query yang Anda miliki jika belum ada --}}
                    <h1 class="display-4 fw-bold mb-3">
                         {{ \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'menunggu verifikasi dosen kjfd')->count() }}
                    </h1>
                    <a href="{{ route('kjfd.proposals.index') }}" class="btn btn-light btn-sm mt-auto">Lihat Proposal</a>
                </div>
            </div>
        </div>

        {{-- Card 2: Proposal Disetujui --}}
        <div class="col-lg-5 col-md-6 mb-4">
            {{-- Tambahkan h-100 dan d-flex flex-column --}}
            <div class="card bg-success text-white h-100 d-flex flex-column shadow">
                <div class="card-body flex-grow-1">
                    <h5 class="card-title fw-bold">Proposal Disetujui</h5>
                    <p class="card-text">Total proposal yang telah Anda setujui</p>
                    <h1 class="display-4 fw-bold mb-3">
                        {{ \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'disetujui')->count() }}
                    </h1>
                    {{-- Hapus btn-sm yang berulang di kode asli Anda --}}
                    <a href="{{ route('kjfd.proposals.index', ['status' => 'disetujui']) }}" class="btn btn-light mt-auto">Lihat Proposal</a>
                </div>
            </div>
        </div>

    </div> 
    {{-- Akhir BARIS 1 --}}

    {{-- BARIS 2: Proposal Direvisi & Proposal Ditolak --}}
    {{-- Tambahkan d-flex untuk menyamakan tinggi card di baris ini --}}
    <div class="row d-flex justify-content-center">

        {{-- Card 3: Proposal Direvisi --}}
        <div class="col-lg-5 col-md-6 mb-4">
            {{-- Tambahkan h-100 dan d-flex flex-column --}}
            <div class="card bg-warning text-dark h-100 d-flex flex-column shadow"> {{-- text-dark agar tulisan terbaca --}}
                <div class="card-body flex-grow-1">
                    <h5 class="card-title fw-bold">Proposal Direvisi</h5>
                    <p class="card-text">Proposal yang sedang direvisi mahasiswa</p>
                    <h1 class="display-4 fw-bold mb-3">
                        {{ \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'revisi')->count() }}
                    </h1>
                    <a href="{{ route('kjfd.proposals.index', ['status' => 'revisi']) }}" class="btn btn-light mt-auto">Lihat Proposal</a>
                </div>
            </div>
        </div>

        {{-- Card 4: Proposal Ditolak --}}
        <div class="col-lg-5 col-md-6 mb-4">
            {{-- Tambahkan h-100 dan d-flex flex-column --}}
            <div class="card bg-danger text-white h-100 d-flex flex-column shadow">
                <div class="card-body flex-grow-1">
                    <h5 class="card-title fw-bold">Proposal Ditolak</h5>
                    <p class="card-text">Total proposal yang telah Anda tolak</p>
                    <h1 class="display-4 fw-bold mb-3">
                        {{ \App\Models\Proposal::where('dosen_kjfd_id', Auth::id())->where('status', 'ditolak')->count() }}
                    </h1>
                    <a href="{{ route('kjfd.proposals.index', ['status' => 'ditolak']) }}" class="btn btn-light mt-auto">Lihat Proposal</a>
                </div>
            </div>
        </div>

    </div>
    {{-- Akhir BARIS 2 --}}


    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
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