<x-app-layout>
    <x-slot name="title">{{ __('Income') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Income') . ' ' . __('Management') }}
            </h2>

            @canany(['incomes.*', 'incomes.create'])
                <a href="{{ route('incomes.create') }}" class="ud-btn btn-light-thm py-1 px-3">
                    <i class="fa-solid fa-plus me-2 ms-0"></i>
                    Add new
                </a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">

            {{-- Advanced Search --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <form method="GET" action="{{ route('incomes.index') }}" class="form-style1 compact g-3">
                    <div class="row">

                        <div class="col-md-3">
                            <div class="mb20">
                                <select name="project_id" class="form-control h-auto">
                                    <option value="">All Projects</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}"
                                            {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb20">
                                <select name="client_id" class="form-control h-auto">
                                    <option value="">All Clients</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}"
                                            {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                            {{ $client->first_name }} {{ $client->last_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <select name="clearing_status" class="form-control h-auto">
                                    <option value="">All Status</option>
                                    <option value="pending"
                                        {{ request('clearing_status') == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="cleared"
                                        {{ request('clearing_status') == 'cleared' ? 'selected' : '' }}>
                                        Cleared
                                    </option>
                                    <option value="bounced"
                                        {{ request('clearing_status') == 'bounced' ? 'selected' : '' }}>
                                        Bounced
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <select class="form-control h-auto" name="per_page">
                                    <option value="">Default (25)</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    <option value="500" {{ request('per_page') == 500 ? 'selected' : '' }}>500</option>
                                    <option value="1000" {{ request('per_page') == 1000 ? 'selected' : '' }}>1000</option>
                                    <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                        All Records
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <div class="mb20">
                                <button type="submit" class="btn ud-btn btn-light-thm px-3">
                                    <i class="fa-solid fa-search me-2 ms-0"></i>
                                    Search
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>

            {{-- Summary --}}
            <div class="ps-widget bg-white bdrs4 p20 mb20 overflow-hidden position-relative">

                <div class="d-flex align-items-start justify-content-between mb-3">
                    <div>
                        <h5 class="mb-1">Income Summary</h5>
                        <p class="text-muted mb-0">
                            A quick overview of income records for the current filters.
                        </p>
                    </div>

                    @php
                        $incomeTotal = method_exists($incomes, 'total')
                            ? $incomes->total()
                            : $incomes->count();
                    @endphp

                    <div class="text-end">
                        <small class="text-muted">
                            Showing {{ $incomeTotal }} records
                        </small>
                    </div>
                </div>

                <div class="row g-3">

                    <div class="col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Total Records</small>
                                    <div class="h5 mb-0">
                                        {{ $incomeSummary->total_count ?? 0 }}
                                    </div>
                                </div>

                                <div class="text-muted">
                                    <i class="fas fa-list fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Total Income</small>
                            <div class="h5 mb-0">
                                {{ number_format($incomeSummary->total_amount ?? 0, 2) }}
                                <small class="text-muted">TK.</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Cleared</small>
                            <div class="h5 mb-0 text-success">
                                {{ number_format($clearedAmount ?? 0, 2) }}
                                <small class="text-muted">TK.</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Pending</small>
                            <div class="h5 mb-0 text-warning">
                                {{ number_format($pendingAmount ?? 0, 2) }}
                                <small class="text-muted">TK.</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Income List --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">Incomes</h5>
                </div>

                <p class="text-muted">
                    A list of all income entries.
                </p>

                <div class="packages_table table-responsive">

                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Project</th>
                                <th>Flat</th>
                                <th>Client</th>
                                <th>Amount (TK.)</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">
                            @php
                                $i = $incomes->firstItem() ? $incomes->firstItem() - 1 : 0;
                            @endphp

                            @foreach ($incomes as $income)
                                <tr class="text-center">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $income->invoice_no }}</td>
                                    <td>{{ $income->project?->name ?? '-' }}</td>
                                    <td>{{ $income->flat?->flat_no ?? '-' }}</td>
                                    <td>{{ $income->client?->first_name ?? '-' }}</td>
                                    <td>{{ number_format($income->price, 2) }}</td>

                                    <td>
                                        <span class="badge bg-{{
                                            $income->clearing_status == 'cleared'
                                                ? 'success'
                                                : ($income->clearing_status == 'pending'
                                                    ? 'warning'
                                                    : 'danger')
                                        }}">
                                            {{ ucfirst($income->clearing_status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center">

                                            @canany(['incomes.*', 'incomes.show'])
                                                <a href="{{ route('incomes.show', $income->id) }}"
                                                    class="icon me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="View">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['incomes.*', 'incomes.edit'])
                                                <a href="{{ route('incomes.edit', $income->id) }}"
                                                    class="icon me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany

                                            @canany(['incomes.*', 'incomes.destroy'])
                                                <form action="{{ route('incomes.destroy', $income->id) }}"
                                                    method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a href="#"
                                                        class="icon"
                                                        data-confirm
                                                        data-confirm-title="Delete income?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <span class="fas fa-trash text-danger"></span>
                                                    </a>
                                                </form>
                                            @endcanany

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Custom Pagination --}}
                    @if (method_exists($incomes, 'onFirstPage'))

                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">

                                @if ($incomes->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link">
                                            <span class="fas fa-angle-left"></span>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $incomes->previousPageUrl() }}">
                                            <span class="fas fa-angle-left"></span>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($incomes->getUrlRange(1, $incomes->lastPage()) as $page => $url)
                                    <li class="page-item {{ $incomes->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                @if ($incomes->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $incomes->nextPageUrl() }}">
                                            <span class="fas fa-angle-right"></span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <span class="page-link">
                                            <span class="fas fa-angle-right"></span>
                                        </span>
                                    </li>
                                @endif

                            </ul>

                            <p class="mt10 mb-0 pagination_page_count text-center">
                                {{ $incomes->firstItem() }}
                                –
                                {{ $incomes->lastItem() }}
                                of
                                {{ $incomes->total() }}
                                Income Entries
                            </p>
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>