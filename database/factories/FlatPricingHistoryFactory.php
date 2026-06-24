<?php

namespace Database\Factories;

use App\Models\FlatPricingHistory;
use App\Models\Flat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlatPricingHistoryFactory extends Factory
{
    protected $model = FlatPricingHistory::class;

    public function definition(): array
    {
        return [
            'flat_id' => Flat::factory(),
            'price' => $this->faker->randomFloat(2, 1000, 500000),
            'effective_date' => $this->faker->date(),
            'changed_by' => User::factory(),
            'remarks' => $this->faker->optional()->sentence(),
        ];
    }
}
