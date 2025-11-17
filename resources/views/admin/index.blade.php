@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Proposal Mahasiswa</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table id="adminProposalsTable" class="table table-bordered mt-3">
        <thead class="table-dark">
            <tr>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Judul</th>
                <th>Bidang Minat</th>
                <th>Status</th>
                <th>Berkas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($proposals as $proposal)
                <tr>
                    <td>{{ $proposal->nama_lengkap }}</td>
                    <td>{{ $proposal->nim }}</td>
                    
                    {{-- 💡 KOREKSI: Memisahkan <td> untuk Judul dan Bidang Minat --}}
                    <td>{{ $proposal->judul }}</td>
                    <td>{{ $proposal->bidang_minat }}</td>
                    
                    <td>{{ $proposal->status }}</td>
                    
                    {{-- 🚀 SOLUSI 404: Menggunakan route Controller --}}
                    <td>
                        @if (isset($proposal->file_path))
                            <a href="{{ route('admin.proposals.view-file', $proposal->id) }}" target="_blank" class="btn btn-sm btn-info">
                                Lihat File
                            </a>
                        @else
                            <span class="text-muted">Tidak ada file</span>
                        @endif
                    </td>
                    
                    <td>
                        {{-- Asumsi status awal yang butuh validasi dari Admin adalah 'menunggu validasi' --}}
                        @if (strtolower($proposal->status) == 'menunggu validasi') 
                            <form action="{{ route('admin.proposals.approve', $proposal->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Terima</button>
                            </form>
                            <form action="{{ route('admin.proposals.reject', $proposal->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @else
                            <span class="text-muted">Selesai</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#adminProposalsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12 col-md-6"B>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        buttons: [
            {
                extend: 'excel',
                text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                className: 'btn btn-success btn-sm'
            },
            {
                extend: 'pdf',
                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm'
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'btn btn-info btn-sm'
            }
        ],
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [5, 6] }
        ]
    });
});
</script>
@endsection