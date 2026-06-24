<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Designation;

class DesignationSeeder extends Seeder
{
    public function run(): void
    {
        $titles = [
            'Manager',
            'Senior Manager',
            'Executive',
            'Officer',
            'Intern',
        ];

        foreach ($titles as $title) {
            Designation::firstOrCreate(['title' => $title], ['remarks' => null]);
        }

        Designation::factory()->count(2)->create();
    }
}
