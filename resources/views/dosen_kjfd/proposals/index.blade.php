@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Daftar Proposal Mahasiswa untuk Verifikasi</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('kjfd.proposals.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-4">
                <input type="text" name="nim" class="form-control" placeholder="Cari berdasarkan NIM..." value="{{ request('nim') }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="menunggu verifikasi dosen kjfd" {{ request('status') == 'menunggu verifikasi dosen kjfd' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Revisi</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">Cari</button>
            </div>
            @if(request('nim') || request('status'))
                <div class="col-md-2">
                    <a href="{{ route('kjfd.proposals.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
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
                            <a href="{{ route('kjfd.proposals.view-file', $proposal->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                Lihat File
                            </a>
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </td>
                    <td>
                        @if($proposal->status === 'menunggu verifikasi dosen kjfd' || $proposal->status === 'revisi')
                            <form action="{{ route('kjfd.proposals.approve', $proposal->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Terima</button>
                            </form>
                            {{-- Tombol memanggil Modal --}}
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reviseModal{{ $proposal->id }}">Revisi</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $proposal->id }}">Tolak</button>
                        @else
                            <span class="text-muted">Sudah diproses</span>
                        @endif

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
                                                <label for="revision_message_{{ $proposal->id }}" class="form-label">Pesan Revisi (Minimal 10 Karakter)</label>
                                                {{-- 🚀 PERBAIKAN: Menambahkan minlength="10" untuk mencocokkan Controller --}}
                                                <textarea class="form-control" id="revision_message_{{ $proposal->id }}" name="revision_message" rows="3" required minlength="10"></textarea>
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
                                                <label for="rejection_message_{{ $proposal->id }}" class="form-label">Alasan Penolakan (Minimal 10 Karakter)</label>
                                                {{-- 🚀 PERBAIKAN: Menambahkan minlength="10" untuk mencocokkan Controller --}}
                                                <textarea class="form-control" id="rejection_message_{{ $proposal->id }}" name="rejection_message" rows="3" required minlength="10"></textarea>
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