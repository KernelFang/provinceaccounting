<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flat;

class FlatSeeder extends Seeder
{
    public function run(): void
    {
        Flat::factory()->count(20)->create();
    }
}
