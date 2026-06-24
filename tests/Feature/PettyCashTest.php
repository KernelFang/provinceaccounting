<?php

use App\Models\PettyCash;
use App\Models\User;
use Carbon\Carbon;

beforeEach(function () {
    $this->user = User::factory()->create(['user_type' => 'superadmin']);
});

test('authorized user can view petty cash index', function () {
    $response = $this->actingAs($this->user)->get(route('petty-cashes.index'));

    $response->assertStatus(200);
});

test('authorized user can create a petty cash entry', function () {
    $payload = [
        'title' => 'New petty cash deposit',
        'transaction_type' => 'credit_manual',
        'amount' => '500.00',
        'current_balance' => '500.00',
        'expense_id' => null,
        'date' => Carbon::today()->toDateString(),
        'description' => 'Initial float',
    ];

    $response = $this->actingAs($this->user)->post(route('petty-cashes.store'), $payload);

    $response->assertRedirect(route('petty-cashes.index'));
    $this->assertDatabaseHas('petty_cashes', [
        'title' => 'New petty cash deposit',
        'transaction_type' => 'credit_manual',
        'amount' => '500.00',
        'current_balance' => '500.00',
        'description' => 'Initial float',
    ]);
});

test('petty cash entry can be updated', function () {
    $pettyCash = PettyCash::factory()->create([
        'created_by' => $this->user->id,
        'transaction_type' => 'credit_manual',
        'amount' => '100.00',
        'current_balance' => '100.00',
        'date' => Carbon::today(),
    ]);

    $payload = [
        'title' => 'Updated petty cash deposit',
        'transaction_type' => 'credit_manual',
        'amount' => '150.00',
        'current_balance' => '150.00',
        'expense_id' => null,
        'date' => Carbon::today()->toDateString(),
        'description' => 'Adjusted amount',
    ];

    $response = $this->actingAs($this->user)->put(route('petty-cashes.update', $pettyCash), $payload);

    $response->assertRedirect(route('petty-cashes.index'));
    $this->assertDatabaseHas('petty_cashes', [
        'id' => $pettyCash->id,
        'title' => 'Updated petty cash deposit',
        'amount' => '150.00',
        'current_balance' => '150.00',
        'description' => 'Adjusted amount',
    ]);
});

test('petty cash entry can be soft deleted', function () {
    $pettyCash = PettyCash::factory()->create([
        'created_by' => $this->user->id,
        'transaction_type' => 'credit_manual',
        'amount' => '200.00',
        'current_balance' => '200.00',
        'date' => Carbon::today(),
    ]);

    $response = $this->actingAs($this->user)->delete(route('petty-cashes.destroy', $pettyCash));

    $response->assertRedirect(route('petty-cashes.index'));
    $this->assertSoftDeleted('petty_cashes', [
        'id' => $pettyCash->id,
    ]);
});

test('petty cash totals reflect added entries and expense usage entries', function () {
    PettyCash::factory()->create([
        'created_by' => $this->user->id,
        'transaction_type' => 'credit_manual',
        'amount' => '500.00',
        'current_balance' => '500.00',
        'date' => Carbon::today(),
    ]);

    PettyCash::factory()->create([
        'created_by' => $this->user->id,
        'transaction_type' => 'credit_manual',
        'amount' => '325.75',
        'current_balance' => '825.75',
        'date' => Carbon::today(),
    ]);

    PettyCash::factory()->create([
        'created_by' => $this->user->id,
        'transaction_type' => 'debit_expense',
        'amount' => '120.50',
        'current_balance' => '705.25',
        'date' => Carbon::today(),
    ]);

    expect(PettyCash::totalAdded())->toBe(825.75);
    expect(PettyCash::totalUsed())->toBe(120.50);
    expect(PettyCash::balance())->toBe(705.25);
});
