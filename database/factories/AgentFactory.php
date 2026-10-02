<?php

namespace Database\Factories;

use App\Models\Kecamatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->agen(),
            'member_identifier' => (string) Str::ulid(),
            'phone' => fake()->numerify('08##########'),
            'alamat' => fake()->streetAddress(),
            'kecamatan_id' => Kecamatan::factory(),
        ];
    }
}
