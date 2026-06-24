<?php

namespace Database\Factories;

use App\Models\Purpose;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurposeFactory extends Factory
{
    protected $model = Purpose::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word()),
        ];
    }
}
