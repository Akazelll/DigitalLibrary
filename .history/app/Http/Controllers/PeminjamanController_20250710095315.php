<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    // The __construct() method has been removed as middleware is handled in web.php

    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])->latest('tgl_pinjam')->paginate(10);
        return view('peminjaman.index', compact('peminjaman'));
    }

    public function create()
    {
        $users = User::all();
        $buku = Buku::where('stok', '>', 0)->get();
        return view('peminjaman.create', compact('users', 'buku'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_buku' => 'required|exists:buku,id',
            'tgl_pinjam' => 'required|date',
        ]);

        $buku = Buku::findOrFail($request->id_buku);
        if ($buku->stok < 1) {
            return redirect()->back()->withErrors(['id_buku' => 'Stok buku ini telah habis.'])->withInput();
        }

        DB::transaction(function () use ($request, $buku) {
            Peminjaman::create([
                'id_user' => $request->id_user,
                'id_buku' => $request->id_buku,
                'tgl_pinjam' => $request->tgl_pinjam,
                'status' => 'pinjam'
            ]);

            $buku->decrement('stok');
        });

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        DB::transaction(function () use ($id) {
            $peminjaman = Peminjaman::findOrFail($id);

            $peminjaman->status = 'kembali';
            $peminjaman->tgl_kembali = now();
            $peminjaman->save();

            $buku = Buku::find($peminjaman->id_buku);
            if ($buku) {
                $buku->increment('stok');
            }
        });

        return redirect()->back()->with('success', 'Buku telah berhasil dikembalikan.');
    }

    public function show(string $id) {}

    public function update(Request $request, string $id) {}

    public function destroy(string $id) {}
}
