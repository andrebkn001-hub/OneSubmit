@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Kelola Kuota KJFD</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table id="quotasTable" class="table table-striped">
            <thead>
                <tr>
                    <th>Bidang</th>
                    <th class="text-center">Kuota</th>
                    <th class="text-center">Sudah ACC</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotas as $q)
                <tr>
                    <td>{{ $q->bidang }}</td>
                    <td class="text-center">{{ $q->quota }}</td>
                    <td class="text-center">
                        @php
                            $accepted = \App\Models\Proposal::whereHas('dosenKjfd', function($query) use ($q) {
                                $query->where('bidang', $q->bidang);
                            })->where('status', 'disetujui')->count();
                        @endphp
                        {{ $accepted }}
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.quotas.edit', $q->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>

<script>
$(document).ready(function() {
    $('#quotasTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        pageLength: 10,
        order: [[0, 'asc']],
        searching: true,
        paging: false,
        info: false,
        columnDefs: [
            { orderable: false, targets: [3] }
        ]
    });
});
</script>
@endsection
