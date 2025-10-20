@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Status Proposal Saya</h1>

    @if($proposals->isEmpty())
        <div class="alert alert-info">Belum ada proposal yang diajukan.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Judul Proposal</th>
                        <th>Bidang Minat</th>
                        <th>File Proposal</th>
                        <th>Status</th>
                        <th>Diajukan Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proposals as $index => $proposal)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $proposal->judul }}</td>
                            <td>{{ $proposal->bidang_minat }}</td>
                            <td>
                                @if($proposal->file_path)
                                    <a href="{{ asset('storage/' . $proposal->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">Download</a>
                                @else
                                    Tidak ada file
                                @endif
                            </td>
                            <td>
                                @if($proposal->status === 'Menunggu Verifikasi')
                                    <span class="badge bg-warning text-dark">{{ $proposal->status }}</span>
                                @elseif($proposal->status === 'Disetujui')
                                    <span class="badge bg-success">{{ $proposal->status }}</span>
                                @elseif($proposal->status === 'Ditolak')
                                    <span class="badge bg-danger">{{ $proposal->status }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $proposal->status }}</span>
                                @endif
                            </td>
                            <td>{{ $proposal->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary mt-3">Kembali ke Dashboard</a>
</div>
@endsection
