<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Import semua Controller yang digunakan
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;

// Import semua Model yang digunakan
use App\Models\User;
use App\Models\Penerbit;
use App\Models\Buku;
use App\Models\Peminjaman;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| File ini berisi semua rute untuk aplikasi Anda.
*/

// Halaman utama (Welcome Page)
Route::get('/', function () {
    return view('welcome');
});

// Rute Dashboard yang dinamis berdasarkan peran pengguna
Route::get('/dashboard', function () {
    // Logika untuk sapaan dinamis
    $hour = now('Asia/Jakarta')->hour;
    if ($hour < 11) { $greeting = 'Selamat Pagi🌄'; } 
    elseif ($hour < 15) { $greeting = 'Selamat Siang🌞'; } 
    elseif ($hour < 19) { $greeting = 'Selamat Sore🌤️'; } 
    else { $greeting = 'Selamat Malam🌙'; }
    
    $viewData = ['greeting' => $greeting];

    // Logika untuk menampilkan data berdasarkan peran (role)
    if (Auth::user()->role == 'admin') {
        // Data untuk Admin
        $viewData['totalPenerbit'] = Penerbit::count();
        $viewData['totalBuku'] = Buku::count();
        $viewData['totalUser'] = User::count();
        $viewData['peminjamanAktif'] = Peminjaman::where('status', 'pinjam')->count();
        $viewData['peminjamanTerbaru'] = Peminjaman::with(['user', 'buku'])->latest()->take(5)->get();
        
        // Data untuk Grafik (6 bulan terakhir)
        $bookStats = Buku::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('MONTHNAME(created_at) as month_name'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month', 'month_name')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $viewData['chartLabels'] = $bookStats->pluck('month_name');
        $viewData['chartData'] = $bookStats->pluck('count');

    } else {
        // Data untuk User Biasa
        $viewData['peminjamanUser'] = Peminjaman::where('id_user', Auth::id())
                                            ->with('buku')
                                            ->latest('tgl_pinjam')
                                            ->get();
    }
    
    return view('dashboard', $viewData);

})->middleware(['auth', 'verified'])->name('dashboard');


// Grup rute yang memerlukan login
Route::middleware('auth')->group(function () {
    // Rute profil pengguna (bawaan Breeze)
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
        Route::resource('penerbit', PenerbitController::class)->except(['show']);
        
        // Rute CRUD untuk Peminjaman
        Route::resource('peminjaman', PeminjamanController::class)->except(['show', 'destroy', 'update']);
        
        // Rute CRUD untuk Kategori
        Route::resource('kategori', KategoriController::class)->except(['index', 'show']);

        // Rute CRUD untuk Buku
        Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

        // Rute untuk Laporan
        Route::get('/laporan/peminjaman/cetak', [LaporanController::class, 'cetakPeminjaman'])->name('laporan.peminjaman.cetak');
    });

    // Rute detail buku (di luar grup admin agar bisa diakses jika diperlukan)
    Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
});

// Memuat rute autentikasi dari Breeze
require __DIR__.'/auth.php';