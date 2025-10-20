@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3 class="mb-3">Pengajuan Proposal</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('mahasiswa.proposal.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">NIM</label>
            <input type="text" name="nim" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Judul Proposal</label>
            <input type="text" name="judul" class="form-control" required>
        </div>

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

        <div class="mb-3">
            <label class="form-label">Unggah Berkas Proposal</label>
            <input type="file" name="file_proposal" accept=".pdf,.doc,.docx" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Proposal</button>
    </form>
</div>
@endsection
