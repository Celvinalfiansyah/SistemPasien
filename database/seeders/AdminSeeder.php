<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; 
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Intan',
                'email' => 'Intan12@gmail.com',
                'password' => Hash::make('password123'), 
            ],
            [
                'nama' => 'Intan',
                'email' => 'Intan12@gmail.com',
                'password' => Hash::make('password123'), 
            ]
        ];

        foreach ($data as $admin) {
            Admin::create($admin);
        }
    }
}
