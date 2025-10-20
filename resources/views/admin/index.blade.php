@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Proposal Mahasiswa</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Judul</th>
                <th>Bidang Minat</th>
                <th>Status</th>
                <th>Berkas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposals as $proposal)
                <tr>
                    <td>{{ $proposal->nama_lengkap }}</td>
                    <td>{{ $proposal->nim }}</td>
                    <td>{{ $proposal->judul_proposal }}</td>
                    <td>{{ $proposal->bidang_minat }}</td>
                    <td>{{ $proposal->status }}</td>
                    <td>
                        <a href="{{ asset('storage/' . $proposal->file_proposal) }}" target="_blank">Lihat File</a>
                    </td>
                    <td>
                        @if ($proposal->status == 'Menunggu Validasi')
                            <form action="{{ route('admin.proposals.approve', $proposal->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Terima</button>
                            </form>
                            <form action="{{ route('admin.proposals.reject', $proposal->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @else
                            <span class="text-muted">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
