@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Daftar Proposal Mahasiswa</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIM</th>
                <th>Judul Proposal</th>
                <th>Bidang Minat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proposals as $index => $proposal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $proposal->nama_lengkap }}</td>
                    <td>{{ $proposal->nim }}</td>
                    <td>{{ $proposal->judul_proposal }}</td>
                    <td>{{ $proposal->bidang_minat }}</td>
                    <td>
                        <span class="badge bg-{{ $proposal->status == 'disetujui' ? 'success' : ($proposal->status == 'ditolak' ? 'danger' : 'secondary') }}">
                            {{ ucfirst($proposal->status) }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('admin.proposals.approve', $proposal->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Terima</button>
                        </form>
                        <form action="{{ route('admin.proposals.reject', $proposal->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada proposal yang diajukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
