<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\PettyCash;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PettyCashFactory extends Factory
{
    protected $model = PettyCash::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'transaction_type' => $this->faker->randomElement(['credit_manual', 'debit_expense']),
            'amount' => $this->faker->randomFloat(2, 1, 500),
            'current_balance' => $this->faker->randomFloat(2, 500, 2000),
            'expense_id' => null,
            'description' => $this->faker->sentence(),
            'date' => $this->faker->date(),
            'created_by' => User::factory(),
            'updated_by' => null,
            'deleted_by' => null,
        ];
    }
}
