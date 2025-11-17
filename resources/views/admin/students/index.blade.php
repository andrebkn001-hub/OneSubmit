@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Daftar Akun Mahasiswa</h2>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="studentsTable" class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>NIM</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($students as $index => $student)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->nim }}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>
                                            <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun mahasiswa ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada akun mahasiswa yang terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#studentsTable').DataTable({
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
                className: 'btn btn-success btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'pdf',
                text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                className: 'btn btn-danger btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            },
            {
                extend: 'print',
                text: '<i class="bi bi-printer"></i> Print',
                className: 'btn btn-info btn-sm',
                exportOptions: {
                    columns: [0, 1, 2, 3]
                }
            }
        ],
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [4] }
        ]
    });
});
</script>
@endsection