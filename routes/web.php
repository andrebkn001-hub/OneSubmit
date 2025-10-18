<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

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
            abort(403, 'Role tidak dikenal');
    }
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// 💡 Tambahkan bagian ini
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
    Route::get('/jurusan/dashboard', fn() => view('dashboard.jurusan'))->name('jurusan.dashboard');
    Route::get('/kjfd/dashboard', fn() => view('dashboard.kjfd'))->name('kjfd.dashboard');
    Route::get('/mahasiswa/dashboard', fn() => view('dashboard.mahasiswa'))->name('mahasiswa.dashboard');
});

require __DIR__.'/auth.php';
