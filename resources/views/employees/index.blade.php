<x-app-layout>
    <x-slot name="title">{{ __('Employees') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Employees') . ' ' . __('Management') }}
            </h2>
            @canany(['employees.*', 'employees.create'])
                <a href="{{ route('employees.create') }}" class="ud-btn btn-light-thm py-1 px-3">Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">

            {{-- Advanced Search --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <form method="GET" action="{{ route('employees.index') }}" class="form-style1 compact g-3">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb20">
                                <div class="input-group border rounded">
                                    <span class="input-group-text border-0">
                                        <i class="fa fa-calendar-alt"></i>
                                    </span>
                                    <input type="text" name="date_range"
                                        class="form-control daterangepicker-field pe-4 h-auto"
                                        placeholder="Joining Date Range"
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
                                <input type="text" name="employee_code" value="{{ request('employee_code') }}"
                                    class="form-control h-auto" placeholder="Employee Code">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="name" value="{{ request('name') }}"
                                    class="form-control h-auto" placeholder="Employee Name">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" data-live-search="true" name="department_id"
                                        id="department_id">
                                        <option value="">All departments</option>
                                        @foreach ($departments ?? [] as $d)
                                            <option value="{{ $d->id }}"
                                                {{ request('department_id') == $d->id ? 'selected' : '' }}>
                                                {{ $d->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" data-live-search="true" name="designation_id"
                                        id="designation_id">
                                        <option value="">All designations</option>
                                        @foreach ($designations ?? [] as $d)
                                            <option value="{{ $d->id }}"
                                                {{ request('designation_id') == $d->id ? 'selected' : '' }}>
                                                {{ $d->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
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

            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Employees') }}</h5>

                    @canany(['employees.*', 'employees.restore', 'employees.force-delete'])
                        <div class="d-flex gap-2">
                            <a href="{{ route('employees.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                            <a href="{{ route('employees.index', array_merge(request()->query(), ['with_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-secondary">With Trashed</a>
                            <a href="{{ route('employees.index', array_merge(request()->query(), ['only_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-danger">Only Trashed</a>
                        </div>
                    @endcanany
                </div>

                <p class="text-muted">A list of all the {{ __('Employees') }}.</p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Employee Code</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Designation</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">
                            @php $i = 0; @endphp
                            @foreach ($employees as $e)
                                <tr class="text-center">
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $e->employee_code }}</td>
                                    <td>{{ $e->name }}</td>
                                    <td>{{ optional($e->department)->name ?? 'N/A' }}</td>
                                    <td>{{ optional($e->designation)->title ?? 'N/A' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['employees.*', 'employees.show'])
                                                <a href="{{ route('employees.show', $e->id) }}" class="icon me-2"
                                                    title="View"><span class="fas fa-eye"></span></a>
                                            @endcanany

                                            @canany(['employees.*', 'employees.edit'])
                                                <a href="{{ route('employees.edit', $e->id) }}" class="icon me-2"
                                                    title="Edit"><span class="fas fa-pen"></span></a>
                                            @endcanany

                                            @canany(['employees.*', 'employees.destroy'])
                                                <form action="{{ route('employees.destroy', $e->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="icon" data-confirm
                                                        data-confirm-title="Delete?"
                                                        data-confirm-text="This cannot be undone"><span
                                                            class="fas fa-trash text-danger"></span></a>
                                                </form>
                                            @endcanany

                                            @if (method_exists($e, 'trashed') && $e->trashed())
                                                @canany(['employees.*', 'employees.restore', 'employees.force-delete'])
                                                    <x-delete-restore-buttons routePrefix="employees" :model="$e" />
                                                @endcanany
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        if (!isset($employeesTotal)) {
                            $employeesTotal = method_exists($employees, 'total')
                                ? $employees->total()
                                : $employees->count();
                        }
                    @endphp

                    @if (method_exists($employees, 'total'))
                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">
                                @if ($employees->onFirstPage())
                                    <li class="page-item"><span class="page-link"><span
                                                class="fas fa-angle-left"></span></span>
                                    </li>
                                @else
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $employees->previousPageUrl() }}"><span
                                                class="fas fa-angle-left"></span></a></li>
                                @endif

                                @foreach ($employees->getUrlRange(1, $employees->lastPage()) as $page => $url)
                                    <li class="page-item {{ $employees->currentPage() == $page ? 'active' : '' }}"><a
                                            class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                @if ($employees->hasMorePages())
                                    <li class="page-item"><a class="page-link"
                                            href="{{ $employees->nextPageUrl() }}"><span
                                                class="fas fa-angle-right"></span></a></li>
                                @else
                                    <li class="page-item"><span class="page-link"><span
                                                class="fas fa-angle-right"></span></span></li>
                                @endif
                            </ul>

                            <p class="mt10 mb-0 pagination_page_count text-center">
                                {{ $employees->firstItem() }} – {{ $employees->lastItem() }} of
                                {{ $employees->total() }}
                                Records
                            </p>
                        </div>
                    @else
                        {{-- When "All Records" is selected --}}
                        <div class="mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $employeesTotal }} Employees
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
