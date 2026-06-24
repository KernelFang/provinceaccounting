<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VisaPurpose;

class VisaPurposeSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Student Consultancy',
            'Career Consultancy',
            'Umrah Hajj',
            'Hajj',
        ];

        foreach ($names as $name) {
            VisaPurpose::firstOrCreate(['name' => $name]);
        }
    }
}
