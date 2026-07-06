<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        $roleId = Role::query()->where('name', 'staff')->value('id');

        if (! $roleId) {
            $roleId = Role::query()->create([
                'name' => 'staff',
            ])->id;
        }

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->userName().'@gmail.com',
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role_id' => $roleId,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function role(string $roleName): static
    {
        return $this->state(function (array $attributes) use ($roleName) {
            $role = Role::query()->firstOrCreate([
                'name' => $roleName,
            ]);

            return [
                'role_id' => $role->id,
            ];
        });
    }
}
