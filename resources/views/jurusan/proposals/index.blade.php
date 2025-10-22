@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Daftar Proposal Mahasiswa - Bidang {{ $bidang }}</h2>
        <a href="{{ route('jurusan.proposals.kjfd') }}" class="btn btn-secondary">Kembali</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('jurusan.proposals.index', $bidang) }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="nim" class="form-control" placeholder="Cari berdasarkan NIM..." value="{{ request('nim') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
            @if(request('nim'))
                <a href="{{ route('jurusan.proposals.index', $bidang) }}" class="btn btn-secondary">Reset</a>
            @endif
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Judul Proposal</th>
                <th>Tanggal Upload Proposal</th>
                <th>Status Proposal</th>
                <th>File Proposal</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proposals as $index => $proposal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $proposal->nama_lengkap }}</td>
                    <td>{{ $proposal->nim }}</td>
                    <td>{{ $proposal->judul }}</td>
                    <td>{{ $proposal->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        @php
                            $badgeClass = 'secondary';
                            $statusText = ucfirst($proposal->status);
                            if (strtolower($proposal->status) == 'disetujui') {
                                $badgeClass = 'success';
                            } elseif (strtolower($proposal->status) == 'ditolak') {
                                $badgeClass = 'danger';
                            } elseif (strtolower($proposal->status) == 'menunggu verifikasi dosen kjfd') {
                                $badgeClass = 'info';
                                $statusText = 'Menunggu Verifikasi Dosen KJFD';
                            } elseif (strtolower($proposal->status) == 'revisi') {
                                $badgeClass = 'warning';
                                $statusText = 'Revisi';
                            }
                        @endphp
                        <span class="badge bg-{{ $badgeClass }}">
                            {{ $statusText }}
                        </span>
                    </td>
                    <td>
                        @if ($proposal->file_path)
                            <a href="{{ asset('storage/'.$proposal->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                Lihat File
                            </a>
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada proposal yang diajukan untuk bidang {{ $bidang }}.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
