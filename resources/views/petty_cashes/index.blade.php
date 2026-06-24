<x-app-layout>
    <x-slot name="title">{{ __('Petty Cash') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Petty Cash') . ' ' . __('Management') }}
            </h2>
            @canany(['petty-cashes.*', 'petty-cashes.create'])
                <a href="{{ route('petty-cashes.create') }}" class="ud-btn btn-light-thm py-1 px-3"><i
                        class="fa-solid fa-plus me-2 ms-0" style="transform: rotate(0)"></i>Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">

            {{-- Advanced Search --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <form method="GET" action="{{ route('petty-cashes.index') }}" class="form-style1 compact g-3">
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

                        <div class="col-md-3">
                            <div class="mb20">
                                <input type="text" name="title" value="{{ request('title') }}"
                                    class="form-control h-auto" placeholder="Title">
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
                                    style="min-width:max-content;padding:6px;">
                                    <i class="fa-solid fa-search me-2 ms-0"></i>Search
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
                        <h5 class="mb-1">Petty Cash Summary</h5>
                        <p class="text-muted mb-0">A quick overview of petty cash status for the current
                            filters.</p>
                    </div>
                    @php
                        if (!isset($pettyCashesTotal)) {
                            $pettyCashesTotal = method_exists($pettyCashes, 'total')
                                ? $pettyCashes->total()
                                : $pettyCashes->count();
                        }
                    @endphp
                    <div class="text-end">
                        <small class="text-muted">Showing {{ $pettyCashesTotal }} records</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Total Records</small>
                                    <div class="h5 mb-0">{{ $summary->total_count ?? 0 }}</div>
                                </div>
                                <div class="text-muted"><i class="fas fa-list fa-2x"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Total Amount</small>
                            <div class="h5 mb-0">{{ number_format($summary->total_amount ?? 0, 2) }} <small
                                    class="text-muted">TK.</small></div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Total Added</small>
                            <div class="h5 mb-0">{{ number_format($totalAdded ?? 0, 2) }} <small
                                    class="text-muted">TK.</small></div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Total Used</small>
                            <div class="h5 mb-0 text-danger">{{ number_format($totalUsed ?? 0, 2) }} <small
                                    class="text-muted">TK.</small></div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 h-100 bdrs4 bg-white border">
                            <small class="text-muted">Current Balance</small>
                            <div
                                class="h4 mb-0 {{ (float) ($pettyBalance ?? 0) < 0 ? 'text-danger' : 'text-success' }}">
                                {{ number_format($pettyBalance ?? 0, 2) }} <small class="text-muted">TK.</small>
                            </div>
                            <p class="mb-0 text-muted small">Balance = Total Added − Total Used</p>
                        </div>
                    </div>

                    <div class="col-12 col-md-6">
                        <div class="p-3 h-100 bdrs4 bg-white border">
                            <small class="text-muted">Average Amount</small>
                            <div class="h5 mb-0">{{ number_format($summary->avg_amount ?? 0, 2) }} <small
                                    class="text-muted">TK.</small></div>
                            <p class="mb-0 text-muted small">Average per displayed entry</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Petty Cash List --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Petty Cashes') }}</h5>

                    @canany(['petty-cashes.*', 'petty-cashes.restore', 'petty-cashes.force-delete'])
                        <div class="d-flex gap-2">
                            <a href="{{ route('petty-cashes.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                            <a href="{{ route('petty-cashes.index', array_merge(request()->query(), ['with_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-secondary">With Trashed</a>
                            <a href="{{ route('petty-cashes.index', array_merge(request()->query(), ['only_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-danger">Only Trashed</a>
                        </div>
                    @endcanany
                </div>

                <p class="text-muted">A list of all petty cash entries.</p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Title</th>
                                <th class="text-center">Amount (TK.)</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">
                            @php $i = 0; @endphp
                            @foreach ($pettyCashes as $pettyCash)
                                <tr class="text-center">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ ucwords(strtolower($pettyCash->title)) }}</td>
                                    <td>{{ number_format($pettyCash->amount, 2) }}</td>
                                    <td>{{ $pettyCash->date ? $pettyCash->date->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['petty-cashes.*', 'petty-cashes.show'])
                                                <a href="{{ route('petty-cashes.show', $pettyCash->id) }}"
                                                    class="icon me-2" data-bs-toggle="tooltip" title="View">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['petty-cashes.*', 'petty-cashes.edit'])
                                                <a href="{{ route('petty-cashes.edit', $pettyCash->id) }}"
                                                    class="icon me-2" data-bs-toggle="tooltip" title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany

                                            @canany(['petty-cashes.*', 'petty-cashes.destroy'])
                                                <form action="{{ route('petty-cashes.destroy', $pettyCash->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="icon" data-bs-toggle="tooltip"
                                                        title="Delete" data-confirm data-confirm-title="Delete entry?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <span class="fas fa-trash text-danger"></span>
                                                    </a>
                                                </form>
                                            @endcanany

                                            {{-- If the model is soft deleted, show restore/force-delete buttons --}}
                                            @if (method_exists($pettyCash, 'trashed') && $pettyCash->trashed())
                                                @canany(['petty-cashes.*', 'petty-cashes.restore',
                                                    'petty-cashes.force-delete'])
                                                    <x-delete-restore-buttons routePrefix="petty-cashes"
                                                        :model="$pettyCash" />
                                                @endcanany
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Custom Pagination --}}
                    @if (method_exists($pettyCashes, 'onFirstPage'))
                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">
                                @if ($pettyCashes->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-left"></span></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pettyCashes->previousPageUrl() }}">
                                            <span class="fas fa-angle-left"></span>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($pettyCashes->getUrlRange(1, $pettyCashes->lastPage()) as $page => $url)
                                    <li class="page-item {{ $pettyCashes->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($pettyCashes->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pettyCashes->nextPageUrl() }}">
                                            <span class="fas fa-angle-right"></span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-right"></span></span>
                                    </li>
                                @endif
                            </ul>

                            <p class="mt10 mb-0 pagination_page_count text-center">
                                {{ $pettyCashes->firstItem() }} – {{ $pettyCashes->lastItem() }}
                                of {{ $pettyCashes->total() }} Petty Cash Entries
                            </p>
                        </div>
                    @else
                        <div class="mbp_pagination mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all
                                {{ $pettyCashesTotal ?? (method_exists($pettyCashes, 'total') ? $pettyCashes->total() : $pettyCashes->count()) }}
                                Petty Cash Entries
                            </p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
