<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlightType;

class FlightTypeSeeder extends Seeder
{
    public function run(): void
    {
        FlightType::factory()->count(5)->create();
    }
}
