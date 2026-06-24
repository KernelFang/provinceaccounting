<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $departments = Department::all();
        $designations = Designation::all();

        if ($departments->isEmpty()) {
            Department::factory()->count(5)->create();
            $departments = Department::all();
        }

        if ($designations->isEmpty()) {
            Designation::factory()->count(5)->create();
            $designations = Designation::all();
        }

        for ($i = 0; $i < 30; $i++) {
            $dept = $departments->random();
            $desig = $designations->random();

            Employee::factory()->create([
                'department_id' => $dept->id,
                'designation_id' => $desig->id,
            ]);
        }
    }
}
