@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Daftar Proposal Mahasiswa</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Mahasiswa</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proposals as $p)
            <tr>
                <td>{{ $p->judul }}</td>
                <td>{{ $p->mahasiswa_nama }}</td>
                <td>{{ $p->status }}</td>
                <td>
                    <a href="{{ route('kjfd.proposal.edit', $p->id) }}" class="btn btn-primary btn-sm">Review</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
