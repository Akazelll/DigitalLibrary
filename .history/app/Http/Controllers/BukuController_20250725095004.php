<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use APp
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index(Request $request)
    {
        $sortableColumns = ['judul_buku', 'tahun_terbit', 'stok', 'created_at'];
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
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10)
            ->withQueryString();

        return view('buku.index', compact('buku', 'sortBy', 'sortDirection'));
    }


    public function create()
    {
        $penerbit = Penerbit::all();
        $kategori = \App\Models\Kategori::all();
        return view('buku.create', compact('penerbit', 'kategori'));
    }

    /**
     * Menyimpan buku baru ke database.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul_buku'    => 'required|string|max:255',
            'id_penerbit'   => 'required|exists:penerbit,id',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900',
            'jml_halaman'   => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0',
            'sampul'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // Validasi untuk gambar
        ]);

        if ($request->hasFile('sampul')) {
            // Simpan gambar dan dapatkan path-nya
            $path = $request->file('sampul')->store('sampul_buku', 'public');
            $validatedData['sampul'] = $path;
        }

        Buku::create($validatedData);

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
        $kategori = \App\Models\Kategori::all();
        return view('buku.edit', compact('buku', 'penerbit' , 'kategori'));
    }

    /**
     * Mengupdate data buku di database.
     */
    public function update(Request $request, Buku $buku)
    {
        $validatedData = $request->validate([
            'judul_buku'    => 'required|string|max:255',
            'id_penerbit'   => 'required|exists:penerbit,id',
            'tahun_terbit'  => 'required|digits:4|integer|min:1900',
            'jml_halaman'   => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0',
            'sampul'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('sampul')) {
            // Hapus gambar lama jika ada
            if ($buku->sampul) {
                Storage::disk('public')->delete($buku->sampul);
            }
            // Simpan gambar baru dan tambahkan path ke data yang divalidasi
            $path = $request->file('sampul')->store('sampul_buku', 'public');
            $validatedData['sampul'] = $path;
        }

        $buku->update($validatedData);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil diubah.');
    }
    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->back()->with('success', 'Buku berhasil dihapus.');
    }
}
