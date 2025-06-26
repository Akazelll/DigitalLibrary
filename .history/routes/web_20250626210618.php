<?php

use Illuminate\Support\Facades\Route;

// Tambahkan use statement untuk semua controller yang kita gunakan
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Welcome
Route::get('/', function () {
    return view('welcome');
});

// Rute Dashboard
Route::get('/dashboard', function () {
    // ... (kode untuk data dashboard) ...
})->middleware(['auth', 'verified'])->name('dashboard');


// Grup rute yang hanya bisa diakses setelah login
Route::middleware('auth')->group(function () {
    // Rute untuk profil user bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === RUTE APLIKASI PERPUSTAKAAN ===

    // Rute Buku (Akses Campuran)
    // User biasa bisa melihat index & show. Semua aksi lain (create, edit, delete) harus admin.
    Route::resource('buku', BukuController::class)
        ->only(['index', 'show']); // Hanya index dan show yang bisa diakses oleh semua user yang login
    Route::resource('buku', BukuController::class)
        ->except(['index', 'show'])
        ->middleware('is.admin'); // Aksi lainnya harus admin

    // Grup rute yang hanya bisa diakses oleh admin
    Route::middleware('is.admin')->group(function () {
        Route::resource('penerbit', PenerbitController::class);
        Route::resource('peminjaman', PeminjamanController::class);
        Route::get('/laporan/peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('laporan.peminjaman.cetak');
    });
});

// Rute untuk file auth.php dari Breeze
require __DIR__.'/auth.php';