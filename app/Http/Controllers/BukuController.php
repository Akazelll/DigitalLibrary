<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Penerbit;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    /**
     * Menampilkan daftar buku dengan semua fitur.
     */
    public function index(Request $request)
    {
        // Ambil parameter dari URL
        $search = $request->input('search');
        $kategoriFilter = $request->input('kategori'); // <-- Parameter baru untuk filter kategori

        // Daftar kolom yang bisa diurutkan
        $sortableColumns = ['judul_buku', 'tahun_terbit', 'stok', 'created_at'];
        $sortBy = in_array($request->query('sort_by'), $sortableColumns) ? $request->query('sort_by') : 'created_at';
        $sortDirection = in_array($request->query('sort_direction'), ['asc', 'desc']) ? $request->query('sort_direction') : 'desc';

        $buku = Buku::with(['penerbit', 'kategori']) // Muat relasi kategori
            ->when($search, function ($query, $search) {
                return $query->where('judul_buku', 'like', "%{$search}%")
                    ->orWhereHas('penerbit', function ($q) use ($search) {
                        $q->where('nama_penerbit', 'like', "%{$search}%");
                    });
            })
            // 2. Terapkan filter kategori jika ada
            ->when($kategoriFilter, function ($query, $kategoriFilter) {
                return $query->whereHas('kategori', function ($q) use ($kategoriFilter) {
                    $q->where('nama_kategori', $kategoriFilter);
                });
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(10)
            ->withQueryString();

        return view('buku.index', compact('buku', 'sortBy', 'sortDirection'));
    }

    /**
     * Menampilkan form untuk membuat buku baru.
     */
    public function create()
    {
        $penerbit = Penerbit::all();
        $kategori = Kategori::all(); // Ambil data kategori
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
            'kategori_id'   => 'nullable|exists:kategori,id', // <-- 3. Tambahkan validasi kategori
            'tahun_terbit'  => 'required|digits:4|integer|min:1900',
            'jml_halaman'   => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0',
            'sampul'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('sampul')) {
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
        $kategori = Kategori::all(); // Ambil data kategori
        return view('buku.edit', compact('buku', 'penerbit', 'kategori'));
    }

    /**
     * Mengupdate data buku di database.
     */
    public function update(Request $request, Buku $buku)
    {
        $validatedData = $request->validate([
            'judul_buku'    => 'required|string|max:255',
            'id_penerbit'   => 'required|exists:penerbit,id',
            'kategori_id'   => 'nullable|exists:kategori,id', // <-- 4. Tambahkan validasi kategori
            'tahun_terbit'  => 'required|digits:4|integer|min:1900',
            'jml_halaman'   => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0',
            'sampul'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('sampul')) {
            if ($buku->sampul) {
                Storage::disk('public')->delete($buku->sampul);
            }
            $path = $request->file('sampul')->store('sampul_buku', 'public');
            $validatedData['sampul'] = $path;
        }

        $buku->update($validatedData);

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
