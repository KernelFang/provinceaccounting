<?php

namespace Database\Seeders;

use App\Models\Flat;
use App\Models\FlatPricingHistory;
use Illuminate\Database\Seeder;

class FlatPricingHistorySeeder extends Seeder
{
    public function run(): void
    {
        $flats = Flat::query()->get();

        foreach ($flats as $flat) {
            FlatPricingHistory::factory()->count(2)->state([
                'flat_id' => $flat->id,
            ])->create();
        }
    }
}
