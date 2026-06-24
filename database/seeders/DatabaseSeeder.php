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
            EmployeeSeeder::class,
            CountrySeeder::class,
            AirlineSeeder::class,
            FlightTypeSeeder::class,
            PortalSeeder::class,
            ServiceTypeSeeder::class,
            PurposeSeeder::class,
            VisaPurposeSeeder::class,
            InfoSeeder::class,
            TripSeeder::class,
            VisaSeeder::class,
            PortalBalanceSeeder::class,
            PettyCashSeeder::class,
            ExpenseSeeder::class,
            SaleSeeder::class,
            TourSeeder::class,
            TrainingSeeder::class,
            AuditSeeder::class,
            ClientSeeder::class,
            ExpenseTypeSeeder::class,
            FlatSeeder::class,
            FlatPricingHistorySeeder::class,
            IncomeSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
