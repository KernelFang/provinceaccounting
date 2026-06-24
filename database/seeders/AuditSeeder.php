<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Audit;

class AuditSeeder extends Seeder
{
    public function run(): void
    {
        Audit::factory()->count(10)->create();
    }
}
