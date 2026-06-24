<?php

namespace Database\Factories;

use App\Models\VisaPurpose;
use Illuminate\Database\Eloquent\Factories\Factory;

class VisaPurposeFactory extends Factory
{
    protected $model = VisaPurpose::class;

    public function definition()
    {
        return [
            'name' => ucfirst($this->faker->word()),
        ];
    }
}
