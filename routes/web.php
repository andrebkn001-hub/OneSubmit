<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\AdminProposalController; // Dipindahkan ke atas

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
    return view('welcome');
});

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
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::get('/proposals', [AdminProposalController::class, 'index'])->name('proposals.index');
    Route::post('/proposals/{id}/approve', [AdminProposalController::class, 'approve'])->name('proposals.approve');
    Route::post('/proposals/{id}/reject', [AdminProposalController::class, 'reject'])->name('proposals.reject');
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
    Route::post('/proposal/update/{id}', [ProposalController::class, 'update'])->name('proposal.update');
});
// ==========================
// KETUA JURUSAN ROUTES
// ==========================
Route::middleware(['auth', 'role:ketua_jurusan'])->prefix('jurusan')->name('jurusan.')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.jurusan'))->name('dashboard');
    Route::get('/proposals/kjfd', [App\Http\Controllers\JurusanController::class, 'kjfdSelection'])->name('proposals.kjfd');
    Route::get('/proposals/{bidang}', [App\Http\Controllers\JurusanController::class, 'proposalsIndex'])->name('proposals.index');
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
});


// Route untuk otentikasi
require __DIR__.'/auth.php';
