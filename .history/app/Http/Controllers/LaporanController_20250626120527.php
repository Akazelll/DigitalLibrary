<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf; // Import class PDF

class LaporanController extends Controller
{
    public function cetakPeminjaman(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_awal',
        ]);

        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;

        // Ambil data peminjaman berdasarkan rentang tanggal
        $peminjaman = Peminjaman::with(['user', 'buku'])
                                ->whereBetween('tgl_pinjam', [$tanggalAwal, $tanggalAkhir])
                                ->orderBy('tgl_pinjam', 'asc')
                                ->get();

        // Load view PDF dengan data yang sudah difilter
        $pdf = Pdf::loadView('laporan.peminjaman_pdf', [
            'peminjaman' => $peminjaman,
            'tanggalAwal' => $tanggalAwal,
            'tanggalAkhir' => $tanggalAkhir,
        ]);

        // Tampilkan PDF di browser atau unduh
        // return $pdf->download('laporan-peminjaman.pdf'); // Untuk langsung download
        return $pdf->stream('laporan-peminjaman.pdf'); // Untuk menampilkan di browser
    }
}