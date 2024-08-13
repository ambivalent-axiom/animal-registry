<?php

namespace Database\Factories;

use App\Models\Farm;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(
        int $userId = null,
        int $farmId = null,
        int $animalNumber = null,
        string $typeName = null,
        int $years = null,
    ): array
    {
        return [
            'user_id' => $userId ?? User::all()->random()->id,
            'farm_id' => $farmId ?? Farm::all()->random()->id,
            'animal_number' => $animalNumber ?? $this->faker->unique()->randomNumber(6, true ),
            'type_name' => $typeName ?? Arr::random(
                [
                    'Sheep',
                    'Cow',
                    'Horse',
                    'Pig',
                    'Chicken',
                    'Cat',
                    'Dog'
                ]
                ),
            'years' => $years ?? $this->faker->randomNumber($nbDigits = 1, $strict = false),
        ];
    }
}
