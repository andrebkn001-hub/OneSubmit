@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Status Proposal Saya</h2>

    {{-- ✅ Pesan sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ✅ Jika belum ada proposal --}}
    @if($proposals->isEmpty())
        <div class="alert alert-info">Kamu belum mengajukan proposal.</div>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>Judul Proposal</th>
                    <th>Bidang Minat</th>

                    <th>Status</th>
                    <th>Berkas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($proposals as $proposal)
                    <tr>
                        {{-- ✅ Pastikan nama kolom di database cocok --}}
                        <td>{{ $proposal->judul ?? '-' }}</td>
                        <td>{{ $proposal->bidang_minat ?? '-' }}</td>


                        {{-- ✅ Status tampil dengan badge warna berbeda --}}
                        <td>
                            @switch($proposal->status)
                                @case('Menunggu Verifikasi')
                                    <span class="badge bg-warning text-dark">{{ $proposal->status }}</span>
                                    @break
                                @case('Disetujui')
                                    <span class="badge bg-success">{{ $proposal->status }}</span>
                                    @break
                                @case('Ditolak')
                                    <span class="badge bg-danger">{{ $proposal->status }}</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $proposal->status ?? 'Tidak diketahui' }}</span>
                            @endswitch
                        </td>

                        {{-- ✅ Tombol lihat file --}}
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
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
