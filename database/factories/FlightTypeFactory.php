<?php

namespace Database\Factories;

use App\Models\FlightType;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightTypeFactory extends Factory
{
    protected $model = FlightType::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
