<?php

namespace Database\Factories;

use App\Models\TimberSupply;
use App\Models\User;
use App\Models\Wood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TimberSupply>
 */
class TimberSupplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'latitude' => fake()->latitude,
            'longitude' => fake()->longitude,
            'radius' => rand(1, 1000)
        ];
    }

    public function withWoods(): TimberSupplyFactory
    {
        if(Wood::count() <= 0)
            Wood::factory()
                ->count(15)
                ->create();

        return $this->afterCreating(function (TimberSupply $timberSupply) {
            $woods = Wood::query()->get();
            $timberSupply->woods()->attach($woods->random(3));
        });
    }
}
