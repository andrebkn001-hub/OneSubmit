<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\AdminProposalController;
use App\Http\Controllers\AdminStudentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Semua route utama aplikasi OneSubmit.
| Diatur berdasarkan role agar mudah dipelihara.
|
*/

Route::get('/', function () {
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| Route Publik
|--------------------------------------------------------------------------
*/
Route::get('/judul-skripsi', [App\Http\Controllers\MahasiswaController::class, 'judulSkripsi'])->name('judul-skripsi');
Route::get('/dosen-staff', [App\Http\Controllers\MahasiswaController::class, 'dosenStaff'])->name('dosen-staff');

/*
|--------------------------------------------------------------------------
| Dashboard Utama Berdasarkan Role
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();

    // Mengarahkan pengguna ke dashboard yang sesuai dengan role mereka
    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'ketua_jurusan':
            return redirect()->route('jurusan.dashboard');
        case 'dosen_kjfd':
            return redirect()->route('kjfd.dashboard');
        case 'mahasiswa':
            return redirect()->route('mahasiswa.dashboard');
        default:
            abort(403, 'Role tidak dikenal');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Route Umum (Profil Pengguna)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Route Spesifik Berdasarkan Role
|--------------------------------------------------------------------------
*/

// ==========================
// ADMIN ROUTES
// ==========================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        $query = \App\Models\Proposal::query();
        
        // Filter berdasarkan status
        if (request('status')) {
            $query->where('status', request('status'));
        }
        
        // Filter berdasarkan bidang minat
        if (request('bidang')) {
            $query->where('bidang_minat', request('bidang'));
        }
        
        // Filter berdasarkan tanggal
        if (request('date_from')) {
            $query->whereDate('created_at', '>=', request('date_from'));
        }
        if (request('date_to')) {
            $query->whereDate('created_at', '<=', request('date_to'));
        }
        
        // Search box
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('nim', 'like', '%' . $search . '%')
                  ->orWhere('nama_lengkap', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        // Get all proposals dengan filter
        $allProposals = $query->latest()->get();
        
        // Hitung jumlah proposal per bidang minat
        $counts = \App\Models\Proposal::select('bidang_minat', \DB::raw('count(*) as total'))
            ->groupBy('bidang_minat')
            ->orderBy('bidang_minat')
            ->get()
            ->pluck('total', 'bidang_minat');

        // KPI Cards
        $kpi = [
            'total' => \App\Models\Proposal::count(),
            'approved' => \App\Models\Proposal::where('status', 'disetujui')->count(),
            'pending' => \App\Models\Proposal::where('status', 'menunggu_verifikasi')->count(),
            'rejected' => \App\Models\Proposal::where('status', 'ditolak')->count(),
        ];

        // Trend Proposal per Bulan (12 bulan terakhir)
        $trendRaw = \App\Models\Proposal::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        $trend = [
            'labels' => $trendRaw->pluck('bulan')->toArray(),
            'data' => $trendRaw->pluck('total')->toArray(),
        ];

        // Statistik status proposal
        $statusStats = [
            'menunggu_verifikasi' => \App\Models\Proposal::where('status', 'menunggu_verifikasi')->count(),
            'menunggu_verifikasi_dosen_kjfd' => \App\Models\Proposal::where('status', 'menunggu_verifikasi_dosen_kjfd')->count(),
            'disetujui' => \App\Models\Proposal::where('status', 'disetujui')->count(),
            'ditolak' => \App\Models\Proposal::where('status', 'ditolak')->count(),
            'revisi' => \App\Models\Proposal::where('status', 'revisi')->count(),
        ];

        // User Management Statistics
        $userStats = [
            'total' => \App\Models\User::count(),
            'mahasiswa' => \App\Models\User::where('role', 'mahasiswa')->count(),
            'dosen_kjfd' => \App\Models\User::where('role', 'dosen_kjfd')->count(),
            'admin' => \App\Models\User::where('role', 'admin')->count(),
            'active_7days' => \App\Models\User::where('updated_at', '>=', now()->subDays(7))->count(),
            'active_30days' => \App\Models\User::where('updated_at', '>=', now()->subDays(30))->count(),
        ];

        // User Growth per Bulan (6 bulan terakhir)
        $userGrowthRaw = \App\Models\User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as bulan, COUNT(*) as total')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        $userGrowth = [
            'labels' => $userGrowthRaw->pluck('bulan')->toArray(),
            'data' => $userGrowthRaw->pluck('total')->toArray(),
        ];

        return view('admin.dashboard', compact('counts', 'kpi', 'trend', 'statusStats', 'allProposals', 'userStats', 'userGrowth'));
    })->name('dashboard');

    // Proposal routes
    Route::get('/proposals', [AdminProposalController::class, 'index'])->name('proposals.index');
    Route::post('/proposals/{id}/approve', [AdminProposalController::class, 'approve'])->name('proposals.approve');
    Route::post('/proposals/{id}/reject', [AdminProposalController::class, 'reject'])->name('proposals.reject');
    Route::get('/proposals/view-file/{id}', [AdminProposalController::class, 'viewFile'])->name('proposals.view-file');

    // Student accounts routes
    Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
    Route::delete('/students/{id}', [AdminStudentController::class, 'destroy'])->name('students.destroy');

    // Kuota KJFD routes (Admin)
    Route::get('/quotas', [\App\Http\Controllers\AdminQuotaController::class, 'index'])->name('quotas.index');
    Route::get('/quotas/{id}/edit', [\App\Http\Controllers\AdminQuotaController::class, 'edit'])->name('quotas.edit');
    Route::post('/quotas/{id}', [\App\Http\Controllers\AdminQuotaController::class, 'update'])->name('quotas.update');
});

