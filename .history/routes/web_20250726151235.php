<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// Import semua Controller dan Model yang digunakan
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KategoriController;
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
        $viewData['totalPenerbit'] = Penerbit::count();
        $viewData['totalBuku'] = Buku::count();
        $viewData['totalUser'] = User::count();
        $viewData['peminjamanAktif'] = Peminjaman::where('status', 'pinjam')->count();

        // Data Analitik
        $viewData['bukuPopuler'] = Buku::withCount('peminjaman')->orderBy('peminjaman_count', 'desc')->take(5)->get();
        $viewData['anggotaAktif'] = User::withCount('peminjaman')->orderBy('peminjaman_count', 'desc')->take(5)->get();

        // ===================================================================
        // === PERUBAHAN DI SINI: Query untuk Grafik Tren Peminjaman ===
        // ===================================================================
        $loanStats = Peminjaman::select(
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
        // Data untuk User Biasa
        $viewData['peminjamanUser'] = Peminjaman::where('id_user', Auth::id())
            ->with('buku')
            ->latest('tgl_pinjam')
            ->get();
    }

    return view('dashboard', $viewData);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // ... (sisa rute Anda yang lain tetap sama)
});

require __DIR__ . '/auth.php';
