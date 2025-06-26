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
        $penerbit = \App\Models\Penerbit::all();
        $data['penerbit'] = Penerbit::all();
        return view('penerbit.index', compact('penerbit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('penerbit.index', compact('penerbit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_penerbit' => 'required'
        ]);

        $penerbit = new Penerbit();
        $penerbit->nama_penerbit = $request->nama_penerbit;
        $penerbit->save();

        return redirect()->route('penerbit.index')->with('success', 'Data berhasil disimpan');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['penerbit'] = Penerbit::find($id);
        return view('penerbit.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nama_penerbit' => 'required'
        ]);

        $penerbit = Penerbit::find($id);
        $penerbit->nama_penerbit = $request->nama_penerbit;
        $penerbit->save();

        return redirect()->route('penerbit.index')->with('success', 'Data berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $penerbit = Penerbit::find($id);
        $penerbit->delete(); 

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}