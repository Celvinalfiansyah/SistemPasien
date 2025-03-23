<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PasienSeeder extends Seeder
{
    public function run()
    {
        DB::table('Pasien')->insert([
            [
                'nama_pasien' => 'Zakia',
                'tanggal_lahir' => '2009-05-15',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Merdeka No. 10, Banyuwamgi',
                'no_telepon' => '081234567890',
                'tanggal_daftar' => now(),
            ],
            [
                'nama_pasien' => 'Firly',
                'tanggal_lahir' => '2000-08-20',
                'jenis_kelamin' => 'Perempuan',
                'alamat' => 'Jl. Kemerdekaan No. 20, Banyuwangi',
                'no_telepon' => '081298765432',
                'tanggal_daftar' => now(),
            ],
            [
                'nama_pasien' => 'Adit',
                'tanggal_lahir' => '2003-01-10',
                'jenis_kelamin' => 'Laki-laki',
                'alamat' => 'Jl. Diponegoro No. 5, Banyuwangi',
                'no_telepon' => '081277788899',
                'tanggal_daftar' => now(),
            ]
        ]);
    }
}
