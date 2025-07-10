<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Support\Facades\DB; // <-- 1. TAMBAHKAN INI

class PeminjamanController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'is.admin']);
    }

    // ... method index() ...

    public function create()
    {
        $data['users'] = User::all();
        // 2. HANYA TAMPILKAN BUKU YANG STOKNYA LEBIH DARI 0
        $data['buku'] = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
        ]);

        // 3. GUNAKAN DATABASE TRANSACTION
        DB::transaction(function () use ($request) {
            // Buat data peminjaman baru
            Peminjaman::create([
                'id_user' => $request->id_user,
                'id_buku' => $request->id_buku,
                'tgl_pinjam' => $request->tgl_pinjam,
                'status' => 'pinjam'
            ]);

            // Kurangi stok buku yang dipinjam
            $buku = Buku::find($request->id_buku);
            $buku->decrement('stok');
        });

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan');
    }

    public function edit(string $id)
    {
        // 4. GUNAKAN DATABASE TRANSACTION
        DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::findOrFail($id);

            // Ubah status dan isi tanggal kembali
            $peminjaman->status = 'kembali';
            $peminjaman->tgl_kembali = now();
            $peminjaman->save();

            // Tambah kembali stok buku yang dikembalikan
            $buku = Buku::find($peminjaman->id_buku);
            if ($buku) { // Pastikan buku masih ada
                $buku->increment('stok');
            }
        });

        return redirect()->back()->with('success', 'Buku telah berhasil dikembalikan');
    }
}