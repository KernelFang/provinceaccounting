<?php

use App\Exports\ReportExport;

uses(Tests\TestCase::class);

it('renders the excel report view and uses equal column widths', function () {
    $report = [
        'title' => 'Project Lifecycle Report',
        'module' => 'projects',
        'item_label' => 'North Tower',
    ];

    $export = new ReportExport($report);

    expect($export->view()->name())->toBe('reports.export-xlsx');
    expect($export->view()->getData()['report'])->toBe($report);

    $widths = $export->columnWidths();

    expect($widths)->toHaveCount(26);
    expect(array_unique(array_values($widths)))->toBe([22]);
});
