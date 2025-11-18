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
        <div class="row g-2">
            <div class="col-md-3">
                <input type="text" name="nim" class="form-control" placeholder="Cari NIM..." value="{{ request('nim') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Cari Nama Mahasiswa..." value="{{ request('nama_lengkap') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="judul" class="form-control" placeholder="Cari Judul Proposal..." value="{{ request('judul') }}">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="menunggu_verifikasi_dosen_kjfd" {{ request('status') == 'menunggu_verifikasi_dosen_kjfd' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="revisi" {{ request('status') == 'revisi' ? 'selected' : '' }}>Revisi</option>
                    <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100" type="submit">Cari</button>
            </div>
            @if(request('nim') || request('nama_lengkap') || request('judul') || request('status'))
                <div class="col-md-1">
                    <a href="{{ route('kjfd.proposals.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            @endif
        </div>
    </form>

    <div class="table-responsive">
        <table id="kjfdProposalsTable" class="table table-striped align-middle">
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
            @if($proposals->count() > 0)
            @foreach ($proposals as $index => $proposal)
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
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detailModal{{ $proposal->id }}">Detail</button>
                        @if($proposal->status === 'menunggu_verifikasi_dosen_kjfd')
                            <form action="{{ route('kjfd.proposals.approve', $proposal->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Terima</button>
                            </form>
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#reviseModal{{ $proposal->id }}">Revisi</button>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $proposal->id }}">Tolak</button>
                        @elseif($proposal->status === 'revisi')
                            <span class="text-muted">Menunggu upload revisi mahasiswa</span>
                        @else
                            <span class="text-muted">Sudah diproses</span>
                        @endif

                        <!-- Modal Detail Riwayat Proposal -->
                        <div class="modal fade" id="detailModal{{ $proposal->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $proposal->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="detailModalLabel{{ $proposal->id }}">Detail Riwayat Proposal</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group mb-3">
                                            <li class="list-group-item"><strong>Status Saat Ini:</strong> {{ ucfirst($proposal->status) }}</li>
                                            @if($proposal->revision_message)
                                                <li class="list-group-item"><strong>Pesan Revisi:</strong> {{ $proposal->revision_message }}</li>
                                            @endif
                                            @if($proposal->rejection_message)
                                                <li class="list-group-item"><strong>Alasan Penolakan:</strong> {{ $proposal->rejection_message }}</li>
                                            @endif
                                            @if($proposal->acc_letter_path)
                                                <li class="list-group-item"><strong>Surat ACC:</strong> <a href="{{ Storage::url($proposal->acc_letter_path) }}" target="_blank">Download</a></li>
                                            @endif
                                        </ul>
                                        <div><strong>Judul Proposal:</strong> {{ $proposal->judul }}</div>
                                        <div><strong>Bidang Minat:</strong> {{ $proposal->bidang_minat }}</div>
                                        <div><strong>Nama Mahasiswa:</strong> {{ $proposal->nama_lengkap }}</div>
                                        <div><strong>NIM:</strong> {{ $proposal->nim }}</div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Revisi -->
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

                        <!-- Modal Penolakan -->
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
            @endforeach
            @endif
        </tbody>
        </table>
    </div>
</div>

@section('footer-scripts')
<script>
$(document).ready(function() {
    const table = $('#kjfdProposalsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        stateSave: true,
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [6, 7] }
        ]
    });
    // Penyesuaian margin/padding untuk mobile
    if(window.innerWidth <= 768){
        $('.container').css({'padding':'0 2px','margin':'0'});
    }
});
</script>
@endsection
@endsection