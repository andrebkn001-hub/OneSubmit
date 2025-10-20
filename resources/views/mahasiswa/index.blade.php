@extends('layouts.mahasiswa')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Status Proposal Saya</h5>
        <a href="{{ route('pengajuan.create') }}" class="btn btn-light btn-sm">+ Ajukan Proposal Baru</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped table-bordered align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Judul</th>
                    <th>File</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengajuans as $p)
                    <tr>
                        <td>{{ $p->judul }}</td>
                        <td><a href="{{ asset('storage/'.$p->file_path) }}" target="_blank">Lihat</a></td>
                        <td>
                            @if($p->status == 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif($p->status == 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($p->status == 'revisi')
                                <span class="badge bg-info text-dark">Revisi</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $p->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada proposal</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
