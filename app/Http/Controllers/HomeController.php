<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Mengambil data peminjaman dalam 6 bulan terakhir
        $loanStats = Peminjaman::select(
            DB::raw('YEAR(tgl_pinjam) as year, MONTH(tgl_pinjam) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->where('tgl_pinjam', '>=', now()->subMonths(6)->startOfMonth())
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Mempersiapkan label untuk 6 bulan terakhir
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $labels[] = now()->subMonths($i)->isoFormat('MMMM');
        }

        // Memetakan data ke dalam array yang sesuai dengan label bulan
        $data = array_fill(0, 6, 0);
        foreach ($loanStats as $stat) {
            $monthName = \Carbon\Carbon::createFromDate($stat->year, $stat->month, 1)->isoFormat('MMMM');
            $index = array_search($monthName, $labels);
            if ($index !== false) {
                $data[$index] = $stat->count;
            }
        }

        // Mengirim data ke view
        return view('dashboard', [
            'loanChartLabels' => $labels,
            'loanChartData' => $data,
            // ... (variabel lain yang mungkin Anda butuhkan di dasbor)
        ]);
    }
}
