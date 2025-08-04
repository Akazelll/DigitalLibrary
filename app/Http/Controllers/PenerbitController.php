<?php

namespace App\Http\Controllers;

use App\Models\Penerbit;
use Illuminate\Http\Request;


class PenerbitController extends Controller
{

    public function index()
    {
        $penerbit = \App\Models\Penerbit::withCount('buku')
            ->orderBy('nama_penerbit', 'asc')
            ->paginate(12);

        return view('penerbit.index', compact('penerbit'));
    }

    public function create()
    {
        return view('penerbit.create');
    }

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

    public function destroy(Penerbit $penerbit)
    {
        if ($penerbit->buku()->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Penerbit tidak dapat dihapus karena masih memiliki buku.']);
        }

        $penerbit->delete();
        return redirect()->back()->with('success', 'Penerbit berhasil dihapus.');
    }

    public function downloadPDF()
    {
        $penerbit = Penerbit::withCount('buku')->orderBy('nama_penerbit', 'asc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('penerbit.pdf', compact('penerbit'));
        return $pdf->stream('laporan-data-penerbit.pdf');
    }
}
