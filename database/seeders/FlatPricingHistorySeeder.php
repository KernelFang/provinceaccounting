<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FlatPricingHistory;

class FlatPricingHistorySeeder extends Seeder
{
    public function run(): void
    {
        FlatPricingHistory::factory()->count(30)->create();
    }
}
