<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pasien;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedisBayiAnak>
 */
class RekamMedisBayiAnakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'pasien_id' => Pasien::factory(),
            'tanggal_pemeriksaan' => $this->faker->date(),
            'umur' => $this->faker->optional()->randomElement(['6 bulan', '1 tahun', '2 tahun', '3 tahun', '4 tahun', '5 tahun']),
            'berat_badan' => $this->faker->optional()->randomFloat(1, 3, 25),
            'keluhan' => $this->faker->optional()->sentence(),
            'tindakan' => $this->faker->optional()->sentence(),
        ];
    }
}