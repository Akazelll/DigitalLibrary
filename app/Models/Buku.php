<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'buku';
    protected $fillable = ['judul_buku', 'id_penerbit', 'kategori_id', 'tahun_terbit', 'jml_halaman', 'stok', 'sampul'];

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}