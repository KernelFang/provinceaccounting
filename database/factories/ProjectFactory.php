<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'location' => $this->faker->city(),
            'status' => $this->faker->randomElement(['pending', 'ongoing', 'cancelled', 'completed']),
            'created_by' => null,
            'updated_by' => null,
            'deleted_by' => null,
        ];
    }
}
