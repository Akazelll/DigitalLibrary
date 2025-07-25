<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
us

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $fillable = ['id_user', 'id_buku', 'tgl_pinjam', 'tanggal_harus_kembali', 'tgl_kembali', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku');
    }
    protected function isOverdue(): Attribute
    {
        return Attribute::make(
            get: fn() => now()->gt($this->tanggal_harus_kembali) && $this->status == 'pinjam'
        );
    }
}
