<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidan;

class BidanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Yeni Kumala Dewi, S.Keb',
                'no_telepon' => '085749762221',
                'email' => 'yenikumala@gmail.com'
            ],
        ];

        foreach ($data as $bidan) {
            Bidan::create($bidan);
        }
    }
}
