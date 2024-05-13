<?php

namespace Database\Seeders;

use App\Models\CNCSupply;
use Illuminate\Database\Seeder;

class CNCSupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CNCSupply::factory()
            ->count(20)
            ->withMachines()
            ->create();
    }
}
