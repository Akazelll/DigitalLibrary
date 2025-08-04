<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index()
    {

        $users = User::where('role', 'user')
            ->withCount('peminjaman')
            ->orderBy('name', 'asc')
            ->paginate(12);

        return view('user.index', compact('users'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    public function destroy(User $user)
    {

        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user->delete();
        return redirect()->back()->with('success', "Pengguna {$user->name} berhasil dihapus.");
    }

    public function downloadPDF()
    {
        $users = User::where('role', 'user')->withCount('peminjaman')->orderBy('name', 'asc')->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.pdf', compact('users'));
        return $pdf->stream('laporan-data-anggota.pdf');
    }
}
