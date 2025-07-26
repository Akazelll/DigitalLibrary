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
    // Logika sapaan dinamis
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
        // Data Statistik untuk Kartu
        $viewData['totalPenerbit'] = \App\Models\Penerbit::count();
        $viewData['totalBuku'] = \App\Models\Buku::count();
        $viewData['totalUser'] = \App\Models\User::count();
        $viewData['peminjamanAktif'] = \App\Models\Peminjaman::where('status', 'pinjam')->count();

        // Data Analitik
        $viewData['bukuPopuler'] = \App\Models\Buku::withCount('peminjaman')->orderBy('peminjaman_count', 'desc')->take(5)->get();
        $viewData['anggotaAktif'] = \App\Models\User::withCount('peminjaman')->orderBy('peminjaman_count', 'desc')->take(5)->get();

        // Data untuk Grafik Peminjaman (6 bulan terakhir)
        $loanStats = \App\Models\Peminjaman::select(
            DB::raw('YEAR(tgl_pinjam) as year'),
            DB::raw('MONTH(tgl_pinjam) as month'),
            DB::raw('MONTHNAME(tgl_pinjam) as month_name'),
            DB::raw('COUNT(*) as count')
        )
            ->where('tgl_pinjam', '>=', now()->subMonths(6))
            ->groupBy('year', 'month', 'month_name')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $viewData['loanChartLabels'] = $loanStats->pluck('month_name');
        $viewData['loanChartData'] = $loanStats->pluck('count');
    } else {
        // Data untuk Pengguna Biasa
        $userId = Auth::id();
        $viewData['sedangDipinjam'] = \App\Models\Peminjaman::where('id_user', $userId)->where('status', 'pinjam')->with('buku')->latest('tgl_pinjam')->get();
        $viewData['totalDibaca'] = \App\Models\Peminjaman::where('id_user', $userId)->where('status', 'kembali')->count();
        $viewData['totalDenda'] = \App\Models\Peminjaman::where('id_user', $userId)->sum('denda');
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
