<?php

use App\Models\Client;
use App\Models\Expense;
use App\Models\Flat;
use App\Models\Income;
use App\Models\Project;
use App\Models\User;

test('report page is accessible for administrators', function () {
    $user = User::factory()->create([
        'user_type' => 'superadmin',
        'email_verified_at' => now(),
    ]);

    $response = $this->actingAs($user)->get('/account/reports');

    $response->assertOk();
    $response->assertSee('Advanced Report Filters');
});

test('selected project reports include lifecycle sections', function () {
    $user = User::factory()->create([
        'user_type' => 'superadmin',
        'email_verified_at' => now(),
    ]);

    $project = Project::factory()->create();
    Flat::factory()->create(['project_id' => $project->id, 'flat_no' => 'A-1']);
    Income::factory()->create(['project_id' => $project->id, 'price' => 1000]);
    Expense::factory()->create(['project_id' => $project->id, 'amount' => 250]);

    $response = $this->actingAs($user)->get('/account/reports?module=projects&item_id='.$project->id);

    $response->assertOk();
    $response->assertSee('Project Lifecycle Report');
    $response->assertSee('Flats');
    $response->assertSee('Income');
    $response->assertSee('Expenses');
});

test('client reports hide the status filter and keep the item selector available', function () {
    $user = User::factory()->create([
        'user_type' => 'superadmin',
        'email_verified_at' => now(),
    ]);

    $client = Client::factory()->create();

    $response = $this->actingAs($user)->get('/account/reports?module=clients&item_id='.$client->id);

    $response->assertOk();
    $response->assertDontSee('name="status"');
    $response->assertSee('Optional item filter');
});

test('report exports are available as printable html views', function () {
    $user = User::factory()->create([
        'user_type' => 'superadmin',
        'email_verified_at' => now(),
    ]);

    $project = Project::factory()->create();

    $printResponse = $this->actingAs($user)->get('/account/reports/export/print?module=projects&item_id='.$project->id);
    $printResponse->assertOk();
    $printResponse->assertHeader('Content-Type', 'text/html; charset=utf-8');
    $printResponse->assertSee('Project Lifecycle Report');

    $pdfResponse = $this->actingAs($user)->get('/account/reports/export/pdf?module=projects&item_id='.$project->id);
    $pdfResponse->assertOk();
    $pdfResponse->assertHeader('Content-Type', 'application/pdf');
    $pdfResponse->assertHeaderContains('Content-Disposition', 'attachment; filename=project-lifecycle-report-');

    $excelResponse = $this->actingAs($user)->get('/account/reports/export/xlsx?module=projects&item_id='.$project->id);
    $excelResponse->assertOk();
    $excelResponse->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
});
