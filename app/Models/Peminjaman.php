<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    const DENDA_PER_HARI = 5000;
    protected $fillable = ['id_user', 'id_buku', 'tgl_pinjam', 'tanggal_harus_kembali', 'tgl_kembali', 'status', 'denda'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'id_buku')->withTrashed();
    }

    protected function isOverdue(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->tanggal_harus_kembali || $this->status !== 'pinjam') {
                    return false;
                }
                return now()->gt($this->tanggal_harus_kembali);
            }
        );
    }

    protected function dendaTerhitung(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->status == 'kembali' && $this->denda > 0) {
                    return $this->denda;
                }

                if ($this->is_overdue) {

                    $tanggalHarusKembali = \Carbon\Carbon::parse($this->tanggal_harus_kembali)->startOfDay();
                    $sekarang = now()->startOfDay();

                    $hariTerlambat = $sekarang->diffInDays($tanggalHarusKembali);
                    return $hariTerlambat * self::DENDA_PER_HARI;
                }

                return 0;
            }
        );
    }
}
