<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Designation>
 */
class DesignationFactory extends Factory
{
    protected $model = \App\Models\Designation::class;

    public function definition()
    {
        return [
            'title' => $this->faker->unique()->jobTitle(),
            'remarks' => $this->faker->optional()->sentence(),
        ];
    }
}
