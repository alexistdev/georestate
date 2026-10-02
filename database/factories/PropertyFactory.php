<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Kecamatan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Property>
 */
class PropertyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(3),
            'kecamatan_id' => Kecamatan::factory(),
            'kategori_id' => Kategori::factory(),
            'address' => fake()->streetAddress(),
            'description' => fake()->paragraph(),
            'beds' => fake()->numberBetween(1, 5),
            'baths' => fake()->numberBetween(1, 3),
            'lb' => fake()->numberBetween(20, 200),
            'lt' => fake()->numberBetween(30, 300),
            'price' => fake()->numberBetween(5, 100) * 100000,
        ];
    }
}
