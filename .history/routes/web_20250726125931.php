// routes/web.php

// Pastikan semua use statement ini ada di bagian atas file
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Penerbit;
use App\Models\Buku;
use App\Models\Peminjaman;

// ... (rute lain) ...

Route::get('/dashboard', function () {
    // Tentukan sapaan dinamis
    $hour = now('Asia/Jakarta')->hour;
    if ($hour < 11) { $greeting = 'Selamat Pagi🌄'; } 
    elseif ($hour < 15) { $greeting = 'Selamat Siang🌞'; } 
    elseif ($hour < 19) { $greeting = 'Selamat Sore🌤️'; } 
    else { $greeting = 'Selamat Malam🌙'; }

    // Siapkan array data awal yang akan dikirim ke view
    $viewData = ['greeting' => $greeting];

    // Cek peran pengguna dan siapkan data yang sesuai
    if (Auth::user()->role == 'admin') {
        // Jika admin, isi $viewData dengan data statistik
        $viewData['totalPenerbit'] = Penerbit::count();
        $viewData['totalBuku'] = Buku::count();
        $viewData['totalUser'] = User::count();
        $viewData['peminjamanAktif'] = Peminjaman::where('status', 'pinjam')->count();
        $viewData['peminjamanTerbaru'] = Peminjaman::with(['user', 'buku'])->latest()->take(5)->get();
        $bookStats = Buku::select(DB::raw('YEAR(created_at) as year, MONTH(created_at) as month, MONTHNAME(created_at) as month_name, COUNT(*) as count'))->where('created_at', '>=', now()->subMonths(6))->groupBy('year', 'month', 'month_name')->orderBy('year', 'asc')->orderBy('month', 'asc')->get();
        $viewData['chartLabels'] = $bookStats->pluck('month_name');
        $viewData['chartData'] = $bookStats->pluck('count');
    } else {
        // Jika user biasa, isi $viewData dengan data peminjaman milik user tersebut
        $viewData['peminjamanUser'] = Peminjaman::where('id_user', Auth::id())->with('buku')->latest('tgl_pinjam')->get();
    }

    // Kirim data yang sudah disiapkan ke view dashboard
    return view('dashboard', $viewData);

})->middleware(['auth', 'verified'])->name('dashboard');

// ... (sisa kode rute Anda) ...