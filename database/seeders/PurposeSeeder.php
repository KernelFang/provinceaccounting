<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purpose;

class PurposeSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'International Tour',
            'Local Tour',
            'Hotel / Resort Booking',
            'Car / Bus Booking',
        ];

        foreach ($names as $name) {
            Purpose::firstOrCreate(['name' => $name]);
        }
    }
}
