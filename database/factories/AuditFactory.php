<?php

namespace Database\Factories;

use App\Models\Audit;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditFactory extends Factory
{
    protected $model = Audit::class;

    public function definition()
    {
        return [
            'auditable_id' => $this->faker->numberBetween(1, 10),
            'auditable_type' => $this->faker->randomElement([\App\Models\User::class, \App\Models\Expense::class]),
            'action' => $this->faker->randomElement(['create','update','delete']),
            'old_values' => json_encode([]),
            'new_values' => json_encode([]),
            'user_id' => $this->faker->numberBetween(10001, 10005),
            'ip_address' => $this->faker->ipv4(),
        ];
    }
}
