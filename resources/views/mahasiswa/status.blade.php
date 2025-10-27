@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Status Proposal Saya</h2>

            {{-- ✅ Pesan sukses jika ada --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- ✅ Jika belum ada proposal --}}
            @if($proposals->isEmpty())
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-2"></i>
                    <h5>Kamu belum mengajukan proposal.</h5>
                    <p>Silakan ajukan proposal baru untuk memulai proses.</p>
                    <a href="{{ route('mahasiswa.proposal.create') }}" class="btn btn-primary">Ajukan Proposal Sekarang</a>
                </div>
            @else
                <!-- Form Pencarian -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('mahasiswa.status') }}" class="row g-3">
                            <div class="col-12 col-md-8">
                                <label for="nim" class="form-label">Cari berdasarkan NIM</label>
                                <input type="text" id="nim" name="nim" class="form-control" placeholder="Masukkan NIM..." value="{{ request('nim') }}">
                            </div>
                            <div class="col-12 col-md-4 d-flex align-items-end">
                                <button class="btn btn-primary me-2" type="submit">
                                    <i class="fas fa-search"></i> Cari
                                </button>
                                @if(request('nim'))
                                    <a href="{{ route('mahasiswa.status') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Reset
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Daftar Proposal</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
            <thead class="table-primary">
                <tr>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
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
                        <td>{{ $proposal->nim ?? '-' }}</td>
                        <td>{{ $proposal->nama_lengkap ?? '-' }}</td>
                        <td>{{ $proposal->judul ?? '-' }}</td>
                        <td>{{ $proposal->bidang_minat ?? '-' }}</td>


                        {{-- ✅ Status tampil dengan badge warna berbeda --}}
                        <td>
                            @switch(strtolower($proposal->status))
                                @case('menunggu verifikasi')
                                    <span class="badge bg-warning text-dark">Menunggu Verifikasi Admin</span>
                                    @break
                                @case('menunggu verifikasi dosen kjfd')
                                    <span class="badge bg-info text-dark">Menunggu Verifikasi Dosen KJFD</span>
                                    @break
                                @case('disetujui')
                                    <span class="badge bg-success">Disetujui</span>
                                    @break
                                @case('ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @if ($proposal->rejection_message)
                                        <br><small class="text-muted">Alasan: {{ $proposal->rejection_message }}</small>
                                    @endif
                                    @break
                                @case('revisi')
                                    <span class="badge bg-warning text-dark">Revisi</span>
                                    @if ($proposal->revision_message)
                                        <br><small class="text-muted">Pesan Revisi: {{ $proposal->revision_message }}</small>
                                    @endif
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ ucfirst($proposal->status ?? 'Tidak diketahui') }}</span>
                            @endswitch
                        </td>

                        {{-- ✅ Tombol lihat file --}}
                        <td>
                            @if ($proposal->file_path)
                                <a href="{{ route('mahasiswa.proposal.view-file', $proposal->id) }}" target="_blank" class="btn btn-sm btn-primary">
                                    Lihat File
                                </a>
                            @else
                                <span class="text-muted">Tidak ada file</span>
                            @endif
                        </td>

                        <!-- Upload Revisi Modal -->
                        <div class="modal fade" id="uploadModal{{ $proposal->id }}" tabindex="-1" aria-labelledby="uploadModalLabel{{ $proposal->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="uploadModalLabel{{ $proposal->id }}">Upload Revisi Proposal: {{ $proposal->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('mahasiswa.proposal.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="judul_{{ $proposal->id }}" class="form-label">Judul Proposal</label>
                                                <input type="text" class="form-control" id="judul_{{ $proposal->id }}" name="judul" value="{{ $proposal->judul }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="bidang_minat_{{ $proposal->id }}" class="form-label">Bidang Minat</label>
                                                <select class="form-select" id="bidang_minat_{{ $proposal->id }}" name="bidang_minat" required>
                                                    <option value="">-- Pilih Bidang --</option>
                                                    <option value="Information Management" {{ $proposal->bidang_minat == 'Information Management' ? 'selected' : '' }}>Information Management</option>
                                                    <option value="Business Intelligence" {{ $proposal->bidang_minat == 'Business Intelligence' ? 'selected' : '' }}>Business Intelligence</option>
                                                    <option value="Data Engineering" {{ $proposal->bidang_minat == 'Data Engineering' ? 'selected' : '' }}>Data Engineering</option>
                                                    <option value="Information Retrieval" {{ $proposal->bidang_minat == 'Information Retrieval' ? 'selected' : '' }}>Information Retrieval</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="file_proposal_{{ $proposal->id }}" class="form-label">Unggah Berkas Proposal Baru</label>
                                                <input type="file" class="form-control" id="file_proposal_{{ $proposal->id }}" name="file_proposal" accept=".pdf,.doc,.docx" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Kirim Revisi</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Rejection Message -->
                        <div class="modal fade" id="modalRejection{{ $proposal->id }}" tabindex="-1" aria-labelledby="modalRejectionLabel{{ $proposal->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalRejectionLabel{{ $proposal->id }}">Alasan Penolakan Proposal: {{ $proposal->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ $proposal->rejection_message ?? 'Tidak ada alasan yang diberikan.' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Revision Message -->
                        <div class="modal fade" id="modalRevision{{ $proposal->id }}" tabindex="-1" aria-labelledby="modalRevisionLabel{{ $proposal->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalRevisionLabel{{ $proposal->id }}">Pesan Revisi Proposal: {{ $proposal->judul }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{ $proposal->revision_message ?? 'Tidak ada pesan revisi yang diberikan.' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection
