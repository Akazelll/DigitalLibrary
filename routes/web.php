<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Tambahkan use statement untuk controller-controller kita
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Grup rute ini memastikan hanya user yang sudah login yang bisa mengaksesnya
Route::middleware('auth')->group(function () {
    // Rute untuk profil user bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ================================================================
    // === DEFINISI ROUTE UNTUK APLIKASI PERPUSTAKAAN - LETAKKAN DI SINI ===
    // ================================================================
    // Route::resource secara otomatis membuat semua rute yang diperlukan
    // untuk operasi CRUD (index, create, store, edit, update, destroy).
    Route::resource('penerbit', PenerbitController::class);
    Route::resource('buku', BukuController::class);
    Route::resource('peminjaman', PeminjamanController::class);
    // ================================================================

});

// Rute ini memanggil file auth.php yang berisi rute login, register, dll dari Breeze
require __DIR__.'/auth.php';