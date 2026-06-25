<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ReportExport implements FromView, WithColumnWidths
{
    public function __construct(protected array $report) {}

    public function view(): View
    {
        return view('reports.export-xlsx', ['report' => $this->report]);
    }

    public function columnWidths(): array
    {
        $widths = [];

        foreach (range('A', 'Z') as $column) {
            $widths[$column] = 22;
        }

        return $widths;
    }
}
