<?php

use App\Models\Expense;
use App\Models\ExpenseType;
use App\Models\Flat;
use App\Models\PaymentMethod;
use App\Models\PettyCash;
use App\Models\Project;
use App\Models\User;
use Database\Seeders\ExpenseSeeder;

function expensePettyCashContext(float $initialBalance = 1000): array
{
    $user = User::factory()->create([
        'user_type' => 'superadmin',
        'email_verified_at' => now(),
    ]);

    $project = Project::factory()->create();
    $flat = Flat::factory()->create([
        'project_id' => $project->id,
    ]);
    $expenseType = ExpenseType::factory()->create();
    $paymentMethod = PaymentMethod::factory()->create();

    PettyCash::factory()->create([
        'created_by' => $user->id,
        'transaction_type' => 'credit_manual',
        'amount' => number_format($initialBalance, 2, '.', ''),
        'current_balance' => number_format($initialBalance, 2, '.', ''),
        'date' => now()->toDateString(),
    ]);

    return compact('user', 'project', 'flat', 'expenseType', 'paymentMethod');
}

test('expenses can be created without a project and with a title', function () {
    $context = expensePettyCashContext();

    $storePayload = [
        'title' => 'Office Supplies',
        'project_id' => null,
        'expense_type_id' => $context['expenseType']->id,
        'flat_id' => $context['flat']->id,
        'payment_method_id' => $context['paymentMethod']->id,
        'date' => now()->toDateString(),
        'expense_details' => 'Office supplies',
        'amount' => '250.00',
        'transaction_reference' => 'EXP-NULL-PROJECT',
        'payment_status' => 'paid',
    ];

    $this->actingAs($context['user'])
        ->post(route('expenses.store'), $storePayload)
        ->assertRedirect(route('expenses.index'));

    $expense = Expense::where('transaction_reference', 'EXP-NULL-PROJECT')->firstOrFail();

    expect($expense->title)->toBe('Office Supplies');
    expect($expense->project_id)->toBeNull();
});

test('petty cash expenses create update and delete ledger entries', function () {
    $context = expensePettyCashContext();

    $storePayload = [
        'title' => 'Petty Cash Expense',
        'project_id' => $context['flat']->project_id,
        'expense_type_id' => $context['expenseType']->id,
        'flat_id' => $context['flat']->id,
        'payment_method_id' => $context['paymentMethod']->id,
        'date' => now()->toDateString(),
        'expense_details' => 'Office supplies',
        'amount' => '250.00',
        'transaction_reference' => 'EXP-PC-001',
        'payment_status' => 'petty_cash',
    ];

    $this->actingAs($context['user'])->post(route('expenses.store'), $storePayload)->assertRedirect(route('expenses.index'));

    $expense = Expense::where('transaction_reference', 'EXP-PC-001')->firstOrFail();

    expect(PettyCash::where('expense_id', $expense->id)->where('transaction_type', 'debit_expense')->count())->toBe(1);
    expect(PettyCash::balance())->toBe(750.00);

    $updatePayload = [
        'title' => 'Petty Cash Expense Updated',
        'project_id' => $context['flat']->project_id,
        'expense_type_id' => $context['expenseType']->id,
        'flat_id' => $context['flat']->id,
        'payment_method_id' => $context['paymentMethod']->id,
        'date' => now()->toDateString(),
        'expense_details' => 'Office supplies updated',
        'amount' => '300.00',
        'transaction_reference' => 'EXP-PC-001',
        'payment_status' => 'petty_cash',
    ];

    $this->actingAs($context['user'])->put(route('expenses.update', $expense), $updatePayload)->assertRedirect(route('expenses.index'));

    $expense->refresh();

    expect(PettyCash::where('expense_id', $expense->id)->where('transaction_type', 'debit_expense')->count())->toBe(1);
    expect(PettyCash::where('expense_id', $expense->id)->value('amount'))->toBe('300.00');
    expect(PettyCash::balance())->toBe(700.00);

    $this->actingAs($context['user'])->delete(route('expenses.destroy', $expense))->assertRedirect(route('expenses.index'));

    expect(PettyCash::where('expense_id', $expense->id)->count())->toBe(0);
    expect(PettyCash::balance())->toBe(1000.00);
});

test('expense seeder creates petty cash debit entries', function () {
    $context = expensePettyCashContext(5000);

    $project = Project::factory()->create();

    Flat::factory()->create([
        'project_id' => $project->id,
    ]);

    ExpenseType::factory()->create();
    PaymentMethod::factory()->create();

    $this->seed(ExpenseSeeder::class);

    $pettyCashExpense = Expense::where('payment_status', 'petty_cash')->first();

    expect($pettyCashExpense)->not->toBeNull();
    expect(PettyCash::where('expense_id', $pettyCashExpense->id)->where('transaction_type', 'debit_expense')->exists())->toBeTrue();
    expect(PettyCash::balance())->toBeLessThan(5000.00);
});

test('expense form submits the expected details field and includes petty cash option', function () {
    $user = User::factory()->create([
        'user_type' => 'superadmin',
        'email_verified_at' => now(),
    ]);

    $this->actingAs($user)
        ->get(route('expenses.create'))
        ->assertOk()
        ->assertSee('name="expense_details"', false)
        ->assertSee('name="payment_method_id"', false)
        ->assertSee('name="transaction_reference"', false)
        ->assertSee('value="petty_cash"', false);
});
