@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Pengarahan Proposal</h3>

    <form method="POST" action="{{ route('admin.proposal.update', $proposal->id) }}">
        @csrf
        <div class="form-group mt-3">
            <label>Judul Proposal:</label>
            <input type="text" class="form-control" value="{{ $proposal->judul }}" readonly>
        </div>

        <div class="form-group mt-3">
            <label>Arahkan ke Dosen KJFD:</label>
            <select class="form-control" name="dosen_kjfd" required>
                <option value="">Pilih Dosen</option>
                <option value="Dosen A" {{ $proposal->dosen_kjfd=='Dosen A'?'selected':'' }}>Dosen A</option>
                <option value="Dosen B" {{ $proposal->dosen_kjfd=='Dosen B'?'selected':'' }}>Dosen B</option>
                <option value="Dosen C" {{ $proposal->dosen_kjfd=='Dosen C'?'selected':'' }}>Dosen C</option>
            </select>
        </div>

        <div class="mt-4">
            <button class="btn btn-success">Arahkan</button>
            <a href="{{ route('admin.proposal.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>
@endsection
