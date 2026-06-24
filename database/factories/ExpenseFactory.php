<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\PaymentMethod;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'expense_type_id' => ExpenseType::factory(),
            'flat_id' => null,
            'payment_method_id' => PaymentMethod::factory(),
            'date' => $this->faker->date(),
            'expense_details' => $this->faker->sentence(),
            'amount' => $this->faker->randomFloat(2, 10, 2000),
            'transaction_reference' => strtoupper(Str::random(12)),
            'created_by' => User::factory(),
        ];
    }
}
