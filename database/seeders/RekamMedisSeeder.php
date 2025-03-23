<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RekamMedis;
use App\Models\Pasien;

class RekamMedisSeeder extends Seeder
{
    public function run()
    {
        $pasienIds = Pasien::pluck('id_pasien')->toArray();

        $rekamMedis = [
            [
                'id_pasien' => $pasienIds[0] ?? null,
                'tanggal_periksa' => now()->subDays(10),
                'diagnosa' => 'Hipertensi Stage 1',
                'tindakan' => 'Pemberian obat antihipertensi',
                'resep' => 'Captopril 25mg 3x1, Amlodipine 5mg 1x1'
            ],
            [
                'id_pasien' => $pasienIds[1] ?? null,
                'tanggal_periksa' =>now()->subDays(5),
                'diagnosa' => 'Diabetes Mellitus Tipe 2',
                'tindakan' => 'Kontrol gula darah rutin',
                'resep' => 'Metformin 500mg 2x1, Glibenclamide 5mg 1x1'
            ],
            [
                'id_pasien' => $pasienIds[2] ?? null,
                'tanggal_periksa' => now()->subDays(15),
                'diagnosa' => 'Infeksi Saluran Pernapasan Akut',
                'tindakan' => 'Pemberian antibiotik dan istirahat',
                'resep' => 'Amoxicillin 500mg 3x1, Paracetamol 500mg 3x1'
            ],
            [
                'id_pasien' => $pasienIds[3] ?? null,
                'tanggal_periksa' =>now()->subDays(20),
                'diagnosa' => 'Gastritis',
                'tindakan' => 'Pengaturan pola makan dan pemberian obat',
                'resep' => 'Omeprazole 20mg 1x1, Antasida 3x1'
            ],
            [
                'id_pasien' => $pasienIds[4] ?? null,
                'tanggal_periksa' => now()->subDays(7),
                'diagnosa' => 'Asam Lambung',
                'tindakan' => 'Rawat inap dan pemberian cairan',
                'resep' => 'Infus Ringer Laktat, Paracetamol 500mg 3x1'
            ],
        ];

        foreach ($rekamMedis as $data) {
            if ($data['id_pasien']) {
                RekamMedis::create($data);
            }
        }
    }
}
