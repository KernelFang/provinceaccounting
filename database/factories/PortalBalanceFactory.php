<?php

namespace Database\Factories;

use App\Models\Info;
use App\Models\Portal;
use App\Models\PortalBalance;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalBalanceFactory extends Factory
{
    protected $model = PortalBalance::class;

    public function definition()
    {
        return [
            'transaction_type' => $this->faker->randomElement(['recharge','withdrawal']),
            'info' => Info::inRandomOrder()->value('name'),
            'date' => $this->faker->date(),
            'portal' => Portal::inRandomOrder()->value('name'),
            'recharge' => $this->faker->randomFloat(2, 0, 1000),
            'sender' => $this->faker->name(),
            'reference' => $this->faker->bothify('REF-#####'),
            'remarks' => $this->faker->sentence(),
        ];
    }
}
