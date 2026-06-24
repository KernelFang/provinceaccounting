<?php

use App\Models\ExpenseType;
use App\Models\PaymentMethod;
use App\Models\Project;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['user_type' => 'superadmin']);
});

test('can create expense type', function () {
    $et = ExpenseType::factory()->create(['created_by' => $this->user->id]);

    $this->assertDatabaseHas('expense_types', [
        'id' => $et->id,
        'name' => $et->name,
    ]);
});

test('can create payment method', function () {
    $pm = PaymentMethod::factory()->create(['created_by' => $this->user->id]);

    $this->assertDatabaseHas('payment_methods', [
        'id' => $pm->id,
        'name' => $pm->name,
    ]);
});

test('can create project', function () {
    $project = Project::factory()->create(['created_by' => $this->user->id]);

    $this->assertDatabaseHas('projects', [
        'id' => $project->id,
        'name' => $project->name,
    ]);
});
