<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Query yang lebih rapi
        $buku = Buku::with('penerbit')
            ->when($search, function ($query, $search) {
                return $query->where('judul_buku', 'like', "%{$search}%")
                    ->orWhereHas('penerbit', function ($q) use ($search) {
                        $q->where('nama_penerbit', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);

        // Mengirim data menggunakan compact() agar lebih bersih
        return view('buku.index', compact('buku'));
    }

    /**
     * Menampilkan form untuk membuat buku baru.
     */
    public function create()
    {
        $penerbit = Penerbit::all();
        return view('buku.create', compact('penerbit'));
    }

    /**
     * Menyimpan buku baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul_buku'    => 'required|string|max:255',
            'id_penerbit'   => 'required|exists:penerbit,id',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900',
            'jml_halaman'   => 'required|integer|min:1'
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil disimpan.');
    }

    /**
     * Menampilkan form untuk mengedit buku.
     */
    public function show(string $id)
    {
        // Biasanya method 'show' untuk menampilkan detail, bisa diarahkan ke 'edit'
        return redirect()->route('buku.edit', $id);
    }

    /**
     * Menampilkan form untuk mengedit buku.
     */
    public function edit(string $id)
    {
        // findOrFail akan otomatis menampilkan error 404 jika ID tidak ditemukan
        $buku = Buku::findOrFail($id);
        $penerbit = Penerbit::all();

        return view('buku.edit', compact('buku', 'penerbit'));
    }

    /**
     * Mengupdate data buku di database.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul_buku'    => 'required|string|max:255',
            'id_penerbit'   => 'required|exists:penerbit,id',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900',
            'jml_halaman'   => 'required|integer|min:1'
        ]);

        $buku = Buku::findOrFail($id);
        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diubah.');
    }

    /**
     * Menghapus buku dari database.
     */
    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();

        return redirect()->back()->with('success', 'Buku berhasil dihapus.');
    }
}
