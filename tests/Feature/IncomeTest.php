<?php

use App\Models\Client;
use App\Models\Flat;
use App\Models\Income;
use App\Models\PaymentMethod;
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

test('can create income without a project and invoice number', function () {
    $flat = Flat::factory()->create();
    $client = Client::factory()->create();
    $paymentMethod = PaymentMethod::factory()->create();

    $this->actingAs($this->user)
        ->post(route('incomes.store'), [
            'project_id' => '',
            'flat_id' => $flat->id,
            'client_id' => $client->id,
            'payment_method_id' => $paymentMethod->id,
            'purpose' => 'Test purpose',
            'price' => '100.50',
            'invoice_no' => '',
            'clearing_status' => 'pending',
            'remarks' => 'Test remarks',
        ])
        ->assertRedirect(route('incomes.index'));

    $this->assertDatabaseHas('incomes', [
        'remarks' => 'Test remarks',
        'project_id' => null,
        'invoice_no' => null,
    ]);
});

test('income can be soft deleted', function () {
    $income = Income::factory()->create(['created_by' => $this->user->id]);

    $income->delete();

    $this->assertSoftDeleted('incomes', [
        'id' => $income->id,
    ]);
});
