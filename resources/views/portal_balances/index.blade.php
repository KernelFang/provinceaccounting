<x-app-layout>
    <x-slot name="title">{{ __('Portal Balance') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portal Balance') . ' ' . __('Management') }}</h2>
            @canany(['portal-balances.*', 'portal-balances.create'])
                <a href="{{ route('portal-balances.create') }}" class="ud-btn btn-light-thm py-1 px-3"><i
                        class="fa-solid fa-plus me-2 ms-0" style="transform: rotate(0)"></i>Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">

            {{-- Advanced Search --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <form method="GET" action="{{ route('portal-balances.index') }}" class="form-style1 compact g-3">
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
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" data-live-search="true" name="portal" id="portal">
                                        <option value="">All portals</option>
                                        @foreach ($portals ?? [] as $p)
                                            <option value="{{ $p->name }}"
                                                {{ request('portal') == $p->name ? 'selected' : '' }}>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="min_recharge" value="{{ request('min_recharge') }}"
                                    class="form-control h-auto" placeholder="Min recharge">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="max_recharge" value="{{ request('max_recharge') }}"
                                    class="form-control h-auto" placeholder="Max recharge">
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

            @php
                $cards = [
                    ['label' => 'Total Records', 'value' => $summary->total_count ?? 0, 'unit' => '', 'col' => 3],
                    [
                        'label' => 'Total Recharge',
                        'value' => number_format($summary->total_recharge ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Average Recharge',
                        'value' => number_format($summary->avg_recharge ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Recharge Count',
                        'value' => $summary->recharge_count ?? 0,
                        'unit' => '',
                        'col' => 3,
                    ],
                ];

                if (!empty($portalBalances)) {
                    foreach ($portalBalances as $pb) {
                        $cards[] = [
                            'label' => $pb->label,
                            'value' => number_format($pb->current ?? 0, 2),
                            'unit' => 'TK.',
                            'col' => 3,
                            'note' =>
                                'Total Recharge: ' .
                                number_format($pb->balance ?? 0, 2) .
                                ' TK. Sales: ' .
                                number_format($pb->sales ?? 0, 2),
                        ];
                    }
                }
            @endphp

            @php
                if (!isset($itemsTotal)) {
                    $itemsTotal = method_exists($items, 'total') ? $items->total() : $items->count();
                }
            @endphp
            @include('components.summary-cards', [
                'title' => 'Portal Balances Summary',
                'subtitle' => 'Summary for the currently displayed portal transactions.',
                'showing' => $itemsTotal,
                'cards' => $cards,
            ])

            {{-- Portal Balance List --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Portal Balances') }}</h5>

                    @canany(['portal-balances.*', 'portal-balances.restore', 'portal-balances.force-delete'])
                        <div class="d-flex gap-2">
                            <a href="{{ route('portal-balances.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                            <a href="{{ route('portal-balances.index', array_merge(request()->query(), ['with_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-secondary">With Trashed</a>
                            <a href="{{ route('portal-balances.index', array_merge(request()->query(), ['only_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-danger">Only Trashed</a>
                        </div>
                    @endcanany
                </div>

                <p class="text-muted">Portal recharge and expense transactions.</p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Date</th>
                                <th>Portal</th>
                                <th>Transaction Platform</th>
                                <th>Transaction Type</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">
                            @php $i = 0; @endphp
                            @foreach ($items as $item)
                                <tr class="text-center">
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        {{ $item->date ? $item->date->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td {{-- class="text-start" --}}>{{ $item->portal ?? 'N/A' }}</td>
                                    <td>{{ $item->info ?? 'N/A' }}</td>
                                    <td>{{ ucfirst($item->transaction_type) }}</td>
                                    <td>{{ number_format($item->recharge, 2) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['portal-balances.*', 'portal-balances.show'])
                                                <a href="{{ route('portal-balances.show', $item->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" title="View">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['portal-balances.*', 'portal-balances.edit'])
                                                <a href="{{ route('portal-balances.edit', $item->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany

                                            @canany(['portal-balances.*', 'portal-balances.destroy'])
                                                <form action="{{ route('portal-balances.destroy', $item->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="icon" data-bs-toggle="tooltip"
                                                        title="Delete" data-confirm data-confirm-title="Delete record?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <span class="fas fa-trash text-danger"></span>
                                                    </a>
                                                </form>
                                            @endcanany

                                            @if (method_exists($item, 'trashed') && $item->trashed())
                                                @canany(['portal-balances.*', 'portal-balances.restore',
                                                    'portal-balances.force-delete'])
                                                    <x-delete-restore-buttons routePrefix="portal-balances"
                                                        :model="$item" />
                                                @endcanany
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if (method_exists($items, 'total'))
                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">
                                @if ($items->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-left"></span></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $items->previousPageUrl() }}">
                                            <span class="fas fa-angle-left"></span>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                                    <li class="page-item {{ $items->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($items->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $items->nextPageUrl() }}">
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
                                {{ $items->firstItem() }} – {{ $items->lastItem() }}
                                of {{ $items->total() }} Records
                            </p>
                        </div>
                    @else
                        {{-- When "All Records" is selected --}}
                        <div class="mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $itemsTotal }} Portal Balances
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
