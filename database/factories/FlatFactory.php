<?php

namespace Database\Factories;

use App\Models\Flat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Flat>
 */
use App\Models\Project;

class FlatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'building_no' => $this->faker->numerify('B###'),
            'floor_no' => $this->faker->numberBetween(1, 10),
            'flat_no' => $this->faker->bothify('F-###'),
            'total_flat_area_sqft' => $this->faker->randomFloat(2, 300, 2000),
            'cost_per_sqft' => $this->faker->randomFloat(2, 50, 300),
            'base_price' => $this->faker->randomFloat(2, 10000, 500000),
            'is_reselled' => false,
            'client_owner_status' => $this->faker->randomElement(['pending', 'ongoing', 'cancelled', 'completed']),
            'current_owner_id' => null,
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
        ];
    }
}
