<?php

namespace Database\Factories;

use App\Enums\WoodTypeEnum;
use App\Models\Wood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Wood>
 */
class WoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'type' => fake()->randomElement(WoodTypeEnum::values())
        ];
    }
}
