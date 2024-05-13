<?php

namespace Database\Factories;

use App\Models\CNCSupply;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CNCSupply>
 */
class CNCSupplyFactory extends Factory
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

    public function withMachines(): CNCSupplyFactory
    {
        if(Machine::count() <= 0)
            Machine::factory()
                ->count(15)
                ->create();

        return $this->afterCreating(function (CNCSupply $CNCSupply) {
            $machines = Machine::query()->get();
            $CNCSupply->machines()->attach($machines->random(3));
        });
    }
}
