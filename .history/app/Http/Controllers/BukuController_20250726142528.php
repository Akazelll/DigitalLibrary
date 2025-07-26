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

        $search = $request->input('search');
        $kategoriFilter = $request->input('kategori');

        $sortableColumns = ['judul_buku', 'tahun_terbit', 'stok', 'created_at'];
        $sortBy = in_array($request->query('sort_by'), $sortableColumns) ? $request->query('sort_by') : 'created_at';
        $sortDirection = in_array($request->query('sort_direction'), ['asc', 'desc']) ? $request->query('sort_direction') : 'desc';

        $buku = Buku::with(['penerbit', 'kategori'])
            ->when($search, function ($query, $search) {
                return $query->where('judul_buku', 'like', "%{$search}%")
                    ->orWhereHas('penerbit', function ($q) use ($search) {
                        $q->where('nama_penerbit', 'like', "%{$search}%");
                    });
            })

            ->when($kategoriFilter, function ($query, $kategoriFilter) {
                return $query->whereHas('kategori', function ($q) use ($kategoriFilter) {
                    $q->where('nama_kategori', $kategoriFilter);
                });
            })
            ->orderBy('judul_buku', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view('buku.index', compact('buku', 'sortBy', 'sortDirection'));
    }


    public function create()
    {
        $penerbit = Penerbit::all();
        $kategori = Kategori::all();
        return view('buku.create', compact('penerbit', 'kategori'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('sampul')) {
            $path = $request->file('sampul')->store('sampul_buku', 'public');
            $validatedData['sampul'] = $path;
        }

        Buku::create($validatedData);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil disimpan.');
    }


    public function show(Buku $buku)
    {
        return redirect()->route('buku.edit', $buku);
    }

   
    public function edit(Buku $buku)
    {
        $penerbit = Penerbit::all();
        $kategori = Kategori::all();
        return view('buku.edit', compact('buku', 'penerbit', 'kategori'));
    }

    
    public function update(Request $request, Buku $buku)
    {
        $validatedData = $request->validated();

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


    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->back()->with('success', 'Buku berhasil dihapus.');
    }
}
