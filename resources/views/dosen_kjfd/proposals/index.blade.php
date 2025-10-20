@extends('layouts.admin') {{-- Assuming dosen_kjfd uses admin layout or a similar one --}}

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Daftar Proposal Mahasiswa untuk Verifikasi</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('kjfd.proposals.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="nim" class="form-control" placeholder="Cari berdasarkan NIM..." value="{{ request('nim') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
            @if(request('nim'))
                <a href="{{ route('kjfd.proposals.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </div>
    </form>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIM</th>
                <th>Judul Proposal</th>
                <th>Bidang Minat</th>
                <th>Status</th>
                <th>Berkas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($proposals as $index => $proposal)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $proposal->nama_lengkap }}</td>
                    <td>{{ $proposal->nim }}</td>
                    <td>{{ $proposal->judul }}</td>
                    <td>{{ $proposal->bidang_minat }}</td>
                    <td>
                        <span class="badge bg-info">
                            {{ ucfirst($proposal->status) }}
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
                    <td>
                        <form action="{{ route('kjfd.proposals.approve', $proposal->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Terima</button>
                        </form>
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reviseModal{{ $proposal->id }}">Revisi</button>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $proposal->id }}">Tolak</button>

                        <!-- Revisi Modal -->
                        <div class="modal fade" id="reviseModal{{ $proposal->id }}" tabindex="-1" aria-labelledby="reviseModalLabel{{ $proposal->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="reviseModalLabel{{ $proposal->id }}">Revisi Proposal: {{ $proposal->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('kjfd.proposals.revise', $proposal->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="revision_message_{{ $proposal->id }}" class="form-label">Pesan Revisi</label>
                                                <textarea class="form-control" id="revision_message_{{ $proposal->id }}" name="revision_message" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning">Kirim Revisi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $proposal->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $proposal->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel{{ $proposal->id }}">Tolak Proposal: {{ $proposal->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('kjfd.proposals.reject', $proposal->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="rejection_message_{{ $proposal->id }}" class="form-label">Alasan Penolakan</label>
                                                <textarea class="form-control" id="rejection_message_{{ $proposal->id }}" name="rejection_message" rows="3" required></textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Tolak Proposal</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada proposal yang perlu diverifikasi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
