<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pasien>
 */
class PasienFactory extends Factory
{

    

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_pasien' => $this->faker->firstName() . ' ' . $this->faker->lastName(), // Membatasi panjang nama
            'tanggal_lahir' => $this->faker->dateTimeBetween('-50 years', '-1 year')->format('Y-m-d'),
            'jenis_kelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'alamat' => $this->faker->address(),
            'no_telepon' => $this->faker->numerify('08##########'), // Memastikan panjang maks 15 dan string
            'tanggal_daftar' => $this->faker->dateTimeThisMonth(), // Menggunakan data date yang bervariasi
            // PENTING: Disesuaikan dengan validasi 'nullable|in:rawat_jalan,bayi_anak,kb'
            'jenis_pasien' => $this->faker->randomElement(['rawat_jalan', 'bayi_anak', 'kb']), 
        ];
    }
}
