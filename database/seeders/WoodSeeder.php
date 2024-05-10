<?php

namespace Database\Seeders;

use App\Models\Wood;
use Illuminate\Database\Seeder;

class WoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wood::factory()
            ->count(20)
            ->create();
    }
}
