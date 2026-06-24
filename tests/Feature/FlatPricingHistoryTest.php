<?php

use App\Models\FlatPricingHistory;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['user_type' => 'superadmin']);
});

test('can create flat pricing history', function () {
    $history = FlatPricingHistory::factory()->create(['changed_by' => $this->user->id]);

    $this->assertDatabaseHas('flat_pricing_histories', [
        'id' => $history->id,
        'changed_by' => $this->user->id,
    ]);
});

test('pricing history relates to flat', function () {
    $history = FlatPricingHistory::factory()->create(['changed_by' => $this->user->id]);

    $this->assertNotNull($history->flat);
});
