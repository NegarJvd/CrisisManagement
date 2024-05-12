<?php

namespace Database\Seeders;

use App\Models\TimberSupply;
use Illuminate\Database\Seeder;

class TimberSupplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TimberSupply::factory()
            ->count(20)
            ->withWoods()
            ->create();
    }
}
