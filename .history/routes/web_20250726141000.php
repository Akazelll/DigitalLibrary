<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Import semua Controller
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;

// Import semua Model
use App\Models\User;
use App\Models\Penerbit;
use App\Models\Buku;
use App\Models\Peminjaman;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    // ... (kode untuk data dashboard Anda sudah benar) ...
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // ... (Rute profil Anda) ...

    // === RUTE APLIKASI PERPUSTAKAAN ===

    // Rute yang bisa diakses SEMUA user login
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

    // PERBAIKAN: Rute untuk melihat daftar penerbit bisa diakses semua user
    Route::get('/penerbit', [PenerbitController::class, 'index'])->name('penerbit.index');

    // Grup rute yang HANYA bisa diakses oleh ADMIN
    Route::middleware('is.admin')->group(function () {
        // PERBAIKAN: Rute CRUD Penerbit (selain index) hanya untuk admin
        Route::resource('penerbit', PenerbitController::class)->except(['index', 'show']);

        Route::resource('peminjaman', PeminjamanController::class)->except(['show', 'destroy']);
        Route::resource('kategori', KategoriController::class)->except(['index', 'show']);

        // Rute CRUD untuk Buku yang khusus Admin
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

        Route::get('/laporan/peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('laporan.peminjaman.cetak');
    });

    // Rute detail buku (di luar grup admin)
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
});

require __DIR__ . '/auth.php';
