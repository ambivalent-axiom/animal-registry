<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(
        User $user = null,
        string $name = null,
        string $email = null,
        string $website = null,
    ): array
    {
        return [
            'user_id' => $user ?? User::factory(),
            'name' => $name ?? $this->faker->name(),
            'email' => $email ?? $this->faker->unique()->safeEmail(),
            'website' => $website ?? $this->faker->url(),
        ];
    }
}
