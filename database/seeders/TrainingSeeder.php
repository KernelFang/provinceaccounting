<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Training;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        Training::factory()->count(5)->create();
    }
}
