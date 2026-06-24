<x-app-layout>
    <x-slot name="title">{{ __('Flats') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Flats') . ' ' . __('Management') }}
            </h2>

            @canany(['flats.*', 'flats.create'])
                <a href="{{ route('flats.create') }}" class="ud-btn btn-light-thm py-1 px-3">
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

                <form method="GET" action="{{ route('flats.index') }}" class="form-style1 compact g-3">
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
                                <select name="client_owner_status" class="form-control h-auto">
                                    <option value="">All Status</option>
                                    <option value="pending"
                                        {{ request('client_owner_status') == 'pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="ongoing"
                                        {{ request('client_owner_status') == 'ongoing' ? 'selected' : '' }}>
                                        Ongoing
                                    </option>
                                    <option value="cancelled"
                                        {{ request('client_owner_status') == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled
                                    </option>
                                    <option value="completed"
                                        {{ request('client_owner_status') == 'completed' ? 'selected' : '' }}>
                                        Completed
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb20">
                                <input type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    class="form-control h-auto"
                                    placeholder="Search building, flat no">
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <div class="mb20">
                                <button type="submit"
                                    class="btn ud-btn btn-light-thm px-3"
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
                        <h5 class="mb-1">Flats Summary</h5>
                        <p class="text-muted mb-0">
                            A quick overview of flats for the current filters.
                        </p>
                    </div>

                    @php
                        if (!isset($flatsTotal)) {
                            $flatsTotal = method_exists($flats, 'total')
                                ? $flats->total()
                                : $flats->count();
                        }
                    @endphp

                    <div class="text-end">
                        <small class="text-muted">
                            Showing {{ $flatsTotal }} records
                        </small>
                    </div>
                </div>

                <div class="row g-3">

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Total Flats</small>
                                    <div class="h5 mb-0">
                                        {{ $summary->total_flats ?? $flatsTotal }}
                                    </div>
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-building fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Total Value</small>
                            <div class="h5 mb-0">
                                {{ number_format($summary->total_value ?? 0, 2) }}
                                <small class="text-muted">TK.</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Sold Flats</small>
                            <div class="h5 mb-0">
                                {{ $summary->sold_flats ?? 0 }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Available Flats</small>
                            <div class="h5 mb-0 text-success">
                                {{ $summary->available_flats ?? 0 }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Flats List --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Flats') }}</h5>
                </div>

                <p class="text-muted">
                    A list of all flats.
                </p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">

                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Flat No</th>
                                <th>Project</th>
                                <th>Owner</th>
                                <th>Price (TK.)</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">

                            @php
                                $i = method_exists($flats, 'firstItem')
                                    ? ($flats->firstItem() - 1)
                                    : 0;
                            @endphp

                            @foreach ($flats as $flat)
                                <tr class="text-center">

                                    <td>{{ ++$i }}</td>

                                    <td>{{ $flat->flat_no }}</td>

                                    <td>{{ $flat->project->name ?? '-' }}</td>

                                    <td>{{ $flat->currentOwner?->first_name ?? '-' }}</td>

                                    <td>{{ number_format($flat->base_price ?? 0, 2) }}</td>

                                    <td>
                                        <div class="d-flex justify-content-center">

                                            @canany(['flats.*', 'flats.show'])
                                                <a href="{{ route('flats.show', $flat->id) }}"
                                                    class="icon me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="View">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['flats.*', 'flats.edit'])
                                                <a href="{{ route('flats.edit', $flat->id) }}"
                                                    class="icon me-2"
                                                    data-bs-toggle="tooltip"
                                                    title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany

                                            @canany(['flats.*', 'flats.destroy'])
                                                <form action="{{ route('flats.destroy', $flat->id) }}"
                                                    method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a href="#"
                                                        class="icon"
                                                        data-confirm
                                                        data-confirm-title="Delete flat?"
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
                    @if (method_exists($flats, 'onFirstPage'))

                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">

                                @if ($flats->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link">
                                            <span class="fas fa-angle-left"></span>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $flats->previousPageUrl() }}">
                                            <span class="fas fa-angle-left"></span>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($flats->getUrlRange(1, $flats->lastPage()) as $page => $url)
                                    <li class="page-item {{ $flats->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                @if ($flats->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $flats->nextPageUrl() }}">
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
                                {{ $flats->firstItem() }} – {{ $flats->lastItem() }}
                                of {{ $flats->total() }} Flats
                            </p>
                        </div>

                    @else

                        <div class="mbp_pagination mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $flatsTotal }} Flats
                            </p>
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
