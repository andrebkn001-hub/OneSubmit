

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="mb-2 mb-md-0">
                    <h1 class="h3 mb-1">
                        <i class="bi bi-graph-up text-primary me-2"></i>Dashboard Analytics Ketua Jurusan
                    </h1>
                    <p class="text-muted small mb-0">Visualisasi data proposal real-time</p>
                </div>
                
                <!-- Filter Periode -->
                <div class="btn-group" role="group">
                    <a href="<?php echo e(route('jurusan.dashboard', ['period' => 7])); ?>" 
                       class="btn btn-sm <?php echo e($period == 7 ? 'btn-primary' : 'btn-outline-primary'); ?>">
                        7 Hari
                    </a>
                    <a href="<?php echo e(route('jurusan.dashboard', ['period' => 30])); ?>" 
                       class="btn btn-sm <?php echo e($period == 30 ? 'btn-primary' : 'btn-outline-primary'); ?>">
                        30 Hari
                    </a>
                    <a href="<?php echo e(route('jurusan.dashboard', ['period' => 90])); ?>" 
                       class="btn btn-sm <?php echo e($period == 90 ? 'btn-primary' : 'btn-outline-primary'); ?>">
                        90 Hari
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-primary border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small text-uppercase mb-1">Total Proposal</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e($analytics['summary']['total_proposal']); ?></div>
                        </div>
                        <div>
                            <i class="bi bi-file-earmark-text fs-2 text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-warning border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small text-uppercase mb-1">Menunggu Verifikasi</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e($analytics['summary']['menunggu_verifikasi']); ?></div>
                        </div>
                        <div>
                            <i class="bi bi-clock-history fs-2 text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-success border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small text-uppercase mb-1">Disetujui</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e($analytics['summary']['disetujui']); ?></div>
                        </div>
                        <div>
                            <i class="bi bi-check-circle fs-2 text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-start border-info border-4 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-muted small text-uppercase mb-1">Rata-rata Proses</div>
                            <div class="h4 mb-0 fw-bold"><?php echo e(round($analytics['summary']['avg_process_time'], 1)); ?> jam</div>
                        </div>
                        <div>
                            <i class="bi bi-stopwatch fs-2 text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row 1 -->
    <div class="row g-3 mb-4">
        <!-- Tren Pengajuan -->
        <div class="col-xl-8">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-graph-up-arrow"></i> Tren Pengajuan (<?php echo e($period); ?> Hari Terakhir)
                    </h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="trenChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- SLA Compliance -->
        <div class="col-xl-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-speedometer2"></i> SLA Compliance Rate
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div style="position: relative; height: 200px;">
                        <canvas id="slaChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <p class="mb-1"><strong class="text-primary"><?php echo e($analytics['sla_compliance']['on_time']); ?></strong> proposal tepat waktu</p>
                        <p class="mb-0 text-muted small">dari <?php echo e($analytics['sla_compliance']['total']); ?> total proposal</p>
                    </div>
                </div>
    <!-- Charts Row 2 -->
    <div class="row g-3 mb-4">
        <!-- Distribusi Bidang Minat -->
        <div class="col-xl-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-pie-chart"></i> Distribusi per Bidang Minat
                    </h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="bidangChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Durasi Verifikasi -->
        <div class="col-xl-6">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-bar-chart"></i> Rata-rata Durasi per Status (jam)
                    </h6>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px;">
                        <canvas id="durasiChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>          <canvas id="durasiChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-lightning"></i> Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="<?php echo e(route('jurusan.inbox.index')); ?>" class="btn btn-primary">
                            <i class="bi bi-inbox me-1"></i> Inbox Aksi Saya
                        </a>
                        <a href="<?php echo e(route('jurusan.proposals.kjfd')); ?>" class="btn btn-outline-secondary">
                            <i class="bi bi-list-task me-1"></i> Daftar Proposal
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="bi bi-printer me-1"></i> Print Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Data dari backend
const analytics = <?php echo json_encode($analytics, 15, 512) ?>;

// 1. Tren Pengajuan (Line Chart)
new Chart(document.getElementById('trenChart'), {
    type: 'line',
    data: {
        labels: analytics.tren_pengajuan.labels,
        datasets: [{
            label: 'Jumlah Pengajuan',
            data: analytics.tren_pengajuan.data,
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointRadius: 4,
            pointHoverRadius: 6,
            pointBackgroundColor: '#0d6efd',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                display: true, 
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 15
                }
            },
            tooltip: {
                mode: 'index',
                intersect: false,
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                titleFont: { size: 13 },
                bodyFont: { size: 12 }
            }
        },
        scales: {
            y: { 
                beginAtZero: true, 
                ticks: { 
                    stepSize: 1,
                    font: { size: 11 }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                ticks: {
                    font: { size: 11 }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});

// 2. SLA Compliance (Doughnut Chart)
new Chart(document.getElementById('slaChart'), {
    type: 'doughnut',
    data: {
        labels: ['Tepat Waktu', 'Terlambat'],
        datasets: [{
            data: [analytics.sla_compliance.on_time, analytics.sla_compliance.late],
            backgroundColor: ['#198754', '#dc3545'],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
            legend: { 
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    font: { size: 12 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                callbacks: {
                    label: function(context) {
                        const total = analytics.sla_compliance.total;
                        const value = context.parsed;
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return context.label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// 3. Distribusi Bidang Minat (Pie Chart)
new Chart(document.getElementById('bidangChart'), {
    type: 'pie',
    data: {
        labels: analytics.distribusi_bidang.labels,
        datasets: [{
            data: analytics.distribusi_bidang.data,
            backgroundColor: [
                '#0d6efd',
                '#6610f2',
                '#d63384',
                '#fd7e14'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                position: 'right',
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    font: { size: 12 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                callbacks: {
                    label: function(context) {
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const value = context.parsed;
                        const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return context.label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        }
    }
});

// 4. Durasi Verifikasi (Bar Chart)
new Chart(document.getElementById('durasiChart'), {
    type: 'bar',
    data: {
        labels: analytics.durasi_verifikasi.labels,
        datasets: [{
            label: 'Rata-rata Durasi (jam)',
            data: analytics.durasi_verifikasi.data,
            backgroundColor: '#6610f2',
            borderRadius: 6,
            borderSkipped: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                display: true,
                labels: {
                    usePointStyle: true,
                    padding: 15,
                    font: { size: 12 }
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ': ' + context.parsed.y.toFixed(1) + ' jam';
                    }
                }
            }
        },
        scales: {
            y: { 
                beginAtZero: true,
                ticks: {
                    font: { size: 11 }
                },
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)'
                }
            },
            x: {
                ticks: {
                    font: { size: 11 }
                },
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>

<style>
.card {
    border-radius: 8px;
    transition: transform .2s, box-shadow .2s;
}
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.card-header {
    border-radius: 8px 8px 0 0 !important;
}
.btn-group .btn {
    min-width: 70px;
}
@media (max-width: 768px) {
    .h3 {
        font-size: 1.5rem;
    }
    .btn-group {
        width: 100%;
        margin-top: 10px;
    }
    .btn-group .btn {
        flex: 1;
    }
}
@media print {
    .sidebar, .navbar, .btn, .card-header { 
        display: none !important; 
    }
    .card {
        box-shadow: none !important;
        page-break-inside: avoid;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\OneSubmit\resources\views/jurusan/dashboard/index.blade.php ENDPATH**/ ?>