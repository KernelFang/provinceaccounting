<?php

namespace Database\Factories;

use App\Models\TrainingType;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingTypeFactory extends Factory
{
    protected $model = TrainingType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'created_by' => null,
            'updated_by' => null,
        ];
    }
}
