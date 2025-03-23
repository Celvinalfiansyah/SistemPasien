<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JadwalKontrol;

class JadwalKontrolSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id_pasien' => 1,
                'tanggal_kontrol' => '2025-03-25',
                'keterangan' => 'Kontrol rutin setelah operasi'
            ],
            [
                'id_pasien' => 2,
                'tanggal_kontrol' => '2025-04-01',
                'keterangan' => 'Evaluasi tekanan darah'
            ]
        ];

        foreach ($data as $jadwal) {
            JadwalKontrol::create($jadwal);
        }
    }
}
