@extends('layouts.app')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@section('content')
<div class="text-center">
    <h1 class="mb-4">Dashboard mahasiswa</h1>
    <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
</div>
@endsection
