<x-app-layout>
    <x-slot name="title">{{ __('Flat Pricing History') . ' ' . __('Management') }}</x-slot>

    ```
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Flat Pricing History') . ' ' . __('Management') }}
            </h2>

            @canany(['flat-pricing-histories.*', 'flat-pricing-histories.create'])
                <a href="{{ route('flat-pricing-histories.create') }}" class="ud-btn btn-light-thm py-1 px-3">
                    <i class="fa-solid fa-plus me-2 ms-0"></i>Add new
                </a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">

            {{-- Advanced Search --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <form method="GET" action="{{ route('flat-pricing-histories.index') }}"
                    class="form-style1 compact g-3">

                    <div class="row">

                        <div class="col-md-3">
                            <div class="mb20">
                                <select name="flat_id" class="form-control h-auto">
                                    <option value="">All Flats</option>

                                    @foreach ($flats as $flat)
                                        <option value="{{ $flat->id }}"
                                            {{ request('flat_id') == $flat->id ? 'selected' : '' }}>
                                            {{ $flat->flat_no }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" name="per_page">
                                        <option value="">Default (25)</option>
                                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100
                                        </option>
                                        <option value="500" {{ request('per_page') == '500' ? 'selected' : '' }}>500
                                        </option>
                                        <option value="1000" {{ request('per_page') == '1000' ? 'selected' : '' }}>
                                            1000</option>
                                        <option value="5000" {{ request('per_page') == '5000' ? 'selected' : '' }}>
                                            5000</option>
                                        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                            All Records
                                        </option>
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
                        <h5 class="mb-1">Flat Pricing Summary</h5>
                        <p class="text-muted mb-0">
                            A quick overview of pricing history records for the current filters.
                        </p>
                    </div>

                    @php
                        if (!isset($historiesTotal)) {
                            $historiesTotal = method_exists($histories, 'total')
                                ? $histories->total()
                                : $histories->count();
                        }
                    @endphp

                    <div class="text-end">
                        <small class="text-muted">
                            Showing {{ $historiesTotal }} records
                        </small>
                    </div>

                </div>

                <div class="row g-3">

                    <div class="col-md-4">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Total Records</small>
                                    <div class="h5 mb-0">
                                        {{ $summary->total_count ?? $historiesTotal }}
                                    </div>
                                </div>

                                <div class="text-muted">
                                    <i class="fas fa-history fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Average Price</small>
                            <div class="h5 mb-0">
                                {{ number_format($summary->avg_price ?? 0, 2) }}
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Latest Price</small>
                            <div class="h5 mb-0">
                                {{ number_format($summary->latest_price ?? 0, 2) }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Flat Pricing Histories --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">

                <div class="d-flex justify-content-between align-items-center">

                    <h5 class="list-title mt-2">
                        {{ __('Flat Pricing Histories') }}
                    </h5>
                </div>

                <p class="text-muted">
                    A list of all flat pricing history entries.
                </p>

                <div class="packages_table table-responsive">

                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">

                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Flat</th>
                                <th>Price</th>
                                <th>Effective Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">

                            @php
                                $i = $histories->firstItem() ?? 0;
                            @endphp

                            @foreach ($histories as $history)
                                <tr class="text-center">

                                    <td>{{ ++$i }}</td>

                                    <td>{{ $history->flat->flat_no ?? '-' }}</td>

                                    <td>{{ number_format($history->price, 2) }}</td>

                                    <td>
                                        {{ $history->effective_date?->format('d M Y') }}
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center">

                                            @canany(['flat-pricing-histories.*', 'flat-pricing-histories.show'])
                                                <a href="{{ route('flat-pricing-histories.show', $history->id) }}"
                                                    class="icon me-2" data-bs-toggle="tooltip" title="View">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['flat-pricing-histories.*', 'flat-pricing-histories.destroy'])
                                                <form action="{{ route('flat-pricing-histories.destroy', $history->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a href="#" class="icon" data-bs-toggle="tooltip" title="Delete"
                                                        data-confirm data-confirm-title="Delete entry?"
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
                    @if (method_exists($histories, 'onFirstPage'))

                        <div class="mbp_pagination mt30 text-center">

                            <ul class="page_navigation">

                                @if ($histories->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link">
                                            <span class="fas fa-angle-left"></span>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $histories->previousPageUrl() }}">
                                            <span class="fas fa-angle-left"></span>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($histories->getUrlRange(1, $histories->lastPage()) as $page => $url)
                                    <li class="page-item {{ $histories->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                @if ($histories->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $histories->nextPageUrl() }}">
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
                                {{ $histories->firstItem() }}
                                –
                                {{ $histories->lastItem() }}
                                of
                                {{ $histories->total() }}
                                Flat Pricing History Records
                            </p>

                        </div>
                    @else
                        <div class="mbp_pagination mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $historiesTotal }} records
                            </p>
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>
    ```

</x-app-layout>
