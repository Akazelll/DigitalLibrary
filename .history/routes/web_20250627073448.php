<?php

use Illuminate\Support\Facades\Route;

// Tambahkan use statement untuk semua controller yang kita gunakan
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Penerbit;
use App\Models\Buku;
use App\Models\Peminjaman;

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
    // Tentukan sapaan dinamis
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
 
        $viewData['peminjamanUser'] = Peminjaman::where('id_user', Auth::id())
            ->with('buku')
            ->latest('tgl_pinjam')
            ->get();
    }


    return view('dashboard', $viewData);
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    // Rute untuk profil user bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


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
require __DIR__ . '/auth.php';
