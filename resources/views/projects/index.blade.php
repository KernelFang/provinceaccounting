<x-app-layout>

    <x-slot name="title">{{ __('Projects') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Projects') . ' ' . __('Management') }}
            </h2>

            @canany(['projects.*', 'projects.create'])
                <a href="{{ route('projects.create') }}" class="ud-btn btn-light-thm py-1 px-3">
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

                <form method="GET" action="{{ route('projects.index') }}" class="form-style1 compact g-3">
                    <div class="row">

                        <div class="col-md-4">
                            <div class="mb20">
                                <input type="text"
                                       name="search"
                                       value="{{ request('search') }}"
                                       class="form-control h-auto"
                                       placeholder="Search Project">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" name="status">
                                        <option value="">All Status</option>
                                        <option value="pending"
                                            {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="ongoing"
                                            {{ request('status') == 'ongoing' ? 'selected' : '' }}>
                                            Ongoing
                                        </option>
                                        <option value="completed"
                                            {{ request('status') == 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <div class="bootselect-multiselect">
                                    <select class="selectpicker" name="per_page">
                                        <option value="">Default (25)</option>
                                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100</option>
                                        <option value="500" {{ request('per_page') == '500' ? 'selected' : '' }}>500</option>
                                        <option value="1000" {{ request('per_page') == '1000' ? 'selected' : '' }}>1000</option>
                                        <option value="5000" {{ request('per_page') == '5000' ? 'selected' : '' }}>5000</option>
                                        <option value="all" {{ request('per_page') == 'all' ? 'selected' : '' }}>
                                            All Records
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-auto">
                            <div class="mb20">
                                <button type="submit"
                                        class="btn ud-btn btn-light-thm px-3"
                                        style="min-width:max-content;padding:6px;">
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
                        <h5 class="mb-1">Project Summary</h5>
                        <p class="text-muted mb-0">
                            A quick overview of project status for the current filters.
                        </p>
                    </div>

                    @php
                        if (!isset($projectsTotal)) {
                            $projectsTotal = method_exists($projects, 'total')
                                ? $projects->total()
                                : $projects->count();
                        }
                    @endphp

                    <div class="text-end">
                        <small class="text-muted">
                            Showing {{ $projectsTotal }} records
                        </small>
                    </div>
                </div>

                <div class="row g-3">

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted">Total Projects</small>
                                    <div class="h5 mb-0">
                                        {{ $summary->total_projects ?? 0 }}
                                    </div>
                                </div>
                                <div class="text-muted">
                                    <i class="fas fa-project-diagram fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Pending</small>
                            <div class="h5 mb-0">
                                {{ $summary->pending_projects ?? 0 }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Ongoing</small>
                            <div class="h5 mb-0 text-warning">
                                {{ $summary->ongoing_projects ?? 0 }}
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-3">
                        <div class="p-3 h-100 bdrs4 bg-light">
                            <small class="text-muted">Completed</small>
                            <div class="h5 mb-0 text-success">
                                {{ $summary->completed_projects ?? 0 }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Project List --}}
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Projects') }}</h5>
                </div>

                <p class="text-muted">A list of all projects.</p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">

                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody class="t-body">

                            @php
                                $i = method_exists($projects, 'firstItem')
                                    ? ($projects->firstItem() - 1)
                                    : 0;
                            @endphp

                            @foreach ($projects as $project)
                                <tr class="text-center">

                                    <td>{{ ++$i }}</td>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->location }}</td>

                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($project->status) }}
                                        </span>
                                    </td>

                                    <td>
                                        <div class="d-flex justify-content-center">

                                            @canany(['projects.*', 'projects.show'])
                                                <a href="{{ route('projects.show', $project->id) }}"
                                                   class="icon me-2"
                                                   data-bs-toggle="tooltip"
                                                   title="View">
                                                    <span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['projects.*', 'projects.edit'])
                                                <a href="{{ route('projects.edit', $project->id) }}"
                                                   class="icon me-2"
                                                   data-bs-toggle="tooltip"
                                                   title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany

                                            @canany(['projects.*', 'projects.destroy'])
                                                <form action="{{ route('projects.destroy', $project->id) }}"
                                                      method="POST"
                                                      class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <a href="#"
                                                       class="icon"
                                                       data-bs-toggle="tooltip"
                                                       title="Delete"
                                                       data-confirm
                                                       data-confirm-title="Delete entry?"
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
                    @if (method_exists($projects, 'onFirstPage'))

                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">

                                @if ($projects->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link">
                                            <span class="fas fa-angle-left"></span>
                                        </span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ $projects->previousPageUrl() }}">
                                            <span class="fas fa-angle-left"></span>
                                        </a>
                                    </li>
                                @endif

                                @foreach ($projects->getUrlRange(1, $projects->lastPage()) as $page => $url)
                                    <li class="page-item {{ $projects->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endforeach

                                @if ($projects->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link"
                                           href="{{ $projects->nextPageUrl() }}">
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
                                {{ $projects->firstItem() }}
                                –
                                {{ $projects->lastItem() }}
                                of
                                {{ $projects->total() }}
                                Projects
                            </p>
                        </div>

                    @else

                        <div class="mbp_pagination mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $projectsTotal }} Projects
                            </p>
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>

</x-app-layout>