<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        // Ambil data buku dengan relasi penerbitnya
        $search = $request->input('search');
        $query = \App\Models\Buku::with('penerbit');

        if ($search) {
            $query->where(function ($q) use ($search) {
                // Cari berdasarkan judul buku
                $q->where('judul_buku', 'like', '%' . $search . '%')
                    // ATAU cari berdasarkan nama penerbit (melalui relasi)
                    ->orWhereHas('penerbit', function ($subq) use ($search) {
                        $subq->where('nama_penerbit', 'like', '%' . $search . '%');
                    });
            });
        }
        $data['buku'] = $query->latest()->paginate(10);

        return view('buku.index', $data);
    }

    public function create()
    {
        // Ambil semua data penerbit untuk ditampilkan di dropdown
        $data['penerbit'] = Penerbit::all();
        return view('buku.create', $data);
    }

    public function store(Request $request)
    {
        // Validasi input sesuai aturan di PDF
        $request->validate([
            'judul_buku'    => 'required',
            'id_penerbit'   => 'required',
            'tahun_terbit'  => 'required',
            'jml_halaman'   => 'required'
        ]);

        // Buat data buku baru
        Buku::create([
            'judul_buku'    => $request->judul_buku,
            'id_penerbit'   => $request->id_penerbit,
            'tahun_terbit'  => $request->tahun_terbit,
            'jml_halaman'   => $request->jml_halaman
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil disimpan');
    }

    public function edit(string $id)
    {
        // Cari buku berdasarkan ID
        $data['buku'] = Buku::find($id);
        // Ambil semua data penerbit untuk dropdown
        $data['penerbit'] = Penerbit::all();

        return view('buku.edit', $data);
    }

    public function update(Request $request, string $id)
    {
        // Validasi input
        $request->validate([
            'judul_buku'    => 'required',
            'id_penerbit'   => 'required',
            'tahun_terbit'  => 'required',
            'jml_halaman'   => 'required'
        ]);

        // Cari buku dan update datanya
        $buku = Buku::find($id);
        $buku->update([
            'judul_buku'    => $request->judul_buku,
            'id_penerbit'   => $request->id_penerbit,
            'tahun_terbit'  => $request->tahun_terbit,
            'jml_halaman'   => $request->jml_halaman
        ]);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diubah');
    }

    public function destroy(string $id)
    {
        // Cari buku dan hapus
        $buku = Buku::find($id);
        $buku->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus');
    }
}
