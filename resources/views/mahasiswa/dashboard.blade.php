@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-3">Pengajuan Judul Proposal</h3>

        {{-- ✅ Pesan sukses saat proposal berhasil diajukan --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- ✅ Pesan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <strong>Rincian Informasi</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('proposal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- ✅ Nama diambil dari Auth::user() --}}
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" value="{{ Auth::user()->name }}" readonly>
                    </div>

                    {{-- ✅ NIM wajib diisi --}}
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM Anda" required>
                    </div>

                    {{-- ✅ Judul proposal wajib diisi --}}
                    <div class="mb-3">
                        <label class="form-label">Judul Proposal</label>
                        <input type="text" class="form-control" name="judul_proposal" placeholder="Masukkan judul tugas akhir">
                    </div>

                    {{-- ✅ Ganti name="bidang_minat" agar sesuai dengan controller --}}
                    <div class="mb-3">
                        <label class="form-label">Bidang Minat</label>
                        <select name="bidang_minat" class="form-select" required>
                            <option value="">-- Pilih Bidang --</option>
                            <option value="Information Management">Information Management</option>
                            <option value="Business Intelligence">Business Intelligence</option>
                            <option value="Data Engineering">Data Engineering</option>
                            <option value="Information Retrieval">Information Retrieval</option>
                        </select>
                    </div>

                    {{-- ✅ File wajib diunggah, format sesuai validasi controller --}}
                    <div class="mb-3">
                        <label class="form-label">Unggah Berkas Proposal</label>
                        <input type="file" class="form-control" name="file_proposal" accept=".pdf,.doc,.docx" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Ajukan</button>
                </form>
            </div>
        </div>
    </div>
@endsection
