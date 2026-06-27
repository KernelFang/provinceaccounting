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

                @media print {
                    table {
                        width: 100% !important;
                        table-layout: fixed;
                        border-collapse: collapse;
                    }

                    .no-print {
                        display: none;
                    }

                    body {
                        margin: 0;
                        padding: 0;
                    }
                }
            </style>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" id="printable-area">
                <!-- Dashboard Summary Cards -->
                <div class="row">
                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Total Users</div>
                                <div class="title">{{ $totalUsers }}</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-cv"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Total Clients</div>
                                <div class="title">{{ $totalClients }}</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-man"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Total Projects</div>
                                <div class="title">{{ $totalProjects }}</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-folder"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Total Flats</div>
                                <div class="title">{{ $totalFlats }}</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-apartment"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Total Income</div>
                                <div class="title">{{ $totalIncomes }}</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-money"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Income This Month</div>
                                <div class="title text-success">{{ number_format($totalIncomeThisMonth, 2) }} Tk.</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-profit"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Total Expenses This Month</div>
                                <div class="title text-danger">{{ number_format($totalExpensesThisMonth, 2) }} Tk.</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-money"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Petty Cash Balance</div>
                                <div class="title {{ ($pettyBalance ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($pettyBalance ?? 0, 2) }} Tk.
                                </div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-wallet"></i></div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-xxl-3">
                        <div class="d-flex align-items-center justify-content-between statistics_funfact">
                            <div class="details">
                                <div class="fz15">Total Income (All Time)</div>
                                <div class="title text-success">{{ number_format($totalIncomeAllTime, 2) }} Tk.</div>
                            </div>
                            <div class="icon text-center"><i class="flaticon-profit"></i></div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Tables -->
                <div class="row mt-4">
                    <div class="col-12 col-md-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Recent Expenses</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 table-hover">
                                    <thead class="text-white text-center" style="background:#222d61;">
                                        <tr>
                                            <th class="text-start">Date</th>
                                            <th>Amount</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentExpenses as $expense)
                                            <tr>
                                                <td class="text-start">{{ $expense->date->format('M d, Y') }}</td>
                                                <td class="text-center">{{ number_format($expense->amount, 2) }} Tk.
                                                </td>
                                                <td class="text-center">
                                                    <small>{{ $expense->expenseType?->name ?? 'N/A' }}</small>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No recent expenses
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Recent Income</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 table-hover">
                                    <thead class="text-white text-center" style="background:#222d61;">
                                        <tr>
                                            <th class="text-start">Date</th>
                                            <th>Amount</th>
                                            <th>Method</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentIncomes as $income)
                                            <tr>
                                                <td class="text-start">{{ $income->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="text-center">{{ number_format($income->price, 2) }} Tk.
                                                </td>
                                                <td class="text-center">
                                                    <small>{{ $income->paymentMethod?->name ?? 'N/A' }}</small>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">No recent income
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Projects & Clients -->
                <div class="row mt-4">
                    <div class="col-12 col-md-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Recent Projects</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 table-hover">
                                    <thead class="text-white text-center" style="background:#222d61;">
                                        <tr>
                                            <th class="text-start">Name</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentProjects as $project)
                                            <tr>
                                                <td class="text-start">{{ $project->name }}</td>
                                                <td class="text-center">
                                                    <span class="badge bg-info">{{ ucfirst($project->status) }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">No recent projects
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Recent Clients</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 table-hover">
                                    <thead class="text-white text-center" style="background:#222d61;">
                                        <tr>
                                            <th class="text-start">Name</th>
                                            <th>Email</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentClients as $client)
                                            <tr>
                                                <td class="text-start">{{ $client->first_name }}
                                                    {{ $client->last_name }}</td>
                                                <td class="text-center"><small>{{ $client->email }}</small></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="2" class="text-center text-muted">No recent clients
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Expenses Report & Users Table -->
                <div class="row mt-4">
                    <div class="col-12 col-md-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Expenses Report by Type</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm mb-0">
                                    <thead class="text-white text-center" style="background:#222d61;">
                                        <tr>
                                            <th class="text-start ps-3">Expense Type</th>
                                            <th class="text-center">Count</th>
                                            <th class="text-center">Total Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center">
                                        @forelse ($expensesReport as $expense)
                                            <tr>
                                                <td class="text-start fw-semibold">{{ $expense->label }}</td>
                                                <td>{{ $expense->count }}</td>
                                                <td>{{ number_format($expense->total, 2) }} Tk.</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-muted">No expense data available</td>
                                            </tr>
                                        @endforelse
                                        <tr class="fw-bold" style="background:#f5f5f5;">
                                            <td class="text-start">Total</td>
                                            <td>{{ $expensesReportSums->total_count }}</td>
                                            <td>{{ number_format($expensesReportSums->total_amount, 2) }} Tk.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="ps-widget bgc-white bdrs4 p20 mb20 overflow-hidden position-relative">
                            <div class="d-flex justify-content-between align-items-center bdrb1 pb10 mb10">
                                <h5 class="title">Recent Users</h5>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm mb-0 table-hover">
                                    <thead class="text-white text-center" style="background:#222d61;">
                                        <tr>
                                            <th class="text-start">Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Joined</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentUsers as $user)
                                            <tr>
                                                <td class="text-start">{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td class="text-center"><span
                                                        class="badge bg-secondary">{{ ucfirst($user->user_type) }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <small>{{ $user->created_at->format('M d, Y') }}</small>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center text-muted">No recent users</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="ps-widget bgc-white bdrs4 p30 mb20">
                    <p class="text-center text-muted">Welcome! Dashboard data is only available for administrators.</p>
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
