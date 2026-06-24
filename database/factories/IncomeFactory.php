<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Flat;
use App\Models\Income;
use App\Models\PaymentMethod;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class IncomeFactory extends Factory
{
    protected $model = Income::class;

    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'flat_id' => Flat::factory(),
            'client_id' => Client::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'purpose' => $this->faker->sentence(3),
            'price' => $this->faker->randomFloat(2, 100, 10000),
            'invoice_no' => strtoupper($this->faker->bothify('INV-#######')),
            'clearing_status' => $this->faker->randomElement(['pending', 'cleared', 'bounced']),
            'remarks' => $this->faker->optional()->sentence(),
            'created_by' => User::factory(),
        ];
    }
}
