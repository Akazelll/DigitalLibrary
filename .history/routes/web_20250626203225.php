<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    // --- 1. Logika yang berlaku untuk semua user ---
    $hour = now('Asia/Jakarta')->hour;

    if ($hour < 11) { $greeting = 'Selamat Pagi🌄'; } 
    elseif ($hour < 15) { $greeting = 'Selamat Siang🌞'; } 
    elseif ($hour < 19) { $greeting = 'Selamat Sore🌤️'; } 
    else { $greeting = 'Selamat Malam🌙'; }

    // Siapkan array data awal yang akan dikirim ke view
    $viewData = ['greeting' => $greeting];

    // --- 2. Logika berdasarkan peran (role) ---
    if (Auth::user()->role == 'admin') {
        // Jika admin, isi $viewData dengan data statistik
        $viewData['totalPenerbit'] = \App\Models\Penerbit::count();
        $viewData['totalBuku'] = \App\Models\Buku::count();
        $viewData['totalUser'] = \App\Models\User::count();
        $viewData['peminjamanAktif'] = \App\Models\Peminjaman::where('status', 'pinjam')->count();
        $viewData['peminjamanTerbaru'] = \App\Models\Peminjaman::with(['user', 'buku'])->latest()->take(5)->get();
    } else {
        // Jika user biasa, isi $viewData dengan data peminjaman milik user tersebut
        $viewData['peminjamanUser'] = \App\Models\Peminjaman::where('id_user', Auth::id())
                                            ->with('buku')
                                            ->latest()
                                            ->get();
    }

    // --- 3. Kirim data yang sudah disiapkan ke view ---
    return view('dashboard', $viewData);

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
