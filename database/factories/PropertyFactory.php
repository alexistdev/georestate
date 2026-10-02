<?php

namespace Database\Factories;

use App\Enums\PropertyStatus;
use App\Models\Agent;
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
            'agent_id' => Agent::factory(),
            'name' => fake()->sentence(3),
            'kecamatan_id' => Kecamatan::factory(),
            'kategori_id' => Kategori::factory(),
            'address' => fake()->streetAddress(),
            'description' => fake()->paragraph(),
            'beds' => fake()->numberBetween(1, 5),
            'baths' => fake()->numberBetween(1, 3),
            'lb' => fake()->numberBetween(20, 200),
            'lt' => fake()->numberBetween(30, 300),
            'harga_bulanan' => fake()->numberBetween(5, 100) * 100000,
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Approved,
            'approved_at' => now(),
        ]);
    }

    public function rejected(string $alasan = 'Foto tidak jelas'): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => PropertyStatus::Rejected,
            'alasan_penolakan' => $alasan,
        ]);
    }
}
