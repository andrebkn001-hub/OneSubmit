@extends('layouts.mahasiswa')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Pengajuan Judul Tugas Akhir</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('pengajuan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">NRP</label>
                <input type="text" class="form-control" placeholder="Masukkan NRP Anda">
            </div>

            <div class="mb-3">
                <label class="form-label">Judul Proposal</label>
                <input type="text" name="judul" class="form-control" placeholder="Masukkan Judul Tugas Akhir" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Bidang Minat</label>
                <select class="form-select">
                    <option>Pilih</option>
                    <option>Artificial Intelligence</option>
                    <option>Web Development</option>
                    <option>Data Science</option>
                    <option>Jaringan Komputer</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Pilih Dosen Pembimbing</label>
                <select class="form-select">
                    <option>Pilih Dosen</option>
                    <option>Dosen A</option>
                    <option>Dosen B</option>
                    <option>Dosen C</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Unggah Berkas Proposal</label>
                <input type="file" name="file" class="form-control" required>
                <small class="text-muted">Format yang diperbolehkan: PDF, DOCX, DOC (Maks. 2MB)</small>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Ajukan</button>
            </div>
        </form>
    </div>
</div>
@endsection
