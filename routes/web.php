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

Route::get('/', function () { return view('welcome'); });

Route::get('/dashboard', function () {
    $hour = now('Asia/Jakarta')->hour;
    if ($hour < 11) { $greeting = 'Selamat Pagi🌄'; } 
    elseif ($hour < 15) { $greeting = 'Selamat Siang🌞'; } 
    elseif ($hour < 19) { $greeting = 'Selamat Sore🌤️'; } 
    else { $greeting = 'Selamat Malam🌙'; }
    
    $viewData = ['greeting' => $greeting];

    if (Auth::user()->role == 'admin') {
        $viewData['totalPenerbit'] = Penerbit::count();
        $viewData['totalBuku'] = Buku::count();
        $viewData['totalUser'] = User::count();
        $viewData['peminjamanAktif'] = Peminjaman::where('status', 'pinjam')->count();
        $viewData['peminjamanTerbaru'] = Peminjaman::with(['user', 'buku'])->latest()->take(5)->get();
        $bookStats = Buku::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, MONTHNAME(created_at) as month_name, COUNT(*) as count'))->where('created_at', '>=', now()->subMonths(6))->groupBy('year', 'month', 'month_name')->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
        $viewData['chartLabels'] = $bookStats->pluck('month_name');
        $viewData['chartData'] = $bookStats->pluck('count');
    } else {
        $viewData['peminjamanUser'] = Peminjaman::where('id_user', Auth::id())->with('buku')->latest('tgl_pinjam')->get();
    }
    
    return view('dashboard', $viewData);
})->middleware(['auth', 'verified'])->name('dashboard');

// Grup rute yang memerlukan login
Route::middleware('auth')->group(function () {
    // Rute profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // === RUTE APLIKASI PERPUSTAKAAN ===

    // Rute yang bisa diakses SEMUA user login
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
    
    // Grup rute yang HANYA bisa diakses oleh ADMIN
    Route::middleware('is.admin')->group(function () {
        // Rute CRUD untuk Penerbit
        Route::get('/penerbit', [PenerbitController::class, 'index'])->name('penerbit.index');
        Route::get('/penerbit/create', [PenerbitController::class, 'create'])->name('penerbit.create');
        Route::post('/penerbit', [PenerbitController::class, 'store'])->name('penerbit.store');
        Route::get('/penerbit/{penerbit}/edit', [PenerbitController::class, 'edit'])->name('penerbit.edit');
        Route::put('/penerbit/{penerbit}', [PenerbitController::class, 'update'])->name('penerbit.update');
        Route::delete('/penerbit/{penerbit}', [PenerbitController::class, 'destroy'])->name('penerbit.destroy');

        // Rute CRUD untuk Kategori
        Route::get('/kategori/create', [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Rute CRUD untuk Buku
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

        // Rute CRUD untuk Peminjaman
        Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
        Route::get('/peminjaman/create', [PeminjamanController::class, 'create'])->name('peminjaman.create');
        Route::post('/peminjaman', [PeminjamanController::class, 'store'])->name('peminjaman.store');
        Route::get('/peminjaman/{peminjaman}/edit', [PeminjamanController::class, 'edit'])->name('peminjaman.edit'); // Untuk proses 'kembalikan'

        // Rute untuk Laporan
        Route::get('/laporan/peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('laporan.peminjaman.cetak');
    });

    // Rute detail buku (di luar grup admin agar bisa diakses jika diperlukan)
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
});

require __DIR__.'/auth.php';