<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PettyCash;

class PettyCashSeeder extends Seeder
{
    public function run(): void
    {
        PettyCash::factory()->count(15)->create();
    }
}
