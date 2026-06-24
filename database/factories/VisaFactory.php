<?php

namespace Database\Factories;

use App\Models\Visa;
use App\Models\Country;
use App\Models\VisaPurpose;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisaFactory extends Factory
{
    protected $model = Visa::class;

    public function definition()
    {
        return [
            'purpose' => VisaPurpose::inRandomOrder()->value('name'),
            'country' => Country::inRandomOrder()->value('name'),
            'description' => $this->faker->paragraph(),
            'from_date' => $this->faker->date(),
            'to_date' => $this->faker->date(),
            'customer' => $this->faker->name(),
            'person' => $this->faker->numberBetween(1, 4),
            'mobile_number' => $this->faker->phoneNumber(),
            'emergency_number' => $this->faker->phoneNumber(),
            'agent_cost' => $this->faker->randomFloat(2, 0, 1000),
            'customer_price' => $this->faker->randomFloat(2, 0, 3000),
            'customer_payment' => $this->faker->randomFloat(2, 0, 3000),
            'customer_due' => 0,
            'profit' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
