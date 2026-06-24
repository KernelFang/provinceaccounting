<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        $name = $this->faker->name();
        $username = Str::slug($name) . $this->faker->numberBetween(1, 999);
        return [
            'name' => $name,
            'username' => $username,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'contact' => $this->faker->phoneNumber(),
            'user_type' => 'staff',
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'address' => $this->faker->address(),
            'date_of_birth' => $this->faker->date(),
            'joining_date' => $this->faker->date(),
            'about_me' => $this->faker->paragraph(),
        ];
    }

    /**
     * Indicate that the user's email address should be unverified.
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
