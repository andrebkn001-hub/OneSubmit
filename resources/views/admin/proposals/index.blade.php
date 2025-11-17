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

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('admin.proposals.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="nim" class="form-control" placeholder="Cari berdasarkan NIM..." value="{{ request('nim') }}">
            <button class="btn btn-primary" type="submit">Cari</button>
            @if(request('nim'))
                <a href="{{ route('admin.proposals.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </div>
    </form>

    <table id="proposalsTable" class="table table-striped">
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
                        @php
                            $badgeClass = 'secondary';
                            $statusText = ucfirst($proposal->status);
                            if (strtolower($proposal->status) == 'disetujui') {
                                $badgeClass = 'success';
                            } elseif (strtolower($proposal->status) == 'ditolak') {
                                $badgeClass = 'danger';
                            } elseif (strtolower($proposal->status) == 'menunggu_verifikasi_dosen_kjfd') {
                                $badgeClass = 'info';
                                $statusText = 'Menunggu Verifikasi Dosen KJFD';
                            } elseif (strtolower($proposal->status) == 'revisi') {
                                $badgeClass = 'warning';
                                $statusText = 'Revisi';
                            }
                        @endphp
                        <span class="badge bg-{{ $badgeClass }}">
                            {{ $statusText }}
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
                        @if (strtolower($proposal->status) == 'menunggu_verifikasi')
                            <form action="{{ route('admin.proposals.approve', $proposal->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Teruskan ke KJFD</button>
                            </form>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $proposal->id }}">Tolak</button>
                        @else
                            <button type="button" class="btn btn-secondary btn-sm" disabled>Aksi Tidak Tersedia</button>
                        @endif

                        <!-- Reject Modal -->
                        <div class="modal fade" id="rejectModal{{ $proposal->id }}" tabindex="-1" aria-labelledby="rejectModalLabel{{ $proposal->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="rejectModalLabel{{ $proposal->id }}">Tolak Proposal: {{ $proposal->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.proposals.reject', $proposal->id) }}" method="POST">
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
                    <td colspan="8" class="text-center">Belum ada proposal yang diajukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#proposalsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12 col-md-6"B>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5]
                }
            }
        ],
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [6, 7] }
        ]
    });
});
</script>
@endsection
