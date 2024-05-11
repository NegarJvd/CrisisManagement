<?php

namespace Database\Factories;

use App\Models\Design;
use App\Models\Machine;
use App\Models\User;
use App\Models\Wood;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Design>
 */
class DesignFactory extends Factory
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
            'snow_load' => fake()->randomNumber(3),
            'wind_load' => fake()->randomNumber(3),
            'earthquake_load' => fake()->randomNumber(3),
            'number_of_households' => fake()->randomNumber(2),
        ];
    }

    public function withWoods(): DesignFactory
    {
        if(Wood::count() <= 0)
            Wood::factory()
                ->count(15)
                ->create();

        return $this->afterCreating(function (Design $design) {
            $woods = Wood::query()->get();
            $design->woods()->attach($woods->random(3));
        });
    }
    public function withMachines(): DesignFactory
    {
        if(Machine::count() <= 0)
            Machine::factory()
                ->count(15)
                ->create();

        return $this->afterCreating(function (Design $design) {
            $machines = Machine::query()->get();
            $design->machines()->attach($machines->random(3));
        });
    }
}
