<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pasien;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RekamMedisKb>
 */
class RekamMedisKbFactory extends Factory
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
            'tanggal_datang' => $this->faker->date(),
            'hpht' => $this->faker->optional()->date(),
            'berat_badan' => $this->faker->optional()->randomFloat(1, 40, 80),
            'tensi' => $this->faker->optional()->numerify('###/##'),
            'komplikasi' => $this->faker->optional()->sentence(),
            'kegagalan' => $this->faker->optional()->sentence(),
            'pemeriksaan_dan_tindakan' => $this->faker->optional()->sentence(),
            'tanggal_kembali' => $this->faker->optional()->date(),
        ];
    }
}
