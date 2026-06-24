<?php

use App\Models\Client;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create(['user_type' => 'superadmin']);
});

test('can create a client', function () {
    $client = Client::factory()->make(['created_by' => $this->user->id]);

    $client->save();

    $this->assertDatabaseHas('clients', [
        'id' => $client->id,
        'email' => $client->email,
    ]);
});

test('can update a client', function () {
    $client = Client::factory()->create(['created_by' => $this->user->id]);

    $client->update(['first_name' => 'UpdatedName']);

    $this->assertDatabaseHas('clients', [
        'id' => $client->id,
        'first_name' => 'UpdatedName',
    ]);
});

test('client can be soft deleted', function () {
    $client = Client::factory()->create(['created_by' => $this->user->id]);

    $client->delete();

    $this->assertSoftDeleted('clients', [
        'id' => $client->id,
    ]);
});
