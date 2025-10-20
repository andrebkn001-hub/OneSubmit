@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Review Proposal</h3>

    <form method="POST" action="{{ route('kjfd.proposal.update', $proposal->id) }}">
        @csrf
        <div class="form-group mt-3">
            <label>Judul Proposal:</label>
            <input type="text" class="form-control" value="{{ $proposal->judul }}" readonly>
        </div>

        <div class="form-group mt-3">
            <label>Catatan / Rekomendasi:</label>
            <textarea class="form-control" name="catatan">{{ $proposal->catatan }}</textarea>
        </div>

        <div class="form-group mt-3">
            <label>Status:</label>
            <select class="form-control" name="status">
                <option value="Ditolak">Tolak Proposal</option>
                <option value="Disetujui">Setujui Proposal</option>
            </select>
        </div>

        <div class="mt-4">
            <button class="btn btn-success">Simpan</button>
            <a href="{{ route('kjfd.proposal.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
