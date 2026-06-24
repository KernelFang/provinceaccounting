<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Human Resources',
            'Sales',
            'Finance',
            'IT',
            'Operations',
            'Marketing',
        ];

        foreach ($names as $name) {
            Department::firstOrCreate(['name' => $name], ['remarks' => null]);
        }

        // create a few extra random departments
        Department::factory()->count(2)->create();
    }
}
