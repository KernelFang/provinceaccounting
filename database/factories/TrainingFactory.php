<?php

namespace Database\Factories;

use App\Models\Training;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrainingFactory extends Factory
{
    protected $model = Training::class;

    public function definition()
    {
        $price = $this->faker->randomFloat(2, 50, 2000);
        $payment = $this->faker->randomFloat(2, 0, $price);
        return [
            'training_type' => $this->faker->word(),
            'title' => $this->faker->sentence(3),
            'customer_name' => $this->faker->name(),
            'customer_number' => $this->faker->phoneNumber(),
            'package' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'agent_cost' => $this->faker->randomFloat(2, 0, 1000),
            'customer_price' => $price,
            'customer_payment' => $payment,
            'customer_due' => $price - $payment,
            'purchase_date' => $this->faker->date(),
        ];
    }
}
