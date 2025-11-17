@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Welcome Header -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-primary mb-3" style="color: #1e90ff !important;">
                    <i class="bi bi-envelope-paper me-3"></i>Status Proposal Saya
                </h1>
                <p class="lead text-muted">Pantau status proposal yang telah Anda ajukan</p>
            </div>
        </div>
    </div>

    {{-- ✅ Pesan sukses jika ada --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- ✅ Jika belum ada proposal --}}
    @if($proposals->isEmpty())
        <div class="card border-0 shadow-lg text-center" style="border-radius: 15px; background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
            <div class="card-body p-5">
                <div class="icon-wrapper mb-4">
                    <i class="bi bi-info-circle fa-4x text-muted"></i>
                </div>
                <h5 class="fw-bold text-muted mb-3">Belum Ada Proposal</h5>
                <p class="text-muted mb-4">Anda belum mengajukan proposal. Silakan ajukan proposal baru untuk memulai proses.</p>
                <a href="{{ route('mahasiswa.proposal.create') }}" class="btn btn-primary btn-lg fw-bold px-4" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border: none; border-radius: 10px;">
                    <i class="bi bi-plus-circle me-2"></i>Ajukan Proposal Sekarang
                </a>
            </div>
        </div>
    @else
        <!-- Table Container -->
        <div class="card border-0 shadow-lg" style="border-radius: 15px;">
            <div class="card-header border-0" style="border-radius: 15px 15px 0 0 !important; background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%) !important; color: white;">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="mb-0 fw-bold">
                        <i class="bi bi-list-check me-2"></i>Daftar Proposal
                    </h4>
                    <div class="badge bg-light text-primary fs-6 px-3 py-2" style="border-radius: 20px;">
                        <i class="bi bi-file-earmark-text me-1"></i>{{ $proposals->count() }} Proposal
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="statusProposalsTable" class="table table-hover mb-0">
                        <thead style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                            <tr>
                                <th class="border-0 fw-bold py-3 px-4">
                                    <i class="bi bi-person-badge me-2"></i>NIM
                                </th>
                                <th class="border-0 fw-bold py-3 px-4">
                                    <i class="bi bi-person me-2"></i>Nama Lengkap
                                </th>
                                <th class="border-0 fw-bold py-3 px-4">
                                    <i class="bi bi-file-earmark-text me-2"></i>Judul Proposal
                                </th>
                                <th class="border-0 fw-bold py-3 px-4">
                                    <i class="bi bi-tags me-2"></i>Bidang Minat
                                </th>
                                <th class="border-0 fw-bold py-3 px-4">
                                    <i class="bi bi-flag me-2"></i>Status
                                </th>
                                <th class="border-0 fw-bold py-3 px-4">
                                    <i class="bi bi-folder me-2"></i>Berkas
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proposals as $proposal)
                                <tr class="border-bottom border-light hover-row">
                                    {{-- ✅ Pastikan nama kolom di database cocok --}}
                                    <td class="py-3 px-4 fw-semibold">{{ $proposal->nim ?? '-' }}</td>
                                    <td class="py-3 px-4">{{ $proposal->nama_lengkap ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        <div class="fw-semibold text-primary">{{ $proposal->judul ?? '-' }}</div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="badge" style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); border-radius: 20px; font-weight: 600;">
                                            {{ $proposal->bidang_minat ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- ✅ Status tampil dengan badge warna berbeda --}}
                                    <td class="py-3 px-4">
                                        @switch(strtolower($proposal->status))
                                            @case('menunggu_verifikasi')
                                                <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); color: #856404; border-radius: 20px; font-weight: 600;">
                                                    <i class="bi bi-clock me-1"></i>Menunggu Verifikasi Admin
                                                </span>
                                                @break
                                            @case('menunggu_verifikasi_dosen_kjfd')
                                                <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #0dcaf0 0%, #0aa2c0 100%); color: white; border-radius: 20px; font-weight: 600;">
                                                    <i class="bi bi-person-check me-1"></i>Menunggu Verifikasi KJFD
                                                </span>
                                                @break
                                            @case('disetujui')
                                                <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #198754 0%, #157347 100%); border-radius: 20px; font-weight: 600;">
                                                    <i class="bi bi-check-circle me-1"></i>Disetujui
                                                </span>
                                                @break
                                            @case('ditolak')
                                                <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); border-radius: 20px; font-weight: 600;">
                                                    <i class="bi bi-x-circle me-1"></i>Ditolak
                                                </span>
                                                @if ($proposal->rejection_message)
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalRejection{{ $proposal->id }}" style="border-radius: 20px;">
                                                            <i class="bi bi-info-circle me-1"></i>Lihat Alasan
                                                        </button>
                                                    </div>
                                                @endif
                                                @break
                                            @case('revisi')
                                                <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #fd7e14 0%, #e8680d 100%); color: white; border-radius: 20px; font-weight: 600;">
                                                    <i class="bi bi-arrow-repeat me-1"></i>Revisi
                                                </span>
                                                @if ($proposal->revision_message)
                                                    <div class="mt-2">
                                                        <button type="button" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#modalRevision{{ $proposal->id }}" style="border-radius: 20px;">
                                                            <i class="bi bi-info-circle me-1"></i>Lihat Pesan Revisi
                                                        </button>
                                                    </div>
                                                @endif
                                                @break
                                            @default
                                                <span class="badge fs-6 px-3 py-2" style="background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%); border-radius: 20px; font-weight: 600;">
                                                    {{ ucfirst($proposal->status ?? 'Tidak diketahui') }}
                                                </span>
                                        @endswitch
                                    </td>

                                    {{-- ✅ Tombol lihat file --}}
                                    <td class="py-3 px-4">
                                        <div class="d-flex flex-column gap-2">
                                            @if ($proposal->file_path)
                                                <a href="{{ route('mahasiswa.proposal.view-file', $proposal->id) }}" target="_blank" class="btn btn-sm btn-primary" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border: none; border-radius: 20px; font-weight: 600;">
                                                    <i class="bi bi-file-earmark-text me-1"></i> Proposal
                                                </a>
                                            @else
                                                <span class="text-muted small"><i class="bi bi-dash-circle me-1"></i>Tidak ada file</span>
                                            @endif

                                            @if ($proposal->acc_letter_path && $proposal->status === 'disetujui')
                                                <a href="{{ route('mahasiswa.proposal.download-acc', $proposal->id) }}" target="_blank" class="btn btn-sm btn-success" style="background: linear-gradient(135deg, #198754 0%, #157347 100%); border: none; border-radius: 20px; font-weight: 600;">
                                                    <i class="bi bi-file-earmark-check me-1"></i> Surat ACC
                                                </a>
                                            @endif

                                            {{-- Jika mahasiswa baru saja mengupload revisi, tampilkan keterangan; jika masih berstatus revisi, tampilkan tombol upload --}}
                                            @if(session('revision_uploaded') == $proposal->id)
                                                <div class="alert alert-success py-2 px-3 mb-0" style="border-radius: 10px; font-size: 0.85rem;">
                                                    <i class="bi bi-check-circle me-1"></i> Revisi telah diupload
                                                </div>
                                            @elseif($proposal->status === 'revisi')
                                                <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $proposal->id }}" style="background: linear-gradient(135deg, #fd7e14 0%, #e8680d 100%); border: none; border-radius: 20px; font-weight: 600;">
                                                    <i class="bi bi-upload me-1"></i> Upload Revisi
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <!-- Upload Revisi Modal -->
                                <div class="modal fade" id="uploadModal{{ $proposal->id }}" tabindex="-1" aria-labelledby="uploadModalLabel{{ $proposal->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content" style="border-radius: 15px; border: none;">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); color: white; border-radius: 15px 15px 0 0;">
                                                <h5 class="modal-title fw-bold" id="uploadModalLabel{{ $proposal->id }}">
                                                    <i class="bi bi-upload me-2"></i>Upload Revisi Proposal
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('mahasiswa.proposal.revisi', ['id' => $proposal->id]) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body p-4">
                                                    <div class="mb-4">
                                                        <label for="judul_{{ $proposal->id }}" class="form-label fw-bold">
                                                            <i class="bi bi-file-earmark-text me-2"></i>Judul Proposal
                                                        </label>
                                                        <input type="text" class="form-control" id="judul_{{ $proposal->id }}" name="judul" value="{{ $proposal->judul }}" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="bidang_minat_{{ $proposal->id }}" class="form-label fw-bold">
                                                            <i class="bi bi-tags me-2"></i>Bidang Minat
                                                        </label>
                                                        <select class="form-select" id="bidang_minat_{{ $proposal->id }}" name="bidang_minat" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                                                            <option value="">-- Pilih Bidang --</option>
                                                            <option value="Information Management" {{ $proposal->bidang_minat == 'Information Management' ? 'selected' : '' }}>Information Management</option>
                                                            <option value="Business Intelligence" {{ $proposal->bidang_minat == 'Business Intelligence' ? 'selected' : '' }}>Business Intelligence</option>
                                                            <option value="Data Engineering" {{ $proposal->bidang_minat == 'Data Engineering' ? 'selected' : '' }}>Data Engineering</option>
                                                            <option value="Information Retrieval" {{ $proposal->bidang_minat == 'Information Retrieval' ? 'selected' : '' }}>Information Retrieval</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="file_proposal_{{ $proposal->id }}" class="form-label fw-bold">
                                                            <i class="bi bi-cloud-upload me-2"></i>Unggah Berkas Proposal Baru
                                                        </label>
                                                        <input type="file" class="form-control" id="file_proposal_{{ $proposal->id }}" name="file_proposal" accept=".pdf,.doc,.docx" required style="border-radius: 10px; border: 2px solid #e9ecef;">
                                                        <div class="form-text mt-2">
                                                            <i class="bi bi-info-circle me-1"></i>Ukuran minimal: 200 KB, maksimal: 5 MB
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer" style="border-top: none; padding: 1rem 2rem;">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600;">
                                                        <i class="bi bi-x-circle me-1"></i>Batal
                                                    </button>
                                                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border: none; border-radius: 10px; font-weight: 600;">
                                                        <i class="bi bi-send me-1"></i>Kirim Revisi
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for Rejection Message -->
                                <div class="modal fade" id="modalRejection{{ $proposal->id }}" tabindex="-1" aria-labelledby="modalRejectionLabel{{ $proposal->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="border-radius: 15px; border: none;">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #b02a37 100%); color: white; border-radius: 15px 15px 0 0;">
                                                <h5 class="modal-title fw-bold" id="modalRejectionLabel{{ $proposal->id }}">
                                                    <i class="bi bi-x-circle me-2"></i>Alasan Penolakan
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="alert alert-danger" style="border-radius: 10px; border: none;">
                                                    <h6 class="fw-bold mb-2">{{ $proposal->judul }}</h6>
                                                    <p class="mb-0">{{ $proposal->rejection_message ?? 'Tidak ada alasan yang diberikan.' }}</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: none;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600;">
                                                    <i class="bi bi-check-circle me-1"></i>Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal for Revision Message -->
                                <div class="modal fade" id="modalRevision{{ $proposal->id }}" tabindex="-1" aria-labelledby="modalRevisionLabel{{ $proposal->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="border-radius: 15px; border: none;">
                                            <div class="modal-header" style="background: linear-gradient(135deg, #fd7e14 0%, #e8680d 100%); color: white; border-radius: 15px 15px 0 0;">
                                                <h5 class="modal-title fw-bold" id="modalRevisionLabel{{ $proposal->id }}">
                                                    <i class="bi bi-arrow-repeat me-2"></i>Pesan Revisi
                                                </h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="alert alert-warning" style="border-radius: 10px; border: none;">
                                                    <h6 class="fw-bold mb-2">{{ $proposal->judul }}</h6>
                                                    <p class="mb-0">{{ $proposal->revision_message ?? 'Tidak ada pesan revisi yang diberikan.' }}</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer" style="border-top: none;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="border-radius: 10px; font-weight: 600;">
                                                    <i class="bi bi-check-circle me-1"></i>Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.hover-row {
    transition: all 0.3s ease;
}

.hover-row:hover {
    background-color: rgba(25, 118, 210, 0.05) !important;
    transform: scale(1.01);
}

.icon-wrapper {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

.table th {
    border-top: none !important;
    font-size: 0.95rem;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
    font-size: 0.9rem;
}

.badge {
    font-weight: 600;
    letter-spacing: 0.5px;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.modal-content {
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}

.alert {
    border-radius: 10px !important;
    border: none !important;
}
</style>

<script>
$(document).ready(function() {
    $('#statusProposalsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [5] }
        ]
    });
});
</script>
@endsection
