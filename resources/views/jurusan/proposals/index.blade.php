@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4 px-4">
    <!-- Header Section with Gradient Background -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
                <div class="card-body p-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="row align-items-center">
                        <div class="col-lg-8">
                            <div class="d-flex align-items-center text-white">
                                <div class="icon-box me-3" style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                                    @php
                                        $iconMap = [
                                            'Business Intelligence' => 'chart-line',
                                            'Data Engineering' => 'database',
                                            'Information Management' => 'folder-tree',
                                            'Information Retrieval' => 'magnifying-glass-chart',
                                        ];
                                        $icon = $iconMap[$bidang] ?? 'layer-group';
                                    @endphp
                                    <i class="fas fa-{{ $icon }} fa-2x"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1 fw-bold">Daftar Proposal Mahasiswa</h2>
                                    <p class="mb-0 opacity-75">
                                        <i class="fas fa-tag me-2"></i>Bidang: <strong>{{ $bidang }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                            <a href="{{ route('jurusan.proposals.kjfd') }}" class="btn btn-light btn-lg px-4 py-2" style="border-radius: 12px; font-weight: 600;">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 15px; border-left: 5px solid #28a745;">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 15px; border-left: 5px solid #dc3545;">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    @php
        $totalProposals = $proposals->count();
        $disetujui = $proposals->where('status', 'disetujui')->count();
        $ditolak = $proposals->where('status', 'ditolak')->count();
        $pending = $proposals->whereIn('status', ['menunggu_verifikasi', 'menunggu_verifikasi_dosen_kjfd', 'revisi'])->count();
    @endphp

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 4px solid #6c757d;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold text-uppercase">Total Proposal</p>
                            <h3 class="mb-0 fw-bold">{{ $totalProposals }}</h3>
                        </div>
                        <div class="icon-wrapper" style="width: 50px; height: 50px; background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-file-alt fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 4px solid #28a745;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold text-uppercase">Disetujui</p>
                            <h3 class="mb-0 fw-bold text-success">{{ $disetujui }}</h3>
                        </div>
                        <div class="icon-wrapper" style="width: 50px; height: 50px; background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-check-circle fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 4px solid #ffc107;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold text-uppercase">Pending</p>
                            <h3 class="mb-0 fw-bold text-warning">{{ $pending }}</h3>
                        </div>
                        <div class="icon-wrapper" style="width: 50px; height: 50px; background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-clock fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 15px; border-left: 4px solid #dc3545;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 small fw-semibold text-uppercase">Ditolak</p>
                            <h3 class="mb-0 fw-bold text-danger">{{ $ditolak }}</h3>
                        </div>
                        <div class="icon-wrapper" style="width: 50px; height: 50px; background: linear-gradient(135deg, #dc3545 0%, #bd2130 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-times-circle fa-lg text-white"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
        <div class="card-header bg-white border-0 p-4" style="border-radius: 20px 20px 0 0;">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <h4 class="mb-1 fw-bold">
                        <i class="fas fa-table me-2 text-primary"></i>Data Proposal
                    </h4>
                    <p class="text-muted mb-0 small">Semua proposal yang diajukan pada bidang {{ $bidang }}</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary" onclick="exportTable('excel')" style="border-radius: 10px;">
                        <i class="fas fa-file-excel me-2"></i>Export Excel
                    </button>
                    <button class="btn btn-outline-danger" onclick="exportTable('pdf')" style="border-radius: 10px;">
                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="jurusanProposalsTable" class="table table-hover align-middle" style="width: 100%;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                            <th class="fw-bold" style="border-radius: 10px 0 0 10px; padding: 15px;">
                                <i class="fas fa-hashtag me-2 text-primary"></i>No
                            </th>
                            <th class="fw-bold" style="padding: 15px;">
                                <i class="fas fa-user me-2 text-primary"></i>Nama Mahasiswa
                            </th>
                            <th class="fw-bold" style="padding: 15px;">
                                <i class="fas fa-id-card me-2 text-primary"></i>NIM
                            </th>
                            <th class="fw-bold" style="padding: 15px; min-width: 250px;">
                                <i class="fas fa-book me-2 text-primary"></i>Judul Proposal
                            </th>
                            <th class="fw-bold" style="padding: 15px;">
                                <i class="fas fa-calendar me-2 text-primary"></i>Tanggal Upload
                            </th>
                            <th class="fw-bold" style="padding: 15px;">
                                <i class="fas fa-info-circle me-2 text-primary"></i>Status
                            </th>
                            <th class="fw-bold text-center" style="border-radius: 0 10px 10px 0; padding: 15px;">
                                <i class="fas fa-cog me-2 text-primary"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($proposals as $index => $proposal)
                            <tr style="transition: all 0.3s ease;">
                                <td class="fw-semibold">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2" style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                            {{ strtoupper(substr($proposal->nama_lengkap, 0, 1)) }}
                                        </div>
                                        <span class="fw-semibold">{{ $proposal->nama_lengkap }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2" style="font-size: 0.9rem; font-weight: 600;">
                                        {{ $proposal->nim }}
                                    </span>
                                </td>
                                <td>
                                    <div class="proposal-title" style="max-width: 350px;">
                                        <span class="text-dark" title="{{ $proposal->judul }}">
                                            {{ Str::limit($proposal->judul, 80) }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-semibold text-dark">{{ $proposal->created_at->format('d M Y') }}</span>
                                        <small class="text-muted">{{ $proposal->created_at->format('H:i') }} WIB</small>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'disetujui' => ['class' => 'success', 'icon' => 'check-circle', 'text' => 'Disetujui'],
                                            'ditolak' => ['class' => 'danger', 'icon' => 'times-circle', 'text' => 'Ditolak'],
                                            'menunggu_verifikasi' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'Menunggu Verifikasi'],
                                            'menunggu_verifikasi_dosen_kjfd' => ['class' => 'info', 'icon' => 'hourglass-half', 'text' => 'Verifikasi Dosen KJFD'],
                                            'revisi' => ['class' => 'warning', 'icon' => 'edit', 'text' => 'Revisi'],
                                        ];
                                        $status = $statusConfig[$proposal->status] ?? ['class' => 'secondary', 'icon' => 'question-circle', 'text' => ucfirst($proposal->status)];
                                    @endphp
                                    <span class="badge px-3 py-2 fw-semibold" 
                                          style="border-radius: 8px; font-size: 0.85rem; 
                                          @if($status['class'] == 'success')
                                              background-color: #d1e7dd; color: #0a3622; border: 1px solid #a3cfbb;
                                          @elseif($status['class'] == 'danger')
                                              background-color: #f8d7da; color: #58151c; border: 1px solid #f1aeb5;
                                          @elseif($status['class'] == 'warning')
                                              background-color: #fff3cd; color: #664d03; border: 1px solid #ffe69c;
                                          @elseif($status['class'] == 'info')
                                              background-color: #cff4fc; color: #055160; border: 1px solid #9eeaf9;
                                          @else
                                              background-color: #e2e3e5; color: #2c3034; border: 1px solid #c4c8cb;
                                          @endif">
                                        <i class="fas fa-{{ $status['icon'] }} me-1"></i>{{ $status['text'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ($proposal->file_path)
                                        <a href="{{ route('jurusan.proposals.view-file', $proposal->id) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-primary px-3 py-2"
                                           style="border-radius: 8px; font-weight: 600;"
                                           data-bs-toggle="tooltip" 
                                           title="Lihat file proposal">
                                            <i class="fas fa-file-pdf me-1"></i>Lihat File
                                        </a>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary px-3 py-2">
                                            <i class="fas fa-times me-1"></i>Tidak ada file
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">Belum Ada Proposal</h5>
                                        <p class="text-muted mb-0">Belum ada proposal yang diajukan untuk bidang {{ $bidang }}.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<style>
/* Custom DataTables Styling */
.dataTables_wrapper .dataTables_length select,
.dataTables_wrapper .dataTables_filter input {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    padding: 6px 12px;
}

.dataTables_wrapper .dataTables_filter input {
    margin-left: 8px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    border-radius: 8px !important;
    margin: 0 2px;
}

.dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    border: none !important;
    color: white !important;
}

.dataTables_wrapper .dataTables_info {
    font-weight: 500;
    color: #6c757d;
}

/* Table Row Hover Effect */
#jurusanProposalsTable tbody tr:hover {
    background-color: #f8f9fa !important;
    transform: scale(1.01);
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* Empty State */
.empty-state {
    padding: 40px;
}

/* Avatar Animation */
.avatar-circle {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
    }
    50% {
        box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
    }
}

/* Button Hover Effect */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* Card Animation */
.card {
    animation: fadeIn 0.5s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Table */
@media (max-width: 768px) {
    .card-header .d-flex {
        flex-direction: column;
        gap: 10px;
    }
}

/* Custom Scrollbar */
.table-responsive::-webkit-scrollbar {
    height: 8px;
}

.table-responsive::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>

@endsection

@section('footer-scripts')
<!-- Export Libraries - Load AFTER layout's jQuery and DataTables -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
// Define global variables
var proposalTable = null;
var tableInitialized = false;

// Export function - accessible from onclick
function exportTable(type) {
    console.log('exportTable called with type:', type);
    console.log('tableInitialized:', tableInitialized);
    console.log('proposalTable:', proposalTable);
    
    if (!tableInitialized || !proposalTable) {
        alert('Tabel belum siap. Silakan tunggu beberapa detik dan coba lagi.');
        return;
    }
    
    try {
        if (type === 'excel') {
            proposalTable.button(0).trigger();
        } else if (type === 'pdf') {
            proposalTable.button(1).trigger();
        }
    } catch (error) {
        console.error('Export error:', error);
        alert('Terjadi kesalahan saat export: ' + error.message);
    }
}

// Initialize DataTable when document ready
$(document).ready(function() {
    // Wait a bit for all scripts to load
    setTimeout(function() {
        console.log('Starting DataTable initialization...');
        console.log('jQuery:', typeof jQuery);
        console.log('DataTable:', typeof $.fn.DataTable);
        console.log('Buttons:', typeof $.fn.DataTable.Buttons);
        console.log('JSZip:', typeof JSZip);
        console.log('pdfMake:', typeof pdfMake);
        
        try {
            proposalTable = $('#jurusanProposalsTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json',
                searchPlaceholder: "Cari proposal...",
                search: "_INPUT_",
                lengthMenu: "Tampilkan _MENU_ data per halaman"
            },
            responsive: true,
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Semua"]],
            order: [[4, 'desc']], // Sort by date descending
            columnDefs: [
                { orderable: false, targets: [6] }, // Disable sorting on action column
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: -1 }
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    titleAttr: 'Export ke Excel',
                    className: 'btn btn-success btn-sm d-none',
                    title: 'Daftar Proposal - {{ $bidang }}',
                    filename: 'Proposal_{{ str_replace(" ", "_", $bidang) }}_' + new Date().toISOString().slice(0,10),
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function (data, row, column, node) {
                                return data.replace(/<.*?>/g, '').trim();
                            }
                        }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    titleAttr: 'Export ke PDF',
                    className: 'btn btn-danger btn-sm d-none',
                    title: 'Daftar Proposal - {{ $bidang }}',
                    filename: 'Proposal_{{ str_replace(" ", "_", $bidang) }}_' + new Date().toISOString().slice(0,10),
                    orientation: 'landscape',
                    pageSize: 'A4',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5],
                        format: {
                            body: function (data, row, column, node) {
                                return data.replace(/<.*?>/g, '').trim();
                            }
                        }
                    },
                    customize: function(doc) {
                        doc.defaultStyle.fontSize = 8;
                        doc.styles.tableHeader.fontSize = 9;
                        doc.styles.tableHeader.fillColor = '#667eea';
                        doc.styles.tableHeader.color = 'white';
                        doc.styles.tableHeader.alignment = 'center';
                        doc.styles.tableHeader.bold = true;
                        
                        doc.content[1].table.widths = ['5%', '20%', '12%', '30%', '15%', '18%'];
                        
                        doc.content.splice(0, 1, {
                            text: [
                                { text: 'DAFTAR PROPOSAL MAHASISWA\n', fontSize: 14, bold: true },
                                { text: 'Bidang: {{ $bidang }}\n', fontSize: 11, bold: true },
                                { text: 'Tanggal Export: ' + new Date().toLocaleDateString('id-ID', {
                                    day: 'numeric',
                                    month: 'long', 
                                    year: 'numeric'
                                }) + '\n\n', fontSize: 9 }
                            ],
                            alignment: 'center',
                            margin: [0, 0, 0, 10]
                        });
                        
                        doc['footer'] = function(currentPage, pageCount) {
                            return {
                                text: 'Halaman ' + currentPage + ' dari ' + pageCount,
                                alignment: 'center',
                                fontSize: 8,
                                margin: [0, 10, 0, 0]
                            };
                        };
                    }
                }
            ],
            drawCallback: function() {
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            initComplete: function() {
                tableInitialized = true;
                console.log('✅ DataTable initialized successfully!');
                console.log('✅ Export buttons available:', proposalTable.buttons().count());
                console.log('✅ tableInitialized is now:', tableInitialized);
            }
        });

        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
        
        console.log('DataTable object created:', proposalTable);
        
    } catch (error) {
        console.error('❌ Error initializing DataTable:', error);
        alert('Gagal menginisialisasi tabel: ' + error.message);
    }
    }, 1000); // Wait 1 second for all libraries to load
});
</script>
@endsection