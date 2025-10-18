@extends('layouts.app')

@section('content')
<div class="text-center">
    <h1 class="mb-4">Dashboard ketua_kjfd</h1>
    <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong></p>
</div>
@endsection
