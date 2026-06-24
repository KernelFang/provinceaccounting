<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visa;

class VisaSeeder extends Seeder
{
    public function run(): void
    {
        Visa::factory()->count(10)->create();
    }
}
