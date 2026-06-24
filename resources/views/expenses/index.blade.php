<x-app-layout>
    <x-slot name="title">{{ __('Expense') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Expense') . ' ' . __('Management') }}
            </h2>
            @canany(['expenses.*', 'expenses.create'])
                <a href="{{ route('expenses.create') }}" class="ud-btn btn-light-thm py-1 px-3"><i
                        class="fa-solid fa-plus me-2 ms-0" style="transform: rotate(0)"></i>Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <!-- Advanced Search Form -->
                <form method="GET" action="{{ route('expenses.index') }}" class="form-style1 compact g-3">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb20">
                                <div class="input-group border rounded">
                                    <span class="input-group-text border-0">
                                        <i class="fa fa-calendar-alt"></i>
                                    </span>
                                    <input type="text" name="date_range"
                                        class="form-control daterangepicker-field pe-4 h-auto" placeholder="Date Range"
                                        data-start="{{ isset($start) ? $start->format('m/d/Y') : now()->startOfMonth()->format('m/d/Y') }}"
                                        data-end="{{ isset($end) ? $end->format('m/d/Y') : now()->endOfMonth()->format('m/d/Y') }}"
                                        style="background: transparent; z-index: 1;">
                                    <span style="position: absolute; right: 10px; top: 12%; z-index: 0;">
                                        <i class="fa fa-caret-down"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="title" value="{{ request('title') }}"
                                    class="form-control h-auto" placeholder="Title">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" data-live-search="true" name="expense_type_id"
                                        id="expense_type_id">
                                        <option value="">All Types</option>
                                        @foreach ($categories ?? [] as $e)
                                            <option value="{{ $e->id }}"
                                                {{ request('expense_type_id') == $e->id ? 'selected' : '' }}>
                                                {{ $e->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="min_amount" value="{{ request('min_amount') }}"
                                    class="form-control h-auto" placeholder="Min amount">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="max_amount" value="{{ request('max_amount') }}"
                                    class="form-control h-auto" placeholder="Max amount">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" name="per_page" id="per_page">
                                        <option value="">Default (25)</option>
                                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100
                                        </option>
                                        <option value="500" {{ request('per_page') == '500' ? 'selected' : '' }}>500
                                        </option>
                                        <option value="1000" {{ request('per_page') == '1000' ? 'selected' : '' }}>
                                            1000</option>
                                        <option value="5000" {{ request('per_page') == '5000' ? 'selected' : '' }}>
                                            5000</option>
                                        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>All
                                            Records</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <div class="mb20">
                                <button type="submit" class="btn ud-btn btn-light-thm px-3"
                                    style="min-width: max-content;padding:6px;"><i class="fa-solid fa-search me-2 ms-0"
                                        style="transform: rotate(0)"></i>Search</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            @php
                if (!isset($expensesTotal)) {
                    $expensesTotal = method_exists($expenses, 'total') ? $expenses->total() : $expenses->count();
                }
            @endphp
            @include('components.summary-cards', [
                'title' => 'Expenses Summary',
                'subtitle' => 'Summary for the currently displayed expense records.',
                'showing' => $expensesTotal,
                'cards' => [
                    ['label' => 'Total Records', 'value' => $summary->total_count ?? 0, 'unit' => '', 'col' => 3],
                    [
                        'label' => 'Total Amount',
                        'value' => number_format($summary->total_amount ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Average Amount',
                        'value' => number_format($summary->avg_amount ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
            
                    [
                        'label' => 'Paid Total',
                        'value' => number_format($paymentBreakdown->paid_amount ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Paid Count',
                        'value' => $paymentBreakdown->paid_count ?? 0,
                        'unit' => '',
                        'col' => 3,
                    ],
            
                    [
                        'label' => 'Unpaid Total',
                        'value' => number_format($paymentBreakdown->unpaid_amount ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Unpaid Count',
                        'value' => $paymentBreakdown->unpaid_count ?? 0,
                        'unit' => '',
                        'col' => 3,
                    ],
            
                    [
                        'label' => 'Petty Cash Total',
                        'value' => number_format($paymentBreakdown->petty_amount ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Petty Cash Count',
                        'value' => $paymentBreakdown->petty_count ?? 0,
                        'unit' => '',
                        'col' => 3,
                    ],
                ],
            ])

            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Expenses') }}</h5>

                    @canany(['expense.*', 'expense.restore', 'expense.force-delete'])
                        <div class="d-flex gap-2">
                            <a href="{{ route('expenses.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                            <a href="{{ route('expenses.index', array_merge(request()->query(), ['with_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-secondary">With Trashed</a>
                            <a href="{{ route('expenses.index', array_merge(request()->query(), ['only_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-danger">Only Trashed</a>
                        </div>
                    @endcanany
                </div>

                <p class="text-muted">A list of all the {{ __('Expenses') }}.</p>
                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Category</th>
                                <th scope="col" class="text-center">Amount (TK.)</th>
                                <th scope="col" class="text-center">Date</th>
                                <th scope="col" class="text-center">Payment</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="t-body">
                            @php $i = 0; @endphp
                            @foreach ($expenses as $expense)
                                <tr class="text-center">
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        <h6 class="mb-0">{{ ucwords(strtolower($expense->title)) }}</h6>
                                    </td>
                                    <td>
                                        <h6 class="mb-0">
                                            {{ $expense->expenseType->name ?? ($expense->category ?? 'N/A') }}</h6>
                                    </td>
                                    <td>{{ number_format($expense->amount, 2) }} Taka</td>
                                    <td>{{ $expense->date ? $expense->date->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        @if ($expense->payment_status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($expense->payment_status === 'petty_cash')
                                            <span class="badge bg-secondary">Petty Cash</span>
                                        @else
                                            <span class="badge bg-danger">Unpaid</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['expenses.*', 'expenses.show'])
                                                <a href="{{ route('expenses.show', $expense->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Show expense details"><span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany
                                            @canany(['expenses.*', 'expenses.edit'])
                                                <a href="{{ route('expenses.edit', $expense->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany
                                            @canany(['expenses.*', 'expenses.destroy'])
                                                <form action="{{ route('expenses.destroy', $expense->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="icon" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Delete" data-confirm
                                                        data-confirm-title="Delete expense?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!"><span
                                                            class="fas fa-trash text-danger"></span></a>
                                                </form>
                                            @endcanany

                                            @if (method_exists($expense, 'trashed') && $expense->trashed())
                                                @canany(['expenses.*', 'expenses.restore', 'expenses.force-delete'])
                                                    <x-delete-restore-buttons routePrefix="expenses" :model="$expense" />
                                                @endcanany
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if (method_exists($expenses, 'total'))
                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">
                                <!-- Previous Page Link -->
                                @if ($expenses->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-left"></span></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $expenses->previousPageUrl() }}"><span
                                                class="fas fa-angle-left"></span></a>
                                    </li>
                                @endif

                                <!-- Page Number Links -->
                                @foreach ($expenses->getUrlRange(1, $expenses->lastPage()) as $page => $url)
                                    <li class="page-item {{ $expenses->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($expenses->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $expenses->nextPageUrl() }}"><span
                                                class="fas fa-angle-right"></span></a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-right"></span></span>
                                    </li>
                                @endif
                            </ul>
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                {{ $expenses->firstItem() }} – {{ $expenses->lastItem() }} of
                                {{ $expenses->total() }} Expenses
                            </p>
                        </div>
                    @else
                        {{-- When "All Records" is selected --}}
                        <div class="mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $expensesTotal }} Expenses
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
