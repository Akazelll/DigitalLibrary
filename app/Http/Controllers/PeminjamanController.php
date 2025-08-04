<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->latest('tgl_pinjam')->paginate(12);
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create(Request $request)
    {
        $user = null;
        $buku = null;

        if ($request->has('kode_anggota')) {
            $user = User::where('kode_anggota', $request->kode_anggota)->first();
            if (!$user) {
                return redirect()->route('peminjaman.create')->withErrors(['kode_anggota' => 'Kode anggota tidak ditemukan.']);
            }
        }

        if ($user && $request->has('kode_buku')) {
            $buku = Buku::where('kode_buku', $request->kode_buku)->first();
            if (!$buku) {
                return redirect()->route('peminjaman.create', ['kode_anggota' => $user->kode_anggota])->withErrors(['kode_buku' => 'Kode buku tidak ditemukan.']);
            }
            if ($buku->stok < 1) {
                return redirect()->route('peminjaman.create', ['kode_anggota' => $user->kode_anggota])->withErrors(['kode_buku' => 'Stok buku ini telah habis.']);
            }
        }

        return view('peminjaman.create', compact('user', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
        ]);

        $buku = Buku::findOrFail($request->id_buku);

        DB::transaction(function () use ($request, $buku) {
            Peminjaman::create([
                'id_user' => $request->id_user,
                'id_buku' => $request->id_buku,
                'tgl_pinjam' => $request->tgl_pinjam,
                'tanggal_harus_kembali' => \Carbon\Carbon::parse($request->tgl_pinjam)->addDays(7),
                'status' => 'pinjam'
            ]);
            $buku->decrement('stok');
        });

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::findOrFail($id);

            $denda = 0;
            if (now()->gt($peminjaman->tanggal_harus_kembali)) {
                $tanggalHarusKembali = \Carbon\Carbon::parse($peminjaman->tanggal_harus_kembali)->startOfDay();
                $tanggalKembali = now()->startOfDay();

                if ($tanggalKembali->gt($tanggalHarusKembali)) {
                    $hariTerlambat = $tanggalHarusKembali->diffInDays($tanggalKembali);
                    $denda = $hariTerlambat * Peminjaman::DENDA_PER_HARI;
                }
            }

            $peminjaman->status = 'kembali';
            $peminjaman->tgl_kembali = now();
            $peminjaman->denda = $denda;
            $peminjaman->status_denda = ($denda > 0) ? 'Belum Lunas' : 'Lunas';
            $peminjaman->save();

            $buku = Buku::find($peminjaman->id_buku);
            if ($buku) {
                $buku->increment('stok');
            }
        });

        return redirect()->back()->with('success', 'Buku telah berhasil dikembalikan.');
    }

    /**
     * ===================================================================
     * === PERBAIKAN DI SINI: Logika Pembayaran Denda yang Benar ===
     * ===================================================================
     */
    public function bayarDenda(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'jumlah_bayar' => 'required|integer|min:1'
        ]);

        $jumlahBayar = (int) $request->jumlah_bayar;
        $sisaDenda = $peminjaman->sisa_denda;

        // Validasi agar pembayaran tidak melebihi sisa denda
        if ($jumlahBayar > $sisaDenda) {
            return redirect()->back()->withErrors(['error' => 'Jumlah pembayaran melebihi sisa denda.']);
        }

        // Tambahkan pembayaran ke kolom denda_dibayar
        $peminjaman->denda_dibayar += $jumlahBayar;

        // Jika total yang dibayar sudah mencukupi, ubah status menjadi Lunas
        if ($peminjaman->denda_dibayar >= $peminjaman->denda) {
            $peminjaman->status_denda = 'Lunas';
        }

        $peminjaman->save();
        return redirect()->back()->with('success', 'Pembayaran denda sebesar Rp ' . number_format($jumlahBayar, 0, ',', '.') . ' berhasil dicatat.');
    }
    // Method lain yang tidak digunakan
    public function show(string $id) {}
    public function update(Request $request, string $id) {}
    public function destroy(string $id) {}
}
