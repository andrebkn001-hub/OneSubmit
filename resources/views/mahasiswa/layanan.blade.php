@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="text-center">
                <h1 class="display-4 fw-bold text-primary mb-3" style="color: #1e90ff !important;">
                    <i class="bi bi-file-earmark-text-fill me-3"></i>Layanan
                </h1>
                <p class="lead text-muted">Unduh dokumen pedoman dan template terkait skripsi Program Studi Sistem Informasi</p>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <div class="card-header border-0" style="background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%); border-radius: 20px 20px 0 0 !important; color: white;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-folder-fill fs-4 me-3"></i>
                        <div>
                            <h4 class="mb-0 fw-bold">Dokumen Skripsi</h4>
                            <small class="opacity-75">Koleksi dokumen pedoman dan template skripsi</small>
                        </div>
                    </div>
                </div>

                <div class="card-body p-5">
                    <div class="table-responsive">
                        <table id="layananTable" class="table table-hover border-0" style="border-radius: 10px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                <tr>
                                    <th class="text-center fw-bold" style="width: 80px; color: #1976d2; border: none;">No</th>
                                    <th class="fw-bold" style="color: #1976d2; border: none;">Nama Dokumen</th>
                                    <th class="text-center fw-bold" style="width: 180px; color: #1976d2; border: none;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($files as $index => $file)
                                <tr style="transition: all 0.3s ease;" onmouseover="this.style.backgroundColor='#f8f9fa'" onmouseout="this.style.backgroundColor='transparent'">
                                    <td class="text-center fw-semibold" style="color: #495057;">{{ $index + 1 }}</td>
                                    <td class="fw-medium" style="color: #495057;">
                                        <i class="bi bi-file-earmark-pdf-fill me-2" style="color: #dc3545;"></i>
                                        {{ $file['name'] }}
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('mahasiswa.layanan.download', $file['filename']) }}"
                                           class="btn fw-bold px-4 py-2"
                                           style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 10px; color: white; transition: all 0.3s ease; text-decoration: none;"
                                           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(40, 167, 69, 0.3)';"
                                           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';"
                                           target="_blank">
                                            <i class="bi bi-download me-2"></i>Download
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Information Alert -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="alert border-0 text-center" style="background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%); border-radius: 15px; color: #155724;">
                <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                <div>
                    <strong class="d-block mb-1">Informasi:</strong>
                    <span>File PDF asli telah tersedia untuk diunduh.</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table th {
    font-weight: 600;
    font-size: 0.95rem;
}

.table td {
    vertical-align: middle;
    font-size: 0.9rem;
}

.card {
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .display-4 {
        font-size: 2rem;
    }

    .card-body {
        padding: 2rem !important;
    }

    .table-responsive {
        font-size: 0.85rem;
    }
}
</style>

<script>
$(document).ready(function() {
    $('#layananTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        responsive: true,
        pageLength: 10,
        searching: true,
        paging: false,
        info: false,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [2] }
        ]
    });
});
</script>
@endsection
