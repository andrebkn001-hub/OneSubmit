@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="mb-4">Dashboard Dosen KJFD</h1>
    <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
    <div class="mt-4">
        <a href="{{ route('kjfd.proposals.index') }}" class="btn btn-primary">Lihat Proposal untuk Verifikasi</a>
    </div>
</div>
@endsection
