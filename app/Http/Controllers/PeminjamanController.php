<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Ambil data peminjaman beserta relasi user dan buku, urutkan dari yang terbaru
        $data['peminjaman'] = Peminjaman::with(['user', 'buku'])->orderBy('tgl_pinjam', 'desc')->get(); [cite: 200]
        return view('peminjaman.index', $data);
    }

    public function create()
    {
        // Ambil data users dan buku untuk dropdown
        $data['users'] = User::all();
        $data['buku'] = Buku::all(); [cite: 208]
        return view('peminjaman.create', $data);
    }

    public function store(Request $request)
    {
        // Validasi
        $this->validate($request, [
            'id_user' => 'required',
            'id_buku' => 'required',
            'tgl_pinjam' => 'required|date',
        ]); [cite: 214]

        // Buat data peminjaman baru
        Peminjaman::create([
            'id_user' => $request->id_user,
            'id_buku' => $request->id_buku,
            'tgl_pinjam' => $request->tgl_pinjam,
            'status' => 'pinjam' // Status default adalah 'pinjam'
        ]); [cite: 215]

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman berhasil ditambahkan');
    }

    /**
     * Di dalam PDF, fungsi edit digunakan sebagai 'action' untuk mengembalikan buku.
     * Kita tidak menampilkan form edit, tapi langsung mengubah status.
     */
    public function edit(string $id)
    {
        $peminjaman = Peminjaman::find($id);

        // Ubah status menjadi 'kembali' dan isi tgl_kembali
        $peminjaman->status = 'kembali';
        $peminjaman->tgl_kembali = now(); // Menggunakan tanggal dan waktu saat ini
        $peminjaman->save(); [cite: 218]

        return redirect()->back()->with('success', 'Buku telah berhasil dikembalikan');
    }

    // Fungsi show, update, dan destroy tidak digunakan sesuai alur PDF,
    // jadi bisa dibiarkan kosong atau dihapus jika resource route tidak diperlukan sepenuhnya.
    public function show(string $id){}
    public function update(Request $request, string $id){}
    public function destroy(string $id){}
}