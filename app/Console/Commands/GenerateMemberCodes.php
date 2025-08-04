<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class GenerateMemberCodes extends Command
{
    protected $signature = 'app:generate-member-codes';
    protected $description = 'Generate unique member codes for users who do not have one.';

    public function handle()
    {
        $usersWithoutCode = User::whereNull('kode_anggota')->get();

        if ($usersWithoutCode->isEmpty()) {
            $this->info('All users already have a member code.');
            return 0;
        }

        $this->info("Generating member codes for {$usersWithoutCode->count()} users...");

        foreach ($usersWithoutCode as $user) {
            do {
                $kode = mt_rand(100000, 999999);
            } while (User::where('kode_anggota', $kode)->exists());

            $user->kode_anggota = $kode;
            $user->save();
        }

        $this->info('Successfully generated member codes for all users.');
        return 0;
    }
}