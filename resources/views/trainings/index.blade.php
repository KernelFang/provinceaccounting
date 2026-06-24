<x-app-layout>
    <x-slot name="title">{{ __('Trainings') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Trainings') . ' ' . __('Management') }}
            </h2>
            @canany(['trainings.*', 'trainings.create'])
                <a href="{{ route('trainings.create') }}" class="ud-btn btn-light-thm py-1 px-3"><i
                        class="fa-solid fa-plus me-2 ms-0" style="transform: rotate(0)"></i>Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">

            {{-- Advanced Search --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <form method="GET" action="{{ route('trainings.index') }}" class="form-style1 compact g-3">
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
                                    <select class="selectpicker" data-live-search="true" name="training_type"
                                        id="training_type">
                                        <option value="">All types</option>
                                        @foreach ($trainingTypes ?? [] as $t)
                                            <option value="{{ $t->name }}"
                                                {{ request('training_type') == $t->name ? 'selected' : '' }}>
                                                {{ $t->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
                                <input type="text" name="customer_name" value="{{ request('customer_name') }}"
                                    class="form-control h-auto" placeholder="Customer Name">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="customer_number" value="{{ request('customer_number') }}"
                                    class="form-control h-auto" placeholder="Customer Number">
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

                        {{-- <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="min_price" value="{{ request('min_price') }}"
                                    class="form-control h-auto" placeholder="Min price">
                            </div>
                        </div> --}}

                        <div class="col-md-auto">
                            <div class="mb20">
                                <div class="switch-style1"
                                    style="border: 1px solid #e9ecef;padding: 0 10px;border-radius: 4px;background: #e9ecef4a;">
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="has_due" value="1"
                                            id="has_due_trainings" {{ request()->filled('has_due') ? 'checked' : '' }}>
                                        <label class="form-check-label small text-muted" for="has_due_trainings"
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
                if (!isset($trainingsTotal)) {
                    $trainingsTotal = method_exists($trainings, 'total') ? $trainings->total() : $trainings->count();
                }
            @endphp
            @include('components.summary-cards', [
                'title' => 'Trainings Summary',
                'subtitle' => 'A quick report for the currently displayed records.',
                'showing' => $trainingsTotal,
                'cards' => [
                    ['label' => 'Total Records', 'value' => $summary->total_count ?? 0, 'unit' => '', 'col' => 3],
                    [
                        'label' => 'Total Price',
                        'value' => number_format($summary->total_price ?? 0, 2),
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
                ],
            ])

            {{-- Trainings List --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Trainings') }}</h5>

                    @canany(['trainings.*', 'trainings.restore', 'trainings.force-delete'])
                        <div class="d-flex gap-2">
                            <a href="{{ route('trainings.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                            <a href="{{ route('trainings.index', array_merge(request()->query(), ['with_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-secondary">With Trashed</a>
                            <a href="{{ route('trainings.index', array_merge(request()->query(), ['only_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-danger">Only Trashed</a>
                        </div>
                    @endcanany
                </div>

                <p class="text-muted">A list of all the {{ __('Trainings') }}.</p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Purchase Date</th>
                                <th>Type</th>
                                <th>Title</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">
                            @php $i = 0; @endphp
                            @foreach ($trainings as $training)
                                <tr class="text-center">
                                    <td>{{ ++$i }}</td>
                                    <td>
                                        {{ $training->purchase_date ? $training->purchase_date->format('d M Y') : 'N/A' }}
                                    </td>
                                    <td>{{ $training->training_type ?? 'N/A' }}</td>
                                    <td>{{ $training->title ?? 'N/A' }}</td>
                                    <td>{{ number_format($training->customer_price ?? 0, 2) }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['trainings.*', 'trainings.show'])
                                                <a href="{{ route('trainings.show', $training->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" title="View">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['trainings.*', 'trainings.edit'])
                                                <a href="{{ route('trainings.edit', $training->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany

                                            @canany(['trainings.*', 'trainings.destroy'])
                                                <form action="{{ route('trainings.destroy', $training->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="icon" data-bs-toggle="tooltip"
                                                        title="Delete" data-confirm data-confirm-title="Delete training?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!"><span
                                                            class="fas fa-trash text-danger"></span></a>
                                                </form>
                                            @endcanany

                                            @if (method_exists($training, 'trashed') && $training->trashed())
                                                @canany(['trainings.*', 'trainings.restore', 'trainings.force-delete'])
                                                    <x-delete-restore-buttons routePrefix="trainings" :model="$training" />
                                                @endcanany
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    @if (method_exists($trainings, 'total'))
                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">
                                @if ($trainings->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-left"></span></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $trainings->previousPageUrl() }}">
                                            <span class="fas fa-angle-left"></span>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($trainings->getUrlRange(1, $trainings->lastPage()) as $page => $url)
                                    <li class="page-item {{ $trainings->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($trainings->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $trainings->nextPageUrl() }}">
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
                                {{ $trainings->firstItem() }} – {{ $trainings->lastItem() }}
                                of {{ $trainings->total() }} Trainings
                            </p>
                        </div>
                    @else
                        {{-- When "All Records" is selected --}}
                        <div class="mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $trainingsTotal }} Trainings
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
