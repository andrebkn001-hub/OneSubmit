@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">📑 Daftar Proposal Tugas Dosen KJFD</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($proposals->isEmpty())
        <div class="alert alert-warning">Belum ada proposal yang ditugaskan.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Mahasiswa</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proposals as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $p->judul }}</td>
                        <td>{{ $p->mahasiswa->nama ?? '-' }}</td>
                        <td>
                            @if($p->status == 'diterima')
                                <span class="badge bg-success">Diterima</span>
                            @elseif($p->status == 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Belum Dinilai</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('proposal.show', $p->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
