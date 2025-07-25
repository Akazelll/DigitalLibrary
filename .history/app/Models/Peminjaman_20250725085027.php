<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute; // <-- KESALAHAN ADA DI SINI, PERLU DITAMBAHKAN

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    const DENDA_PER_HARI = 1000;
    protected $fillable = ['id_user', 'id_buku', 'tgl_pinjam', 'tanggal_harus_kembali', 'tgl_kembali', 'status', 'denda'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function buku()
    {
        // PENINGKATAN: Tambahkan withTrashed() agar relasi tidak rusak jika buku di-soft delete
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
                // Jika sudah dikembalikan dan ada denda tercatat, tampilkan denda tersebut
                if ($this->status == 'kembali' && $this->denda > 0) {
                    return $this->denda;
                }

                // Jika masih dipinjam dan terlambat, hitung potensi denda saat ini
                if ($this->is_overdue) {
                    $tanggalHarusKembali = \Carbon\Carbon::parse($this->tanggal_harus_kembali);
                    // diffInDays() menghitung selisih hari
                    $hariTerlambat = now()->diffInDays($tanggalHarusKembali);
                    return $hariTerlambat * self::DENDA_PER_HARI;
                }

                return 0; // Tidak ada denda
            }
        );
    }
}
