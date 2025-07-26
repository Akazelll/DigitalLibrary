<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $penerbit = \App\Models\Penerbit::latest()->paginate(12);

        return view('penerbit.index', compact('penerbit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penerbit.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_penerbit' => 'required'
        ]);

        $penerbit = new Penerbit();
        $penerbit->nama_penerbit = $request->nama_penerbit;
        $penerbit->save();

        return redirect()->route('penerbit.index')->with('success', 'Data berhasil disimpan');
    }

    public function edit(string $id)
    {
        $data['penerbit'] = Penerbit::find($id);
        return view('penerbit.edit', $data);
    }

 
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_penerbit' => 'required'
        ]);

        $penerbit = \App\Models\Penerbit::find($id);
        $penerbit->update([
            'nama_penerbit' => $request->nama_penerbit
        ]);

        return redirect()->route('penerbit.index')->with('success', 'Data berhasil diubah');
    }

    public function destroy(string $id)
    {
        $penerbit = Penerbit::find($id);
        $penerbit->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
