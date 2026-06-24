<?php

namespace Database\Factories;

use App\Models\Airline;
use Illuminate\Database\Eloquent\Factories\Factory;

class AirlineFactory extends Factory
{
    protected $model = Airline::class;

    public function definition()
    {
        return [
            'name' => $this->faker->company(),
        ];
    }
}
