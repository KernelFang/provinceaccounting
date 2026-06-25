<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Report') . ' ' . __('Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="ps-widget bgc-white bdrs4 p20 mb20">
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
                <div class="ps-widget bgc-white bdrs4 p20 mb20">
                    <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                        <div>
                            <h5 class="title mb-1">{{ $report['title'] ?? 'Generated Report' }}</h5>
                            <div class="text-muted small">{{ $report['item_label'] ?? ucfirst($report['module']) }}
                            </div>
                        </div>
                        <span class="badge bg-primary">{{ ucfirst($report['module']) }}</span>
                    </div>

                    <div class="row g-3 mb-3">
                        @foreach ($report['totals'] as $key => $value)
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <div class="text-muted small text-uppercase">{{ str_replace('_', ' ', $key) }}
                                    </div>
                                    <div class="fw-bold fs-5">
                                        {{ is_numeric($value) ? number_format($value, 2) : $value }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if (!empty($report['sections']))
                        <div class="row g-3 mb-4">
                            @foreach ($report['sections'] as $section)
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100">
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
                                                <ul class="mb-0 ps-3">
                                                    @foreach ($section['rows'] as $row)
                                                        <li>{{ $row }}</li>
                                                    @endforeach
                                                </ul>
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
                                <table class="table table-sm table-bordered">
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

                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Label</th>
                                        <th>Status</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($report['records'] as $index => $record)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $report['labels'][$index] ?? ($record->name ?? ($record->invoice_no ?? ($record->transaction_reference ?? 'Record'))) }}
                                            </td>
                                            <td>{{ $record->status ?? ($record->payment_status ?? ($record->clearing_status ?? 'N/A')) }}
                                            </td>
                                            <td>{{ number_format($record->price ?? ($record->amount ?? 0), 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
