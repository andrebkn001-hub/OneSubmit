@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>📘 Detail Proposal</h3>

    <div class="card mt-3">
        <div class="card-body">
            <h5><strong>Judul:</strong> {{ $proposal->judul }}</h5>
            <p><strong>Mahasiswa:</strong> {{ $proposal->mahasiswa->nama ?? '-' }}</p>
            <p><strong>Deskripsi:</strong> {{ $proposal->deskripsi ?? '-' }}</p>
            <p><strong>Status:</strong> 
                @if($proposal->status == 'diterima')
                    <span class="badge bg-success">Diterima</span>
                @elseif($proposal->status == 'ditolak')
                    <span class="badge bg-danger">Ditolak</span>
                @else
                    <span class="badge bg-secondary">Belum Dinilai</span>
                @endif
            </p>
        </div>
    </div>

    <form action="{{ route('proposal.review', $proposal->id) }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="catatan" class="form-label">Catatan Penilaian</label>
            <textarea name="catatan" id="catatan" rows="4" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status Penilaian</label>
            <select name="status" id="status" class="form-select" required>
                <option value="">-- Pilih Status --</option>
                <option value="diterima">Diterima</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan Review</button>
        <a href="{{ route('proposal.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
