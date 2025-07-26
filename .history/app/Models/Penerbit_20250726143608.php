<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Penerbit extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'penerbit';
    protected $fillable = ['nama_penerbit'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'id_penerbit');
    }
}
