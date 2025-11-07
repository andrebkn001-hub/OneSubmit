@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Edit Kuota: {{ $quota->bidang }}</h3>

    <form method="POST" action="{{ route('admin.quotas.update', $quota->id) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Kuota</label>
            <input type="number" name="quota" class="form-control" value="{{ old('quota', $quota->quota) }}" min="0" required>
            @error('quota')<div class="text-danger mt-1">{{ $message }}</div>@enderror
        </div>

        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.quotas.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
