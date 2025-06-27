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


        $buku = Buku::with('penerbit')
            ->when($search, function ($query, $search) {
                return $query->where('judul_buku', 'like', "%{$search}%")
                    ->orWhereHas('penerbit', function ($q) use ($search) {
                        $q->where('nama_penerbit', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10);


        return view('buku.index', compact('buku'));
    }


    public function create()
    {
        $penerbit = Penerbit::all();
        return view('buku.create', compact('penerbit'));
    }


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


    public function show(string $id)
    {

        return redirect()->route('buku.edit', $id);
    }


    public function edit(string $id)
    {

        $buku = Buku::findOrFail($id);
        $penerbit = Penerbit::all();

        return view('buku.edit', compact('buku', 'penerbit'));
    }


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


    public function destroy(string $id)
    {
        $buku = \App\Models\Buku::findOrFail($id);
        $buku->delete();
        return redirect()->back()->with('success', 'Buku berhasil dihapus.');
    }
}
