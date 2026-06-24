<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = \App\Models\Department::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'remarks' => $this->faker->optional()->sentence(),
        ];
    }
}
