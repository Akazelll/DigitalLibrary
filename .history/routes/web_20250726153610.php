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
    // ... (kode sapaan dinamis Anda tetap sama) ...
    $hour = now('Asia/Jakarta')->hour;
    if ($hour < 11) {
        $greeting = 'Selamat Pagi🌄';
    } elseif ($hour < 15) {
        $greeting = 'Selamat Siang🌞';
    } elseif ($hour < 19) {
        $greeting = 'Selamat Sore🌤️';
    } else {
        $greeting = 'Selamat Malam🌙';
    }

    $viewData = ['greeting' => $greeting];

    if (Auth::user()->role == 'admin') {
        // ... (logika untuk admin Anda tetap sama) ...
    } else {
        // ===================================================================
        // === BARU: Logika lengkap untuk data dashboard pengguna biasa ===
        // ===================================================================
        $userId = Auth::id();

        // 1. Ambil buku yang SEDANG dipinjam
        $viewData['sedangDipinjam'] = \App\Models\Peminjaman::where('id_user', $userId)
            ->where('status', 'pinjam')
            ->with('buku')
            ->latest('tgl_pinjam')
            ->get();

        // 2. Hitung statistik pribadi
        $viewData['totalDibaca'] = \App\Models\Peminjaman::where('id_user', $userId)
            ->where('status', 'kembali')
            ->count();
        $viewData['totalDenda'] = \App\Models\Peminjaman::where('id_user', $userId)
            ->sum('denda');

        // 3. Ambil 5 buku terbaru sebagai rekomendasi
        $viewData['bukuTerbaru'] = \App\Models\Buku::latest()->take(5)->get();
    }

    return view('dashboard', $viewData);
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup rute yang memerlukan login
Route::middleware('auth')->group(function () {
    // Rute profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profil/riwayat-peminjaman', [ProfileController::class, 'myBorrowingHistory'])->name('profile.history');

    // Rute yang bisa diakses SEMUA user login
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    Route::get('/penerbit', [PenerbitController::class, 'index'])->name('penerbit.index');

    // Grup rute yang HANYA bisa diakses oleh ADMIN
    Route::middleware('is.admin')->group(function () {
        Route::resource('penerbit', PenerbitController::class)->except(['index', 'show']);
        Route::resource('peminjaman', PeminjamanController::class)->except(['show', 'destroy']);
        Route::resource('kategori', KategoriController::class)->except(['index', 'show']);

        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

        Route::get('/laporan/peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('laporan.peminjaman.cetak');
    });

    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
});

require __DIR__ . '/auth.php';
