@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Status Proposal Saya</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('pengajuan.create') }}" class="btn btn-success mb-3">+ Ajukan Proposal</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>File</th>
                <th>Status</th>
                <th>Dikirim</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $p)
                <tr>
                    <td>{{ $p->judul }}</td>
                    <td><a href="{{ asset('storage/'.$p->file_path) }}" target="_blank">Lihat File</a></td>
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
                <tr><td colspan="4" class="text-center">Belum ada proposal</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection