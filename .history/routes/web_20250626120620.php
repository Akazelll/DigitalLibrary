<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Tambahkan use statement untuk controller-controller kita
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;

use App\Models\User;
use App\Models\Penerbit;
use App\Models\Buku;
use App\Models\Peminjaman;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
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

    $totalPenerbit = Penerbit::count();
    $totalBuku = Buku::count();
    $totalUser = User::count();
    $peminjamanAktif = Peminjaman::where('status', 'pinjam')->count();

    $peminjamanTerbaru = Peminjaman::with(['user', 'buku'])->latest()->take(5)->get();

    return view('dashboard', [
        'greeting' => $greeting,
        'totalPenerbit' => $totalPenerbit,
        'totalBuku' => $totalBuku,
        'totalUser' => $totalUser,
        'peminjamanAktif' => $peminjamanAktif,
        'peminjamanTerbaru' => $peminjamanTerbaru,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('penerbit', PenerbitController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    Route::get('/laporan/peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('laporan.peminjaman.cetak');
});


require __DIR__ . '/auth.php';
