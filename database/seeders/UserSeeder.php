<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Only create admin if there are no users
        if (User::count() === 0) {
            User::factory()->create([
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'email' => 'superadmin@genztravels.test',
                'password' => bcrypt('Secret1234'),
                'user_type' => 'superadmin',
                'contact' => '0000000000',
            ]);

            User::factory()->create([
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@genztravels.test',
                'password' => bcrypt('Secret1234'),
                'user_type' => 'admin',
                'contact' => '0000000000',
            ]);

            User::factory()->create([
                'name' => 'Staff',
                'username' => 'staff',
                'email' => 'staff@genztravels.test',
                'password' => bcrypt('Secret1234'),
                'user_type' => 'staff',
                'contact' => '0000000000',
            ]);

            // Create 5 more random users
            User::factory()->count(5)->create();
        }
    }
}
