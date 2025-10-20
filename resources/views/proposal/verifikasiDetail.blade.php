@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>🧾 Detail Proposal</h3>

    <div class="card mt-3">
        <div class="card-body">
            <h5><strong>Judul:</strong> {{ $proposal->judul }}</h5>
            <p><strong>Mahasiswa:</strong> {{ $proposal->mahasiswa->nama ?? '-' }}</p>
            <p><strong>Deskripsi:</strong> {{ $proposal->deskripsi ?? '-' }}</p>
        </div>
    </div>

    <form action="{{ route('proposal.assign', $proposal->id) }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="dosen_id" class="form-label">Pilih Dosen KJFD</label>
            <select name="dosen_id" id="dosen_id" class="form-select" required>
                <option value="">-- Pilih Dosen --</option>
                @foreach ($dosens as $dosen)
                    <option value="{{ $dosen->id }}">{{ $dosen->nama }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Tugaskan Dosen</button>
        <a href="{{ route('proposal.verifikasi') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
