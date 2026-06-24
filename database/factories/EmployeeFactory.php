<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = \App\Models\Employee::class;

    public function definition()
    {
        $name = $this->faker->name();
        return [
            'employee_code' => 'EMP' . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $name,
            'gender' => $this->faker->randomElement(['male','female','other']),
            'father_name' => $this->faker->name(),
            'mother_name' => $this->faker->name(),
            'spouse_name' => $this->faker->optional(0.3)->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'nid' => $this->faker->bothify('###########'),
            'dob' => $this->faker->date('Y-m-d', '-30 years'),
            'address' => $this->faker->address(),
            'permanent_address' => $this->faker->address(),
            'joining_date' => $this->faker->date('Y-m-d', '-5 years'),
            'exit_date' => $this->faker->optional(0.2)->date('Y-m-d', 'now'),
            'status' => $this->faker->randomElement(['active','inactive','terminated']),
            'employment_type' => $this->faker->randomElement(['permanent','contract','temporary','intern']),
            'assigned_assets' => $this->faker->optional()->sentence(),
            'remarks' => $this->faker->optional()->sentence(),
            'department_id' => \App\Models\Department::factory(),
            'designation_id' => \App\Models\Designation::factory(),
        ];
    }
}
