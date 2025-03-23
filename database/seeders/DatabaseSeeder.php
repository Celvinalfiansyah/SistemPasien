<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            BidanSeeder::class,
            JadwalKontrolSeeder::class,
            PasienSeeder::class,
            RekamMedisSeeder::class,

        ]);
    }
}
