@extends('layouts.admin')

@section('content')
    <h2>Dashboard Admin</h2>
    <p>Selamat datang di halaman dashboard admin!</p>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Ringkasan Proposal per Bidang Minat</h5>
                </div>
                <div class="card-body">
                    @if(!empty($counts) && $counts->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Bidang Minat</th>
                                        <th>Jumlah Proposal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($counts as $bidang => $total)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $bidang ?? 'Tidak ditentukan' }}</td>
                                            <td>{{ $total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted">Belum ada proposal yang diajukan.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
