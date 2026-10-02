<?php

namespace Database\Factories;

use App\Enums\Role as RoleEnum;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Password yang dipakai factory (di-cache agar tidak hash ulang).
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => fn () => self::roleId(RoleEnum::User),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function role(RoleEnum $role): static
    {
        return $this->state(fn (array $attributes) => [
            'role_id' => self::roleId($role),
        ]);
    }

    public function super(): static
    {
        return $this->role(RoleEnum::Super);
    }

    public function admin(): static
    {
        return $this->role(RoleEnum::Admin);
    }

    public function agen(): static
    {
        return $this->role(RoleEnum::Agen);
    }

    /**
     * ID role berdasarkan nama; dibuat jika belum ada (mis. di test tanpa seeder).
     */
    private static function roleId(RoleEnum $role): int
    {
        return Role::firstOrCreate(['name' => $role->value])->id;
    }
}
