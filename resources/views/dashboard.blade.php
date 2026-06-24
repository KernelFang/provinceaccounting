<x-app-layout>
    @php
        $ut = auth()->user()->user_type;
        $months = [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];
    @endphp

    @if (in_array($ut, ['admin', 'superadmin']))
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>

            <button class="ud-btn btn-white2 py-0 ps-1 pe-2" onclick="printElement('printable-area')"
                style="height: 35px;margin: auto 0;">
                <i class="fa fa-print me-1"></i> {{ __('Print') }}
            </button>
        </x-slot>

        <x-slot name="style">
            <style>
                .hover-bgc-color {
                    background-color: #F2F2F2 !important;
                }

                thead {
                    border-top: none !important;
                }

                .datatable-buttons {
                    display: flex;
                    gap: 5px;
                    justify-content: flex-end;
                    /* aligns buttons to the right like the old link */
                }
            </style>

            <style>
                .report-table td:first-child {
                    font-weight: 500;
                    padding-left: 1rem;
                }

                .col-ticket td:first-child {
                    background: #ffffff !important;
                }

                .col-ticket_issued td:first-child {
                    background: #4db8c4 !important;
                    color: #fff !important;
                }

                .col-segment td:first-child {
                    background: #a8d8a8 !important;
                }

                .col-reissue td:first-child {
                    background: #f9c784 !important;
                }

                .col-void td:first-child {
                    background: #f4a9c4 !important;
                }

                .col-refund td:first-child {
                    background: #ff7f7f !important;
                    color: #fff !important;
                }

                .col-tour td:first-child {
                    background: #ffffff !important;
                }

                .col-hotel td:first-child {
                    background: #6ab4f5 !important;
                    color: #fff !important;
                }

                .col-car td:first-child {
                    background: #72d572 !important;
                }

                .col-local td:first-child {
                    background: #f5e642 !important;
                }

                .col-intl td:first-child {
                    background: #7ec8e3 !important;
                }

                .col-ship td:first-child {
                    background: #f0a030 !important;
                    color: #fff !important;
                }

                .col-visa_career td:first-child {
                    background: #f48fb1 !important;
                }

                .col-carrer td:first-child {
                    background: #c4a4e0 !important;
                }

                .col-hajj td:first-child {
                    background: #f4c2a1 !important;
                }

                .col-umrah td:first-child {
                    background: #80cbc4 !important;
                }

                .col-student td:first-child {
                    background: #ef9a9a !important;
                }

                .col-visa td:first-child {
                    background: #ffffff !important;
                }

                .col-others td:first-child {
                    background: #a5d6a7 !important;
                }

                .col-training td:first-child {
                    background: #ffffff !important;
                }
            </style>

            <style>
                @media print {

                    /* Force the table to take up the full width of the paper */
                    table {
                        width: 100% !important;
                        table-layout: fixed;
                        /* Helps keep columns contained */
                        border-collapse: collapse;
                    }

                    /* Hide unnecessary UI elements like navbars or sidebars */
                    .no-print {
                        display: none;
                    }

                    /* Ensure the body doesn't have restrictive margins */
                    body {
                        margin: 0;
                        padding: 0;
                    }
                }
            </style>
        </x-slot>

        <div class="py-12">

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="printable-area">
                {{-- Dashboard variables are provided by DashboardController for chart --}}
                {{-- <script>
                    window.DASHBOARD_STATS = {
                        totals: {
                            totalUsers: {{ $totalUsers ?? 0 }},
                            totalSales: {{ $totalSales ?? 0 }},
                            totalTrips: {{ $totalTrips ?? 0 }},
                            totalTours: {{ $totalTours ?? 0 }},
                            totalVisas: {{ $totalVisas ?? 0 }},
                            totalAirlines: {{ $totalAirlines ?? 0 }},
                            totalServiceTypes: {{ $totalServiceTypes ?? 0 }},
                            totalCountries: {{ $totalCountries ?? 0 }},
                            totalPortals: {{ $totalPortals ?? 0 }},
                            totalPortalTransactions: {{ $totalPortalTransactions ?? 0 }},
                            totalPetty: {{ $totalPetty ?? 0 }},
                            totalExpensesThisMonth: {{ $totalExpensesThisMonth ?? 0 }},
                            totalExpensesLastMonth: {{ $totalExpensesLastMonth ?? 0 }},
                        },
                        expensesByMonth: {!! json_encode($expensesByMonth ?? []) !!},
                        salesByMonth: {!! json_encode($salesByMonth ?? []) !!},
                        reportSummary: {!! json_encode($reportSummary ?? []) !!},
                        currentMonth: "{{ $currentMonth ?? now()->format('Y-m') }}",
                        recentSales: {!! json_encode($recentSales ?? []) !!},
                        recentExpenses: {!! json_encode($recentExpenses ?? []) !!},
                        recentUsers: {!! json_encode($recentUsers ?? []) !!}
                    };
                </script> --}}

                <div class="row">
                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Total Users</div>
                                <div class="title">{{ $totalUsers }}</div>
                                {{-- <div class="text fz14"><span class="text-thm">{{ $totalUsers }}</span> Users</div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-cv"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Ticket Sales</div>
                                <div class="title">{{ $totalSales }}</div>
                                {{-- <div class="text fz14"><span
                                        class="text-thm">{{ number_format($recentSales->sum('customer_fare') ?? 0, 2) }}</span>
                                    Recent Fare</div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Tours</div>
                                <div class="title">{{ $totalTours }}</div>
                                {{-- <div class="text fz14"><span
                                        class="text-thm text-danger">{{ number_format($toursDue ?? 0, 2) }}</span> Due
                                </div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">VISA & Consultency</div>
                                <div class="title">{{ $totalVisas ?? 0 }}</div>
                                {{-- <div class="text fz14"><span
                                        class="text-thm text-danger">{{ number_format($visasDue ?? 0, 2) }}</span> Due
                                </div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Trainings</div>
                                <div class="title">{{ $totalTrainings ?? 0 }}</div>
                                {{-- <div class="text fz14"><span
                                        class="text-thm text-danger">{{ number_format($trainingsDue ?? 0, 2) }}</span>
                                    Due
                                </div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Airlines</div>
                                <div class="title">{{ $totalAirlines ?? 0 }}</div>
                                {{-- <div class="text fz14"><span class="text-thm">{{ $totalAirlines ?? 0 }}</span> Airlines
                                </div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div>

                    {{-- <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Service Types</div>
                                <div class="title">{{ $totalServiceTypes ?? 0 }}</div>
                                <div class="text fz14"><span class="text-thm">{{ $totalServiceTypes ?? 0 }}</span>
                                    Types
                                </div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div> --}}

                    {{-- <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Countries</div>
                                <div class="title">{{ $totalCountries ?? 0 }}</div>
                                <div class="text fz14"><span class="text-thm">{{ $totalCountries ?? 0 }}</span>
                                    Countries
                                </div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div> --}}

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Portals</div>
                                <div class="title">{{ $totalPortals ?? 0 }}</div>
                                {{-- <div class="text fz14"><span class="text-thm">{{ $totalPortals ?? 0 }}</span> Portals
                                </div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div>

                    {{-- <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Portal Balance</div>
                                <div class="title">{{ $totalPortalTransactions ?? 0 }}</div>
                                <div class="text fz14"><span
                                        class="text-thm">{{ $totalPortalTransactions ?? 0 }}</span>
                                    Transactions</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div> --}}

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Portal Balance</div>
                                <div class="title {{ ($totalPortalCurrent ?? 0) < 0 ? 'text-danger' : '' }}">
                                    {{ number_format($totalPortalCurrent ?? 0, 2) }} Tk.</div>
                                {{-- <div class="text fz14"><span class="text-thm">Total current balance across
                                        portals</span>
                                </div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-money"></i></div>
                        </div>
                    </div>

                    {{-- <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Trips</div>
                                <div class="title">{{ $totalTrips }}</div>
                                <div class="text fz14"><span class="text-thm">{{ $totalTrips }}</span> Trips</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-file"></i></div>
                        </div>
                    </div> --}}

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Tickets Due</div>
                                <div class="title text-danger">{{ number_format($salesDue ?? 0, 2) }} Tk.</div>
                                {{-- <div class="text fz14"><span class="text-thm">Due</span></div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-briefcase"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Tours Due</div>
                                <div class="title text-danger">{{ number_format($toursDue ?? 0, 2) }} Tk.</div>
                                {{-- <div class="text fz14"><span class="text-thm">Due</span></div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-briefcase"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Visas Due</div>
                                <div class="title text-danger">{{ number_format($visasDue ?? 0, 2) }} Tk.</div>
                                {{-- <div class="text fz14"><span class="text-thm">Due</span></div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-briefcase"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Trainings Due</div>
                                <div class="title text-danger">{{ number_format($trainingsDue ?? 0, 2) }} Tk.</div>
                                {{-- <div class="text fz14"><span class="text-thm">Due</span></div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-briefcase"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">This Month Expense</div>
                                <div class="title text-danger">{{ number_format($totalExpensesThisMonth, 2) }} <span
                                        class="fs-5">Tk.</span></div>
                                {{-- <div class="text fz14"><span
                                        class="text-thm">{{ $expenseCountThisMonth ?? 0 }}</span>
                                    Expenses</div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-money"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Last Month Expense</div>
                                <div class="title text-danger">{{ number_format($totalExpensesLastMonth, 2) }} <span
                                        class="fs-5">Tk.</span></div>
                                {{-- <div class="text fz14"><span
                                        class="text-thm">{{ $expenseCountLastMonth ?? 0 }}</span>
                                    Expenses</div> --}}
                            </div>
                            <div class="icon text-center"><i class="flaticon-money"></i></div>
                        </div>
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-xl-8">
                        <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                            <div class="navtab-style1">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <div class="d-sm-flex align-items-center justify-content-between">
                                    <h4 class="title fz17 mb20">Sales vs Expenses</h4>
                                    <div class="page_control_shorting dark-color pr10 text-center text-md-end">
                                        <div class="dropdown bootstrap-select show-tick">
                                            <select class="selectpicker show-tick">
                                                <option>Last 6 Months</option>
                                                <option>Last 12 Months</option>
                                                <option>Last 10 Years</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <canvas id="myChartweave" style="height: 306px; display: block; width: 613px;"
                                    width="613" height="306" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <div class="bdrb1 pb15 mb50">
                                <h5 class="title">Totals Breakdown</h5>
                            </div>
                            <canvas id="myChart" height="531" width="613"
                                style="display: block; width: 613px; height: 531px;"
                                class="chartjs-render-monitor"></canvas>
                        </div>
                    </div>
                </div> --}}

                <div class="row mt50">
                    <div class="col-12">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Report Summary - Month & Year Filter</h5>
                                <!-- Buttons placeholder -->
                                <div class="datatable-buttons mb-2"></div>
                            </div>
                            <form method="GET" id="reportSummaryFilterForm"
                                class="d-flex align-items-center gap-2">
                                <label class="me-2 mb-0">Select Month & Year:</label>
                                <select name="report_summary_month" class="form-control" style="max-width:120px">
                                    <option value="">-- Month --</option>
                                    @php
                                        for ($m = 1; $m <= 12; $m++) {
                                            $selected = $reportSummaryDisplayMonth == $m ? 'selected' : '';
                                            echo "<option value=\"$m\" $selected>{$months[$m - 1]}</option>";
                                        }
                                    @endphp
                                </select>
                                <select name="report_summary_year" class="form-control" style="max-width:120px">
                                    <option value="">-- Year --</option>
                                    @php
                                        for ($y = 2025; $y <= now()->year + 1; $y++) {
                                            $selected = $reportSummaryDisplayYear == $y ? 'selected' : '';
                                            echo "<option value=\"$y\" $selected>$y</option>";
                                        }
                                    @endphp
                                </select>
                                {{-- Preserve other filter parameters --}}
                                <input type="hidden" name="start_date" value="{{ $startDate ?? '' }}">
                                <input type="hidden" name="end_date" value="{{ $endDate ?? '' }}">
                                <button type="submit" class="btn ud-btn btn-light-thm">Apply</button>
                                <a href="{{ route('dashboard') }}" class="btn btn-link">Reset</a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Report Summary</h5>
                                <!-- Buttons placeholder -->
                                <div class="datatable-buttons mb-2"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0 recordDataTableTwo report-table"
                                    data-ordering="false" data-col-reorder="false" data-row-reorder="false"
                                    data-info="false">
                                    <thead>
                                        <tr class="text-white text-center" style="background:#222d61;">
                                            <th class="text-start ps-3">
                                                @php
                                                    $monthName = $months[$reportSummaryDisplayMonth - 1] ?? 'Month';
                                                    echo "$monthName $reportSummaryDisplayYear";
                                                @endphp
                                            </th>
                                            <th class="text-center">Sales</th>
                                            <th class="text-center">Purchase</th>
                                            <th class="text-center">Profit</th>
                                            <th class="text-center">Due</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @foreach ($reportSummaryDataFiltered as $row)
                                            <tr class="col-{{ $row['key'] }}">
                                                <td class="text-start fw-semibold">{{ $row['label'] }}</td>

                                                {{-- Sales --}}
                                                <td>
                                                    {!! is_numeric($row['total_sales'])
                                                        ? number_format($row['total_sales'], 2)
                                                        : '<span class="text-muted">N/A</span>' !!}
                                                </td>

                                                {{-- Purchase --}}
                                                <td>
                                                    {!! is_numeric($row['total_purchase'])
                                                        ? number_format($row['total_purchase'], 2)
                                                        : '<span class="text-muted">N/A</span>' !!}
                                                </td>

                                                {{-- Profit --}}
                                                <td>
                                                    {!! is_numeric($row['profit']) ? number_format($row['profit'], 2) : '<span class="text-muted">N/A</span>' !!}
                                                </td>

                                                {{-- Due --}}
                                                <td>
                                                    {!! is_numeric($row['total_due']) ? number_format($row['total_due'], 2) : '<span class="text-muted">N/A</span>' !!}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mb-1 mt-4">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <form method="GET" id="reportRangeForm" class="d-flex align-items-center gap-2">
                                <label class="me-2 mb-0">Date Range Filter for Reports:</label>
                                <input type="date" name="start_date"
                                    value="{{ $startDate ?? now()->subMonths(5)->toDateString() }}"
                                    class="form-control" style="max-width:180px">
                                <input type="date" name="end_date"
                                    value="{{ $endDate ?? now()->toDateString() }}" class="form-control"
                                    style="max-width:180px">
                                <button type="submit" class="btn ud-btn btn-light-thm">Apply</button>
                                <a href="{{ route('dashboard') }}" class="btn btn-link">Reset</a>
                            </form>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xxl-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Ticket Sales Reports</h5>

                                <!-- Buttons placeholder -->
                                <div class="datatable-buttons mb-2"></div>
                            </div>

                            <div class="table-responsive">
                                <h6 class="mb-2">Ticket Sales by Portal ({{ $startDate }} to
                                    {{ $endDate }})</h6>
                                <table class="table table-striped table-sm mb-3 recordDataTableTwo">
                                    <thead>
                                        <tr>
                                            <th>Portal</th>
                                            <th class="text-end">Count</th>
                                            {{-- <th class="text-end">Total (tk)</th> --}}
                                            <th class="text-end">Profit (tk)</th>
                                            <th class="text-end">Net Profit (tk)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($salesReport as $row)
                                            <tr>
                                                <td>{{ $row->label ?? 'Unknown' }}</td>
                                                <td class="text-end">{{ number_format($row->count ?? 0) }}</td>
                                                {{-- <td class="text-end">{{ number_format($row->total ?? 0, 2) }}</td> --}}
                                                <td
                                                    class="text-end {{ ($row->profit ?? 0) < 0 ? 'text-danger' : '' }}">
                                                    {{ number_format($row->profit ?? 0, 2) }} tk</td>
                                                <td
                                                    class="text-end {{ ($row->net_profit ?? 0) < 0 ? 'text-danger' : '' }}">
                                                    {{ number_format($row->net_profit ?? 0, 2) }} tk</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark fw-bold">
                                            <td class="text-start">TOTAL</td>
                                            <td class="text-end">
                                                {{ number_format($salesReportSums->totalCount ?? 0) }}</td>
                                            <td
                                                class="text-end {{ ($salesReportSums->totalProfit ?? 0) < 0 ? 'text-danger' : '' }}">
                                                {{ number_format($salesReportSums->totalProfit ?? 0, 2) }} tk</td>
                                            <td
                                                class="text-end {{ ($salesReportSums->totalNetProfit ?? 0) < 0 ? 'text-danger' : '' }}">
                                                {{ number_format($salesReportSums->totalNetProfit ?? 0, 2) }} tk</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xxl-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Portal Balances Reports</h5>

                                <!-- Buttons placeholder -->
                                <div class="datatable-buttons mb-2"></div>
                            </div>
                            <div class="table-responsive">
                                <h6 class="mb-2">Portal Balances by Portal ({{ $startDate }} to
                                    {{ $endDate }})
                                </h6>
                                <table class="table table-striped table-sm mb-3 recordDataTableTwo">
                                    <thead>
                                        <tr>
                                            <th>Portal</th>
                                            <th class="text-end">Count</th>
                                            <th class="text-end">Total Recharge (tk)</th>
                                            <th class="text-end">Current Balance (tk)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($portalBalancesReport as $row)
                                            <tr>
                                                <td>{{ $row->label ?? 'Unknown' }}</td>
                                                <td class="text-end">{{ number_format($row->count ?? 0) }}</td>
                                                <td class="text-end">{{ number_format($row->total ?? 0, 2) }}</td>
                                                <td
                                                    class="text-end {{ ($row->current ?? 0) < 0 ? 'text-danger' : '' }}">
                                                    {{ number_format($row->current ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark fw-bold">
                                            <td class="text-start">TOTAL</td>
                                            <td class="text-end">
                                                {{ number_format($portalBalancesReportSums->totalCount ?? 0) }}</td>
                                            <td class="text-end">
                                                {{ number_format($portalBalancesReportSums->totalRecharge ?? 0, 2) }}
                                            </td>
                                            <td
                                                class="text-end {{ ($portalBalancesReportSums->totalCurrent ?? 0) < 0 ? 'text-danger' : '' }}">
                                                {{ number_format($portalBalancesReportSums->totalCurrent ?? 0, 2) }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xxl-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Tours Reports</h5>

                                <!-- Buttons placeholder -->
                                <div class="datatable-buttons mb-2"></div>
                            </div>
                            <div class="table-responsive">
                                <h6 class="mb-2">Tours by Purpose ({{ $startDate }} to {{ $endDate }})</h6>
                                <table class="table table-striped table-sm mb-3 recordDataTableTwo">
                                    <thead>
                                        <tr>
                                            <th>Purpose</th>
                                            <th class="text-end">Count</th>
                                            <th class="text-end">Customer Price (tk)</th>
                                            <th class="text-end">Agent Cost (tk)</th>
                                            <th class="text-end">Profit (tk)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($toursReport as $row)
                                            <tr>
                                                <td>{{ $row->label ?? 'Unknown' }}</td>
                                                <td class="text-end">{{ number_format($row->count ?? 0) }}</td>
                                                <td class="text-end">{{ number_format($row->customer_price ?? 0, 2) }}
                                                    tk
                                                </td>
                                                <td class="text-end">{{ number_format($row->agent_cost ?? 0, 2) }} tk
                                                </td>
                                                <td
                                                    class="text-end {{ ($row->profit ?? 0) < 0 ? 'text-danger' : '' }}">
                                                    {{ number_format($row->profit ?? 0, 2) }} tk</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark fw-bold">
                                            <td class="text-start">TOTAL</td>
                                            <td class="text-end">
                                                {{ number_format($toursReportSums->totalCount ?? 0) }}</td>
                                            <td class="text-end">
                                                {{ number_format($toursReportSums->totalCustomerPrice ?? 0, 2) }} tk
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($toursReportSums->totalAgentCost ?? 0, 2) }} tk</td>
                                            <td
                                                class="text-end {{ ($toursReportSums->totalProfit ?? 0) < 0 ? 'text-danger' : '' }}">
                                                {{ number_format($toursReportSums->totalProfit ?? 0, 2) }} tk</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xxl-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">VISA & Consultency Reports</h5>

                                <!-- Buttons placeholder -->
                                <div class="datatable-buttons mb-2"></div>
                            </div>
                            <div class="table-responsive">
                                <h6 class="mb-2">Visas by Purpose ({{ $startDate }} to {{ $endDate }})</h6>
                                <table class="table table-striped table-sm mb-3 recordDataTableTwo">
                                    <thead>
                                        <tr>
                                            <th>Purpose</th>
                                            <th class="text-end">Count</th>
                                            <th class="text-end">Customer Price (tk)</th>
                                            <th class="text-end">Agent Cost (tk)</th>
                                            <th class="text-end">Profit (tk)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($visasReport as $row)
                                            <tr>
                                                <td>{{ $row->label ?? 'Unknown' }}</td>
                                                <td class="text-end">{{ number_format($row->count ?? 0) }}</td>
                                                <td class="text-end">{{ number_format($row->customer_price ?? 0, 2) }}
                                                    tk
                                                </td>
                                                <td class="text-end">{{ number_format($row->agent_cost ?? 0, 2) }} tk
                                                </td>
                                                <td
                                                    class="text-end {{ ($row->profit ?? 0) < 0 ? 'text-danger' : '' }}">
                                                    {{ number_format($row->profit ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark fw-bold">
                                            <td class="text-start">TOTAL</td>
                                            <td class="text-end">
                                                {{ number_format($visasReportSums->totalCount ?? 0) }}</td>
                                            <td class="text-end">
                                                {{ number_format($visasReportSums->totalCustomerPrice ?? 0, 2) }} tk
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($visasReportSums->totalAgentCost ?? 0, 2) }} tk</td>
                                            <td
                                                class="text-end {{ ($visasReportSums->totalProfit ?? 0) < 0 ? 'text-danger' : '' }}">
                                                {{ number_format($visasReportSums->totalProfit ?? 0, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xxl-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Trainings Reports</h5>

                                <!-- Buttons placeholder -->
                                <div class="datatable-buttons mb-2"></div>
                            </div>
                            <div class="table-responsive">
                                <h6 class="mb-2">Trainings by Type ({{ $startDate }} to {{ $endDate }})
                                </h6>
                                <table class="table table-striped table-sm mb-3 recordDataTableTwo">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th class="text-end">Count</th>
                                            <th class="text-end">Customer Price (tk)</th>
                                            <th class="text-end">Agent Cost (tk)</th>
                                            <th class="text-end">Total (tk)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($trainingsReport as $row)
                                            <tr>
                                                <td>{{ $row->label ?? 'Unknown' }}</td>
                                                <td class="text-end">{{ number_format($row->count ?? 0) }}</td>
                                                <td class="text-end">
                                                    {{ number_format($row->customer_price ?? 0, 2) }}
                                                </td>
                                                <td class="text-end">{{ number_format($row->agent_cost ?? 0, 2) }}
                                                </td>
                                                <td class="text-end">{{ number_format($row->total ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark fw-bold">
                                            <td class="text-start">TOTAL</td>
                                            <td class="text-end">
                                                {{ number_format($trainingsReportSums->totalCount ?? 0) }}</td>
                                            <td class="text-end">
                                                {{ number_format($trainingsReportSums->totalCustomerPrice ?? 0, 2) }}
                                            </td>
                                            <td class="text-end">
                                                {{ number_format($trainingsReportSums->totalAgentCost ?? 0, 2) }}</td>
                                            <td class="text-end">
                                                {{ number_format($trainingsReportSums->totalAmount ?? 0, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-xxl-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Expenses Reports</h5>

                                <!-- Buttons placeholder -->
                                <div class="datatable-buttons mb-2"></div>
                            </div>
                            <div class="table-responsive">

                                <h6 class="mb-2">Expenses by Category ({{ $startDate }} to
                                    {{ $endDate }})
                                </h6>
                                <table class="table table-striped table-sm mb-3 recordDataTableTwo">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th class="text-end">Count</th>
                                            <th class="text-end">Total (tk)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expensesReport as $row)
                                            <tr>
                                                <td>{{ $row->label ?? 'Uncategorized' }}</td>
                                                <td class="text-end">{{ number_format($row->count ?? 0) }}</td>
                                                <td class="text-end">{{ number_format($row->total ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="table-dark fw-bold">
                                            <td class="text-start">TOTAL</td>
                                            <td class="text-end">
                                                {{ number_format($expensesReportSums->totalCount ?? 0) }}</td>
                                            <td class="text-end">
                                                {{ number_format($expensesReportSums->totalExpenses ?? 0, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt50">
                    <div class="col-12 col-md-6 col-xxl-4">
                        <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between bdrb1 pb15 mb10">
                                <h5 class="title">Recent Sales</h5>
                                <a class="text-decoration-underline text-thm6" href="{{ route('sales.index') }}">View
                                    All</a>
                            </div>
                            <div class="dashboard-img-service">
                                @foreach ($recentSales as $s)
                                    <div
                                        class="listing-style1 list-style d-block d-xl-flex align-items-center border-0 mb10">
                                        <div class="list-content flex-grow-1 py-0 pl5">
                                            <h6 class="list-title mb-0">
                                                <a
                                                    href="{{ route('sales.show', $s->id) }}">{{ Str::limit($s->pax_name ?? ($s->tkt_number ?? 'Sale #' . $s->id), 60) }}</a>
                                            </h6>
                                            <p class="mb-0 lh-1">
                                                <small>
                                                    {{ $s->issued_portal ?? 'N/A' }} —
                                                    {{ $s->service_type ?? 'N/A' }}
                                                    <span
                                                        class="text-danger">{{ number_format($s->customer_fare ?? 0, 2) }}
                                                        tk</span>
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="opacity-100 mt-0 mb10">
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xxl-4">
                        <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between bdrb1 pb15 mb10">
                                <h5 class="title">Recent Expenses</h5>
                                <a class="text-decoration-underline text-thm6"
                                    href="{{ route('expenses.index') }}">View
                                    All</a>
                            </div>
                            <div class="dashboard-img-service">
                                @foreach ($recentExpenses as $expense)
                                    <div
                                        class="listing-style1 list-style d-block d-xl-flex align-items-center border-0 mb10">
                                        <div class="list-content flex-grow-1 py-0 pl5">
                                            <h6 class="list-title mb-0">
                                                <a
                                                    href="{{ route('expenses.show', $expense->id) }}">{{ Str::limit($expense->title, 80) }}</a>
                                            </h6>
                                            <p class="mb-0 lh-1">
                                                <small>
                                                    Spent <span
                                                        class="text-danger">{{ number_format($expense->amount, 2) }}
                                                        tk</span>
                                                    on
                                                    {{ optional($expense->date)->format('M d, Y') ?? 'N/A' }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="opacity-100 mt-0 mb10">
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xxl-4">
                        <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between bdrb1 pb15 mb10">
                                <h5 class="title">Recent Tours</h5>
                                <a class="text-decoration-underline text-thm6"
                                    href="{{ route('tours.index') }}">View
                                    All</a>
                            </div>
                            <div class="dashboard-img-service">
                                @foreach ($recentTours as $tour)
                                    <div
                                        class="listing-style1 list-style d-block d-xl-flex align-items-center border-0 mb10">
                                        <div class="list-content flex-grow-1 py-0 pl5">
                                            <h6 class="list-title mb-0">
                                                <a
                                                    href="{{ route('tours.show', $tour->id) }}">{{ Str::limit($tour->title, 80) }}</a>
                                            </h6>
                                            <p class="mb-0 lh-1">
                                                <small>
                                                    Spent <span
                                                        class="text-danger">{{ number_format($tour->amount, 2) }}
                                                        tk</span>
                                                    on {{ optional($tour->from_date)->format('M d, Y') ?? 'N/A' }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="opacity-100 mt-0 mb10">
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xxl-4">
                        <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between bdrb1 pb15 mb10">
                                <h5 class="title">Recent Visas</h5>
                                <a class="text-decoration-underline text-thm6"
                                    href="{{ route('visas.index') }}">View
                                    All</a>
                            </div>
                            <div class="dashboard-img-service">
                                @foreach ($recentVisas as $visa)
                                    <div
                                        class="listing-style1 list-style d-block d-xl-flex align-items-center border-0 mb10">
                                        <div class="list-content flex-grow-1 py-0 pl5">
                                            <h6 class="list-title mb-0">
                                                <a
                                                    href="{{ route('visas.show', $visa->id) }}">{{ Str::limit($visa->purpose ?? 'N/A', 80) }}</a>
                                            </h6>
                                            <p class="mb-0 lh-1">
                                                <small>
                                                    Spent <span
                                                        class="text-danger">{{ number_format($visa->customer_price, 2) }}
                                                        tk</span>
                                                    on {{ optional($visa->from_date)->format('M d, Y') ?? 'N/A' }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="opacity-100 mt-0 mb10">
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xxl-4">
                        <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between bdrb1 pb15 mb10">
                                <h5 class="title">Recent Trainings</h5>
                                <a class="text-decoration-underline text-thm6"
                                    href="{{ route('trainings.index') }}">View
                                    All</a>
                            </div>
                            <div class="dashboard-img-service">
                                @foreach ($recentTrainings as $training)
                                    <div
                                        class="listing-style1 list-style d-block d-xl-flex align-items-center border-0 mb10">
                                        <div class="list-content flex-grow-1 py-0 pl5">
                                            <h6 class="list-title mb-0">
                                                <a
                                                    href="{{ route('trainings.show', $training->id) }}">{{ Str::limit($training->title ?? 'N/A', 80) }}</a>
                                            </h6>
                                            <p class="mb-0 lh-1">
                                                <small>
                                                    Spent <span
                                                        class="text-danger">{{ number_format($training->customer_price, 2) }}
                                                        tk</span>
                                                    on {{ optional($training->from_date)->format('M d, Y') ?? 'N/A' }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                    <hr class="opacity-100 mt-0 mb10">
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xxl-4">
                        <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between bdrb1 pb15 mb10">
                                <h5 class="title">Recent Users</h5>
                                <a class="text-decoration-underline text-thm6"
                                    href="{{ route('users.index') }}">View
                                    All</a>
                            </div>
                            <div class="dashboard-img-service">
                                @foreach ($recentUsers as $u)
                                    <div
                                        class="listing-style1 list-style d-block d-xl-flex align-items-center border-0 mb10">
                                        <div class="list-thumb flex-shrink-0 bdrs4" style="width: 70px;">
                                            <img class="w-100 p-1"
                                                src="{{ asset('theme/v1/images/resource/user.png') }}"
                                                alt="user">
                                        </div>
                                        <div class="list-content flex-grow-1 py-0 pl15 pl0-lg">
                                            <h6 class="list-title mb-0">{{ $u->name ?? 'User' }}
                                                (#{{ $u->id }})
                                            </h6>
                                            <p class="mb-0 lh-1"><small>{{ $u->email ?? '' }}</small></p>
                                        </div>
                                    </div>
                                    <hr class="opacity-100 mt-0 mb10">
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <h3>Welcome, {{ auth()->user()->name }}!</h3>
                            <p class="mt-2">Your dashboard is ready. Let’s get started.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <x-slot name="script">
        <script>
            // Custom JS if needed
        </script>
    </x-slot>
</x-app-layout>
