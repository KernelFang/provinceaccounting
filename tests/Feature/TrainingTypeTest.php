<?php

use App\Models\TrainingType;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['user_type' => 'superadmin']);
});

test('can create training type', function () {
    $type = TrainingType::factory()->create(['created_by' => $this->user->id]);

    $this->assertDatabaseHas('training_types', [
        'id' => $type->id,
        'name' => $type->name,
    ]);
});

test('training type can be soft deleted', function () {
    $type = TrainingType::factory()->create(['created_by' => $this->user->id]);

    $type->delete();

    $this->assertSoftDeleted('training_types', [
        'id' => $type->id,
    ]);
});
