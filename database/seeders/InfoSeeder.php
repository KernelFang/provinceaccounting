<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Info;

class InfoSeeder extends Seeder
{
    public function run(): void
    {
        Info::factory()->count(10)->create();
    }
}
