<?php

namespace Database\Factories;

use App\Models\Kabupaten;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kecamatan>
 */
class KecamatanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'kabupaten_id' => Kabupaten::factory(),
            'name' => 'Kecamatan '.fake()->unique()->streetName(),
        ];
    }
}
