<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            // Tambahkan kolom stok setelah 'jml_halaman'
            $table->integer('stok')->unsigned()->default(0)->after('jml_halaman');
        });
    }

    public function down(): void
    {
        Schema::table('buku', function (Blueprint $table) {
            // Hapus kolom stok jika migrasi di-rollback
            $table->dropColumn('stok');
        });
    }
};