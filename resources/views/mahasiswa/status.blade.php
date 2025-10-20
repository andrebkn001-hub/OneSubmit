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
        <!-- Form Pencarian -->
        <form method="GET" action="{{ route('mahasiswa.status') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="nim" class="form-control" placeholder="Cari berdasarkan NIM..." value="{{ request('nim') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
                @if(request('nim'))
                    <a href="{{ route('mahasiswa.status') }}" class="btn btn-secondary">Reset</a>
                @endif
            </div>
        </form>
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-primary">
                <tr>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Judul Proposal</th>
                    <th>Bidang Minat</th>
                    <th>Status</th>
                    <th>Berkas</th>
                    <th>Aksi</th>
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
                                <a href="{{ asset('storage/'.$proposal->file_path) }}" target="_blank" class="btn btn-sm btn-primary">
                                    Lihat File
                                </a>
                            @else
                                <span class="text-muted">Tidak ada file</span>
                            @endif
                        </td>

                        {{-- ✅ Kolom Aksi --}}
                        <td>
                            @if (strtolower($proposal->status) == 'revisi')
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal{{ $proposal->id }}">
                                    Upload Revisi
                                </button>
                            @else
                                <span class="text-muted">-</span>
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
                                    <form action="{{ route('proposal.update', $proposal->id) }}" method="POST" enctype="multipart/form-data">
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
    @endif
</div>
@endsection
