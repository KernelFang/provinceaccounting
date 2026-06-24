<?php

namespace Database\Factories;

use App\Models\Info;
use Illuminate\Database\Eloquent\Factories\Factory;

class InfoFactory extends Factory
{
    protected $model = Info::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
