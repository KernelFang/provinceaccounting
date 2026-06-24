<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {

        // // Get a user to act as the "logged-in" user for seeding
        // $user = User::first(); // Or create a Super Admin if needed
        // auth()->login($user); // Log in the user temporarily
        // Expense::factory()->count(100)->create(); // Seed expenses normally — audits will now work
        // auth()->logout(); // Log out the fake user after seeding

        // Disable events when seeding (recommended)
        Expense::withoutEvents(function () {
            Expense::factory()->count(100)->create();
        });
    }
}