// ==========================
// MAHASISWA ROUTES
// ==========================
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', fn() => view('mahasiswa.dashboard'))->name('dashboard');

    // Form pengajuan proposal
    Route::get('/proposal/create', [ProposalController::class, 'create'])->name('proposal.create');

    // Submit proposal
    Route::post('/proposal/store', [ProposalController::class, 'store'])->name('proposal.store');

    // Lihat status proposal
    Route::get('/status', [ProposalController::class, 'status'])->name('status');

    // Update proposal untuk revisi
    Route::post('/proposal/{id}/revisi', [ProposalController::class, 'updateRevisi'])->name('proposal.revisi');

    // Download surat pemberitahuan dan surat ACC
    Route::get('/proposal/download-surat/{id}', [ProposalController::class, 'downloadSurat'])->name('proposal.download-surat');
    Route::get('/proposal/download-acc/{id}', [ProposalController::class, 'downloadAccLetter'])->name('proposal.download-acc');

    // View file proposal
    Route::get('/proposal/view-file/{id}', [ProposalController::class, 'viewFile'])->name('proposal.view-file');

    // Layanan
    Route::get('/layanan', [App\Http\Controllers\MahasiswaController::class, 'layanan'])->name('layanan');
    Route::get('/layanan/download/{file}', [App\Http\Controllers\MahasiswaController::class, 'downloadLayanan'])->name('layanan.download');
});

// ==========================
// KETUA JURUSAN ROUTES
// ==========================
Route::middleware(['auth', 'role:ketua_jurusan'])->prefix('jurusan')->name('jurusan.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.jurusan'))->name('dashboard');
    
    // Inbox - Aksi yang butuh perhatian Ketua Jurusan
    Route::get('/inbox', [App\Http\Controllers\Jurusan\InboxController::class, 'index'])->name('inbox.index');
    Route::get('/inbox/{id}', [App\Http\Controllers\Jurusan\InboxController::class, 'show'])->name('inbox.show');
    Route::post('/inbox/{id}/notify', [App\Http\Controllers\Jurusan\InboxController::class, 'notify'])->name('inbox.notify');
    
    Route::get('/proposals/kjfd', [App\Http\Controllers\JurusanController::class, 'kjfdSelection'])->name('proposals.kjfd');
    Route::get('/proposals/{bidang}', [App\Http\Controllers\JurusanController::class, 'proposalsIndex'])->name('proposals.index');
    // KOREKSI: Panggil Controller Jurusan
    Route::get('/proposals/view-file/{id}', [\App\Http\Controllers\JurusanController::class, 'viewFile'])->name('proposals.view-file');
});

// ==========================
// KETUA KJFD ROUTES
// ==========================
Route::middleware(['auth', 'role:dosen_kjfd'])->prefix('kjfd')->name('kjfd.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.kjfd'))->name('dashboard');
    Route::get('/proposals', [\App\Http\Controllers\DosenKjfdProposalController::class, 'index'])->name('proposals.index');
    Route::post('/proposals/{id}/approve', [\App\Http\Controllers\DosenKjfdProposalController::class, 'approve'])->name('proposals.approve');
    Route::post('/proposals/{id}/revise', [\App\Http\Controllers\DosenKjfdProposalController::class, 'revise'])->name('proposals.revise');
    Route::post('/proposals/{id}/reject', [\App\Http\Controllers\DosenKjfdProposalController::class, 'reject'])->name('proposals.reject');
    Route::get('/proposals/view-file/{id}', [\App\Http\Controllers\DosenKjfdProposalController::class, 'viewFile'])->name('proposals.view-file');
});


// Route untuk otentikasi
require __DIR__.'/auth.php';

// ==========================
// GLOBAL NOTIFICATIONS ROUTES
// ==========================
Route::middleware(['auth'])->post('/notifications/read-all', function () {
    $user = auth()->user();
    $user->unreadNotifications->markAsRead();
    return back();
})->name('notifications.read-all');
