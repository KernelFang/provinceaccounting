<x-app-layout>
    <style>
        .report-table {
            table-layout: fixed;
            width: 100%;
        }

        .report-table th,
        .report-table td {
            vertical-align: top;
            word-break: break-word;
        }
    </style>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Report') . ' ' . __('Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Report Filters</p>

                <form method="GET" action="{{ route('reports.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <div class="form-style1">
                            <label class="form-label fw500 fz16 dark-color">Module</label>
                            <div class="bootselect-multiselect">
                                <select name="module" class="selectpicker" data-live-search="true" data-width="100%"
                                    onchange="this.form.submit()">
                                    <option value="">Select module</option>
                                    @foreach ($modules as $moduleOption)
                                        <option value="{{ $moduleOption['value'] }}"
                                            {{ old('module', $filters['module'] ?? '') === $moduleOption['value'] ? 'selected' : '' }}>
                                            {{ $moduleOption['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    @php
                        $selectedModule = $filters['module'] ?? '';
                        $showItemFilter = in_array(
                            $selectedModule,
                            ['projects', 'clients', 'flats', 'incomes', 'expenses'],
                            true,
                        );
                        $showStatusFilter = in_array(
                            $selectedModule,
                            ['projects', 'flats', 'incomes', 'expenses'],
                            true,
                        );
                    @endphp

                    @if ($showItemFilter)
                        @if ($showItemFilter)
                            <div class="col-md-3">
                                <div class="form-style1">
                                    <label class="form-label fw500 fz16 dark-color">Item</label>
                                    <div class="bootselect-multiselect">
                                        <select name="item_id" class="selectpicker" data-live-search="true"
                                            data-width="100%">
                                            <option value="">Optional item filter</option>

                                            @if ($selectedModule === 'projects')
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}"
                                                        {{ ($filters['item_id'] ?? '') == $project->id ? 'selected' : '' }}>
                                                        {{ $project->name }}
                                                    </option>
                                                @endforeach
                                            @elseif ($selectedModule === 'clients')
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        {{ ($filters['item_id'] ?? '') == $client->id ? 'selected' : '' }}>
                                                        {{ trim($client->first_name . ' ' . $client->last_name) }}
                                                    </option>
                                                @endforeach
                                            @elseif ($selectedModule === 'flats')
                                                @foreach ($flats as $flat)
                                                    <option value="{{ $flat->id }}"
                                                        {{ ($filters['item_id'] ?? '') == $flat->id ? 'selected' : '' }}>
                                                        {{ $flat->building_no }}-{{ $flat->flat_no }}
                                                        ({{ $flat->project->name ?? 'N/A' }})
                                                    </option>
                                                @endforeach
                                            @elseif (in_array($selectedModule, ['incomes', 'expenses']))
                                                @foreach ($projects as $project)
                                                    <option value="{{ $project->id }}"
                                                        {{ ($filters['item_id'] ?? '') == $project->id ? 'selected' : '' }}>
                                                        {{ $project->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="col-md-3">
                            <label class="form-label">Item</label>
                            <input type="text" class="form-control" value="Not applicable" readonly>
                        </div>
                    @endif

                    <div class="col-md-2">
                        <div class="form-style1">
                            <label class="form-label fw500 fz16 dark-color">Group By</label>
                            <div class="bootselect-multiselect">
                                <select class="selectpicker" name="group_by" data-live-search="true" data-width="100%">
                                    <option value="">None</option>
                                    <option value="project"
                                        {{ ($filters['group_by'] ?? '') === 'project' ? 'selected' : '' }}>
                                        Project</option>
                                    <option value="status"
                                        {{ ($filters['group_by'] ?? '') === 'status' ? 'selected' : '' }}>
                                        Status</option>
                                    <option value="month"
                                        {{ ($filters['group_by'] ?? '') === 'month' ? 'selected' : '' }}>
                                        Month</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-style1">
                            <label class="form-label fw500 fz16 dark-color">Order By</label>
                            <div class="bootselect-multiselect">
                                <select name="order_by" class="selectpicker" data-width="100%">
                                    <option value="">Default</option>
                                    <option value="latest"
                                        {{ ($filters['order_by'] ?? '') === 'latest' ? 'selected' : '' }}>
                                        Latest
                                    </option>
                                    <option value="oldest"
                                        {{ ($filters['order_by'] ?? '') === 'oldest' ? 'selected' : '' }}>
                                        Oldest
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    @if ($showStatusFilter)
                        @if ($showStatusFilter)
                            <div class="col-md-2">
                                <div class="form-style1">
                                    <label class="form-label fw500 fz16 dark-color">Status</label>
                                    <div class="bootselect-multiselect">
                                        <select name="status" class="selectpicker" data-live-search="true"
                                            data-width="100%">
                                            <option value="">Any</option>

                                            @foreach ($statuses as $statusOption)
                                                <option value="{{ $statusOption }}"
                                                    {{ ($filters['status'] ?? '') === $statusOption ? 'selected' : '' }}>
                                                    {{ ucfirst($statusOption) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <input type="text" class="form-control" value="Not applicable" readonly>
                        </div>
                    @endif

                    <div class="col-md-3">
                        <label class="form-label">From Date</label>
                        <input type="date" name="from_date" class="form-control"
                            value="{{ $filters['from_date'] ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">To Date</label>
                        <input type="date" name="to_date" class="form-control"
                            value="{{ $filters['to_date'] ?? '' }}">
                    </div>


                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn ud-btn btn-light-thm px-3"
                            style="min-width:max-content;padding:14.35px;">
                            <i class="fa-solid fa-chart-column me-2" style="transform: none;"></i>
                            Generate Report
                        </button>
                    </div>
                </form>
            </div>

            @if ($report)
                <div class="ps-widget bg-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 bdrb1 pb15 mb20">
                        <div>
                            <h5 class="mb-1">{{ $report['title'] ?? 'Generated Report' }}</h5>
                            <p class="text-muted mb-0">{{ $report['item_label'] ?? ucfirst($report['module']) }}</p>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <span
                                class="badge bg-primary rounded-pill px-3 py-2">{{ ucfirst($report['module']) }}</span>
                            <a href="{{ route('reports.export', ['type' => 'print', 'module' => $report['module'], 'item_id' => request('item_id'), 'group_by' => request('group_by'), 'order_by' => request('order_by'), 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'status' => request('status')]) }}"
                                class="btn btn-sm btn-outline-secondary" target="_blank">
                                <i class="fa-solid fa-print me-1"></i> Print
                            </a>
                            <a href="{{ route('reports.export', ['type' => 'pdf', 'module' => $report['module'], 'item_id' => request('item_id'), 'group_by' => request('group_by'), 'order_by' => request('order_by'), 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'status' => request('status')]) }}"
                                class="btn btn-sm btn-outline-danger" target="_blank">
                                <i class="fa-solid fa-file-pdf me-1"></i> PDF
                            </a>
                            <a href="{{ route('reports.export', ['type' => 'xlsx', 'module' => $report['module'], 'item_id' => request('item_id'), 'group_by' => request('group_by'), 'order_by' => request('order_by'), 'from_date' => request('from_date'), 'to_date' => request('to_date'), 'status' => request('status')]) }}"
                                class="btn btn-sm btn-outline-success" target="_blank">
                                <i class="fa-solid fa-file-excel me-1"></i> Excel
                            </a>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        @foreach ($report['totals'] as $key => $value)
                            <div class="col-12 col-md-3">
                                <div class="p-3 h-100 bdrs4 bg-light">
                                    <small class="text-muted">{{ str_replace('_', ' ', $key) }}</small>
                                    <div class="h5 mb-0">
                                        {{ is_numeric($value) ? number_format($value, 2) : $value }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (!empty($report['sections']))
                        <div class="row g-3 mb-4">
                            @foreach ($report['sections'] as $section)
                                <div class="col-md-6">
                                    <div class="p-3 h-100 bdrs4 bg-white border">
                                        <h6 class="fw-bold mb-3">{{ $section['title'] }}</h6>
                                        @if (($section['type'] ?? 'list') === 'summary')
                                            <div class="small">
                                                @foreach ($section['rows'] as $row)
                                                    <p class="mb-1"><strong>{{ $row['label'] }}:</strong>
                                                        {{ $row['value'] }}</p>
                                                @endforeach
                                            </div>
                                        @else
                                            @if (!empty($section['rows']))
                                                @php
                                                    $tableRows = collect($section['rows']);
                                                    $firstRow = $tableRows->first();
                                                    $isStructuredRows = is_array($firstRow) || is_object($firstRow);
                                                    $tableColumns = $section['columns'] ?? [];

                                                    if ($isStructuredRows && empty($tableColumns)) {
                                                        $tableColumns = array_keys((array) $firstRow);
                                                    }
                                                @endphp

                                                <div class="table-responsive">
                                                    <table
                                                        class="table table-sm table-bordered mb-0 align-middle report-table">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                @if ($isStructuredRows)
                                                                    @foreach ($tableColumns as $columnKey => $columnLabel)
                                                                        <th>{{ is_int($columnKey) ? ucwords(str_replace('_', ' ', $columnLabel)) : $columnLabel }}
                                                                        </th>
                                                                    @endforeach
                                                                @else
                                                                    <th>Item</th>
                                                                @endif
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($tableRows as $row)
                                                                <tr>
                                                                    @if ($isStructuredRows)
                                                                        @foreach ($tableColumns as $columnKey => $columnLabel)
                                                                            @php $columnName = is_int($columnKey) ? $columnLabel : $columnKey; @endphp
                                                                            <td>{{ data_get($row, $columnName, '') }}
                                                                            </td>
                                                                        @endforeach
                                                                    @else
                                                                        <td>{{ $row }}</td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="mb-0 text-muted">No data available.</p>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        @if (!empty($report['grouped']))
                            <div class="table-responsive mb-4">
                                <table class="table table-sm table-bordered report-table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Group</th>
                                            <th>Count</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report['grouped'] as $groupName => $groupValue)
                                            <tr>
                                                <td>{{ $groupName }}</td>
                                                <td>{{ $groupValue['count'] }}</td>
                                                <td>{{ number_format($groupValue['total'], 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @php
                            $tableHeaders = $report['table_headers'] ?? [];
                            $tableRows = $report['table_rows'] ?? [];
                        @endphp

                        @if (!empty($tableRows))
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered mb-0 report-table">
                                    <thead class="table-dark">
                                        <tr>
                                            @foreach ($tableHeaders as $header)
                                                <th>{{ $header }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tableRows as $row)
                                            <tr>
                                                @foreach ($row as $cell)
                                                    <td>{{ $cell }}</td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
