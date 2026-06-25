<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Flat;
use App\Models\PaymentMethod;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::query()->get();
        $expenseTypes = ExpenseType::query()->get();
        $paymentMethods = PaymentMethod::query()->get();

        if ($projects->isEmpty() || $expenseTypes->isEmpty() || $paymentMethods->isEmpty()) {
            return;
        }

        $flats = Flat::query()->get();

        foreach ($projects as $project) {
            foreach ($expenseTypes->take(3)->values() as $index => $expenseType) {
                $flat = $flats->where('project_id', $project->id)->random();

                Expense::factory()->state([
                    'project_id' => $project->id,
                    'expense_type_id' => $expenseType->id,
                    'flat_id' => $flat?->id,
                    'payment_method_id' => $paymentMethods->random()->id,
                    'payment_status' => $index === 0 ? 'petty_cash' : ($index === 1 ? 'paid' : 'unpaid'),
                ])->create();
            }
        }
    }
}
