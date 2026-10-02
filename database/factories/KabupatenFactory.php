<?php

namespace Database\Factories;

use App\Models\Provinsi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kabupaten>
 */
class KabupatenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'provinsi_id' => Provinsi::factory(),
            'name' => 'Kabupaten '.fake()->unique()->city(),
        ];
    }
}
