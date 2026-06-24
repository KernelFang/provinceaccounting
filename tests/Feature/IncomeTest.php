<?php

use App\Models\Income;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['user_type' => 'superadmin']);
});

test('can create income', function () {
    $income = Income::factory()->create(['created_by' => $this->user->id]);

    $this->assertDatabaseHas('incomes', [
        'id' => $income->id,
        'price' => $income->price,
    ]);
});

test('can update income', function () {
    $income = Income::factory()->create(['created_by' => $this->user->id]);

    $income->update(['remarks' => 'Updated remarks']);

    $this->assertDatabaseHas('incomes', [
        'id' => $income->id,
        'remarks' => 'Updated remarks',
    ]);
});

test('income can be soft deleted', function () {
    $income = Income::factory()->create(['created_by' => $this->user->id]);

    $income->delete();

    $this->assertSoftDeleted('incomes', [
        'id' => $income->id,
    ]);
});
