<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;
    protected $table = 'buku';
    protected $fillable = ['judul_buku', 'id_penerbit', 'tahun_terbit', 'jml_halaman'];

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'id_penerbit');
    }
}
