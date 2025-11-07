<?php

namespace Database\Factories;

use App\Models\Pasien;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedisRawatJalan>
 */
class RekamMedisRawatJalanFactory extends Factory
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
            'ttv' => '120/80',
            'anamnesa' => $this->faker->sentence(),
            'tindakan' => 'Pemberian obat'

        ];
    }
}
