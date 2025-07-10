<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        // Daftar kolom yang bisa diurutkan untuk keamanan
        $sortableColumns = ['judul_buku', 'tahun_terbit', 'stok', 'created_at'];

        // Ambil parameter sorting dari URL, dengan nilai default
        $sortBy = in_array($request->query('sort_by'), $sortableColumns) ? $request->query('sort_by') : 'created_at';
        $sortDirection = in_array($request->query('sort_direction'), ['asc', 'desc']) ? $request->query('sort_direction') : 'desc';

        $search = $request->input('search');

        $buku = Buku::with('penerbit')
            ->when($search, function ($query, $search) {
                return $query->where('judul_buku', 'like', "%{$search}%")
                    ->orWhereHas('penerbit', function ($q) use ($search) {
                        $q->where('nama_penerbit', 'like', "%{$search}%");
                    });
            })
            ->orderBy($sortBy, $sortDirection) // Terapkan pengurutan
            ->paginate(10) // Terapkan pagination
            ->withQueryString(); // Agar parameter search & sort tetap ada di link pagination

        // Kirim semua variabel yang dibutuhkan ke view
        return view('buku.index', compact('buku', 'sortBy', 'sortDirection'));
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
            'jml_halaman'   => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0'
        ]);

        Buku::create($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil disimpan.');
    }

    /**
     * Menampilkan detail buku (diarahkan ke form edit).
     */
    public function show(Buku $buku)
    {
        return redirect()->route('buku.edit', $buku);
    }

    /**
     * Menampilkan form untuk mengedit buku.
     */
    public function edit(Buku $buku)
    {
        $penerbit = Penerbit::all();
        return view('buku.edit', compact('buku', 'penerbit'));
    }

    /**
     * Mengupdate data buku di database.
     */
    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul_buku'    => 'required|string|max:255',
            'id_penerbit'   => 'required|exists:penerbit,id',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900',
            'jml_halaman'   => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0'
        ]);

        $buku->update($request->all());

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diubah.');
    }

    /**
     * Menghapus buku dari database (soft delete).
     */
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->back()->with('success', 'Buku berhasil dihapus.');
    }
}
