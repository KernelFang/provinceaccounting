<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PortalBalance;

class PortalBalanceSeeder extends Seeder
{
    public function run(): void
    {
        PortalBalance::factory()->count(10)->create();
    }
}
