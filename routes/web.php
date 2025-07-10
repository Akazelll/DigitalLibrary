<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Http\Controllers\ProfileController;
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


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

    Route::middleware('is.admin')->group(function () {

        Route::resource('penerbit', PenerbitController::class)->except(['show']);
        Route::resource('peminjaman', PeminjamanController::class)->except(['show', 'destroy']);

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
