<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Tambahkan use statement untuk controller-controller kita
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;

use App\Models\User;
use App\Models\Penerbit;
use App\Models\Buku;
use App\Models\Peminjaman;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $totalPenerbit = Penerbit::count();
    $totalBuku = Buku::count();
    $totalUser = User::count();
    $peminjamanAktif = Peminjaman::where('status', 'pinjam')->count();

    return view('dashboard', [
        'totalPenerbit' => $totalPenerbit,
        'totalBuku' => $totalBuku,
        'totalUser' => $totalUser,
        'peminjamanAktif' => $peminjamanAktif,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


// Grup rute ini memastikan hanya user yang sudah login yang bisa mengaksesnya
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('penerbit', PenerbitController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    // ================================================================

});


require __DIR__ . '/auth.php';
