<?php

use App\Models\Flat;
use App\Models\FlatPricingHistory;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['user_type' => 'superadmin']);
});

test('can create flat', function () {
    $flat = Flat::factory()->create(['created_by' => $this->user->id]);

    $this->assertDatabaseHas('flats', [
        'id' => $flat->id,
        'flat_no' => $flat->flat_no,
    ]);
});

test('flat pricing histories can be related', function () {
    $flat = Flat::factory()->create(['created_by' => $this->user->id]);

    $history = FlatPricingHistory::factory()->create(['flat_id' => $flat->id, 'changed_by' => $this->user->id]);

    $this->assertDatabaseHas('flat_pricing_histories', [
        'id' => $history->id,
        'flat_id' => $flat->id,
    ]);
});

test('flat can be soft deleted', function () {
    $flat = Flat::factory()->create(['created_by' => $this->user->id]);

    $flat->delete();

    $this->assertSoftDeleted('flats', [
        'id' => $flat->id,
    ]);
});
