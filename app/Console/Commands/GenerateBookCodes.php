<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Buku;
use Illuminate\Support\Str;

class GenerateBookCodes extends Command
{
    protected $signature = 'app:generate-book-codes';
    protected $description = 'Generate unique codes for books that do not have one.';

    public function handle()
    {
        $booksWithoutCode = Buku::whereNull('kode_buku')->get();

        if ($booksWithoutCode->isEmpty()) {
            $this->info('All books already have a code.');
            return 0;
        }

        $this->info("Generating codes for {$booksWithoutCode->count()} books...");

        foreach ($booksWithoutCode as $buku) {
            do {
                $kode = strtoupper(Str::random(3)) . mt_rand(100, 999);
            } while (Buku::where('kode_buku', $kode)->exists());

            $buku->kode_buku = $kode;
            $buku->save();
        }

        $this->info('Successfully generated codes for all books.');
        return 0;
    }
}
