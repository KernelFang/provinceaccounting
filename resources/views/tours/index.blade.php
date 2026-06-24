<x-app-layout>
    <x-slot name="title">{{ __('Tours / Hotels / Car') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tours / Hotels / Car') . ' ' . __('Management') }}</h2>
            @canany(['tours.*', 'tours.create'])
                <a href="{{ route('tours.create') }}" class="ud-btn btn-light-thm py-1 px-3"><i
                        class="fa-solid fa-plus me-2 ms-0" style="transform: rotate(0)"></i>Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">

            {{-- Advanced Search --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <form method="GET" action="{{ route('tours.index') }}" class="form-style1 compact g-3">
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
                                        style="background: transparent; z-index: 1; color: #697488 !important;">
                                    <span style="position: absolute; right: 10px; top: 12%; z-index: 0;">
                                        <i class="fa fa-caret-down"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" data-live-search="true" name="purpose" id="purpose">
                                        <option value="">All purposes</option>
                                        @foreach ($purposes ?? [] as $p)
                                            <option value="{{ $p->name }}"
                                                {{ request('purpose') == $p->name ? 'selected' : '' }}>
                                                {{ $p->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" data-live-search="true" name="country" id="country">
                                        <option value="">All countries</option>
                                        @foreach ($countries ?? [] as $c)
                                            <option value="{{ $c->name }}"
                                                {{ request('country') == $c->name ? 'selected' : '' }}>
                                                {{ $c->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="customer" value="{{ request('customer') }}"
                                    class="form-control h-auto" placeholder="Customer">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="customer_number" value="{{ request('customer_number') }}"
                                    class="form-control h-auto" placeholder="Customer Number">
                            </div>
                        </div>

                        {{-- <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="min_price" value="{{ request('min_price') }}"
                                    class="form-control h-auto" placeholder="Min price">
                            </div>
                        </div> --}}

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
                                <div class="switch-style1"
                                    style="border: 1px solid #e9ecef;padding: 0 10px;border-radius: 4px;background: #e9ecef4a;">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="has_due" value="1"
                                            id="has_due_tours" {{ request()->filled('has_due') ? 'checked' : '' }}>
                                        <label class="form-check-label small text-muted" for="has_due_tours"
                                            style="line-height: 38px !important;">
                                            Has due
                                        </label>
                                    </div>
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
                if (!isset($toursTotal)) {
                    $toursTotal = method_exists($tours, 'total') ? $tours->total() : $tours->count();
                }
            @endphp
            @include('components.summary-cards', [
                'title' => 'Tours Summary',
                'subtitle' => 'Summary for displayed tours.',
                'showing' => $toursTotal,
                'cards' => [
                    ['label' => 'Total Records', 'value' => $summary->total_count ?? 0, 'unit' => '', 'col' => 3],
                    [
                        'label' => 'Total Price',
                        'value' => number_format($summary->total_price ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Total Profit',
                        'value' => number_format($summary->total_profit ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Total Paid',
                        'value' => number_format($summary->total_paid ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Total Due',
                        'value' => number_format($summary->total_due ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                    [
                        'label' => 'Average Price',
                        'value' => number_format($summary->avg_price ?? 0, 2),
                        'unit' => 'TK.',
                        'col' => 3,
                    ],
                ],
            ])

            {{-- Tours List --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Tours / Hotels / Car') }}</h5>

                    @canany(['tours.*', 'tours.restore', 'tours.force-delete'])
                        <div class="d-flex gap-2">
                            <a href="{{ route('tours.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                            <a href="{{ route('tours.index', array_merge(request()->query(), ['with_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-secondary">With Trashed</a>
                            <a href="{{ route('tours.index', array_merge(request()->query(), ['only_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-danger">Only Trashed</a>
                        </div>
                    @endcanany
                </div>

                <p class="text-muted">A list of all Tours, Hotels and Car bookings.</p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Purpose</th>
                                <th>Country</th>
                                <th>Customer</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">
                            @php $i = 0; @endphp
                            @foreach ($tours as $tour)
                                <tr class="text-center">
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        {{ ucwords(strtolower($tour->purpose)) }}
                                    </td>
                                    <td>{{ $tour->country ?? 'N/A' }}</td>
                                    <td>{{ $tour->customer ?? 'N/A' }}</td>
                                    <td>{{ number_format($tour->customer_price, 2) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['tours.*', 'tours.show'])
                                                <a href="{{ route('tours.show', $tour->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" title="View">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['tours.*', 'tours.edit'])
                                                <a href="{{ route('tours.edit', $tour->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany

                                            @canany(['tours.*', 'tours.destroy'])
                                                <form action="{{ route('tours.destroy', $tour->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="icon" data-bs-toggle="tooltip"
                                                        title="Delete" data-confirm data-confirm-title="Delete booking?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <span class="fas fa-trash text-danger"></span>
                                                    </a>
                                                </form>
                                            @endcanany

                                            @if (method_exists($tour, 'trashed') && $tour->trashed())
                                                @canany(['tours.*', 'tours.restore', 'tours.force-delete'])
                                                    <x-delete-restore-buttons routePrefix="tours" :model="$tour" />
                                                @endcanany
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if (method_exists($tours, 'total'))
                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">
                                @if ($tours->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-left"></span></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $tours->previousPageUrl() }}">
                                            <span class="fas fa-angle-left"></span>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($tours->getUrlRange(1, $tours->lastPage()) as $page => $url)
                                    <li class="page-item {{ $tours->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($tours->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $tours->nextPageUrl() }}">
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
                                {{ $tours->firstItem() }} – {{ $tours->lastItem() }}
                                of {{ $tours->total() }} Records
                            </p>
                        </div>
                    @else
                        {{-- When "All Records" is selected --}}
                        <div class="mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $toursTotal }} Tours
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
