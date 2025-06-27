<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
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
    // ... (logika dashboard Anda sudah benar) ...
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
        $viewData['totalPenerbit'] = Penerbit::count();
        $viewData['totalBuku'] = Buku::count();
        $viewData['totalUser'] = User::count();
        $viewData['peminjamanAktif'] = Peminjaman::where('status', 'pinjam')->count();
        $viewData['peminjamanTerbaru'] = Peminjaman::with(['user', 'buku'])->latest()->take(5)->get();
    } else {
        $viewData['peminjamanUser'] = Peminjaman::where('id_user', Auth::id())->with('buku')->latest('tgl_pinjam')->get();
    }
    return view('dashboard', $viewData);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === RUTE APLIKASI PERPUSTAKAAN ===

    // Rute Buku yang bisa diakses SEMUA user login
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    // PENTING: Rute statis seperti 'create' harus didefinisikan SEBELUM rute dinamis seperti '{buku}'
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create')->middleware('is.admin');
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');

    // Grup rute yang HANYA bisa diakses oleh ADMIN
    Route::middleware('is.admin')->group(function () {
        // Rute CRUD untuk Penerbit dan Peminjaman
        Route::resource('penerbit', PenerbitController::class)->except(['show']); // Method show tidak kita gunakan
        Route::resource('peminjaman', PeminjamanController::class)->except(['show', 'destroy']); // Method show & destroy tidak kita gunakan

        // Rute CRUD untuk Buku yang khusus Admin (tanpa create, index, show)
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

        // Rute untuk Laporan
        Route::get('/laporan/peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('laporan.peminjaman.cetak');
    });
});

require __DIR__ . '/auth.php';
