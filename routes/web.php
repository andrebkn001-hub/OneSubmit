<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Semua route aplikasi, termasuk dashboard, profile, dan fitur proposal.
*/

// ===============================
// 🏠 ROUTE UTAMA
// ===============================
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ===============================
// 🧭 DASHBOARD UTAMA BERDASARKAN ROLE
// ===============================
Route::middleware(['auth', 'verified'])->get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login');
    }

    switch ($user->role) {
        case 'admin':
            return view('dashboard.admin');
        case 'ketua_jurusan':
            return view('dashboard.ketua_jurusan');
        case 'ketua_kjfd':
            return view('dashboard.ketua_kjfd');
        case 'mahasiswa':
            return view('dashboard.mahasiswa');
        default:
            abort(403, 'Role tidak dikenal.');
    }
})->name('dashboard');

// ===============================
// ⚙️ PROFILE (DEFAULT BREEZE / JETSTREAM)
// ===============================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===============================
// 🎓 FITUR PROPOSAL
// ===============================
Route::middleware(['auth'])->prefix('proposal')->group(function () {

    // Untuk Mahasiswa & Dosen KJFD
    Route::get('/', [ProposalController::class, 'index'])->name('proposal.index'); // daftar proposal
    Route::get('/{id}', [ProposalController::class, 'show'])->name('proposal.show'); // detail proposal
    Route::post('/{id}/review', [ProposalController::class, 'review'])->name('proposal.review'); // review proposal

    // Untuk Admin / Ketua KJFD
    Route::get('/verifikasi', [ProposalController::class, 'verifikasi'])->name('proposal.verifikasi'); // daftar verifikasi
    Route::get('/verifikasi/{id}', [ProposalController::class, 'verifikasiDetail'])->name('proposal.verifikasiDetail'); // detail verifikasi
    Route::post('/verifikasi/{id}/assign', [ProposalController::class, 'assignDosen'])->name('proposal.assignDosen'); // tugaskan dosen
});

require __DIR__ . '/auth.php';
