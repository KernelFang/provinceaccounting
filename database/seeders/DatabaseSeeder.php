<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            PaymentMethodSeeder::class,
            ExpenseTypeSeeder::class,
            EmployeeSeeder::class,
            CountrySeeder::class,
            PettyCashSeeder::class,
            AuditSeeder::class,
            ProjectSeeder::class,
            ClientSeeder::class,
            FlatSeeder::class,
            FlatPricingHistorySeeder::class,
            IncomeSeeder::class,
            ExpenseSeeder::class,
        ]);
    }
}
