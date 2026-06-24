<x-app-layout>
    <x-slot name="title">{{ __('Audit') . ' ' . __('Log') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audit') . ' ' . __('Log') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <!-- Advanced Search Form -->
                <form method="GET" action="{{ route('audit-logs.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <div class="mb20">
                            <div class="input-group border rounded">
                                <span class="input-group-text border-0">
                                    <i class="fa fa-calendar-alt"></i>
                                </span>
                                <input type="text" name="date_range"
                                    class="form-control daterangepicker-field pe-4 h-auto" placeholder="Date Range"
                                    data-start="{{ $start ? $start->format('m/d/Y') : '10/01/2025' }}"
                                    data-end="{{ $end ? $end->format('m/d/Y') : '10/07/2025' }}"
                                    style="background: transparent; z-index: 1;">
                                <span style="position: absolute; right: 10px; top: 12%; z-index: 0;">
                                    <i class="fa fa-caret-down"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="mb20">
                            <select name="action" class="form-control h-auto">
                                <option value="">All actions</option>
                                @foreach ($actions ?? [] as $a)
                                    <option value="{{ $a }}"
                                        @if (request()->get('action') == $a) selected @endif>
                                        {{ ucfirst($a) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb20">
                            <select name="auditable_type" class="form-control h-auto">
                                <option value="">All models</option>
                                @foreach ($types ?? [] as $t)
                                    <option value="{{ $t }}"
                                        @if (request()->get('auditable_type') == $t) selected @endif>
                                        {{ $t }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb20">
                            <select name="user_id" class="form-control h-auto">
                                <option value="">All users</option>
                                @foreach ($users ?? [] as $u)
                                    @php $user = \App\Models\User::find($u); @endphp
                                    <option value="{{ $u }}"
                                        @if (request()->get('user_id') == $u) selected @endif>
                                        {{ $user?->name ?? 'User #' . $u }}
                                    </option>
                                @endforeach
                            </select>
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
                                    <option value="1000" {{ request('per_page') == '1000' ? 'selected' : '' }}>1000
                                    </option>
                                    <option value="5000" {{ request('per_page') == '5000' ? 'selected' : '' }}>5000
                                    </option>
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
                </form>
            </div>

            <!-- Audit Logs Table -->
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Audit Logs') }}</h5>
                </div>
                <p class="text-muted">A list of all actions performed in the application.</p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">User</th>
                                <th scope="col" class="text-center">Action</th>
                                <th scope="col" class="text-center">Model</th>
                                <th scope="col" class="text-center noVis">Timestamp</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="t-body">
                            @php $i = 0; @endphp
                            @foreach ($logs as $log)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="text-center">
                                        <h6 class="mb-0">
                                            {!! $log->user ? ucwords(strtolower($log->user->name)) : '<span class="text-muted">User not found</span>' !!}
                                        </h6>
                                    </td>
                                    <td class="text-center">{{ ucfirst($log->action) }}</td>
                                    <td class="text-center">{{ $log->auditable_type }}</td>
                                    <td class="text-center">{{ $log->created_at->format('M d,Y h:i:s A') }}</td>
                                    <td>

                                        <div class="d-flex justify-content-center">
                                            @canany(['audit-logs.*', 'audit-logs.show'])
                                                <a href="{{ route('audit-logs.show', $log->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Show details"><span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    @php
                        if (!isset($logsTotal)) {
                            $logsTotal = method_exists($logs, 'total') ? $logs->total() : $logs->count();
                        }
                    @endphp

                    {{-- Pagination --}}
                    @if (method_exists($logs, 'total'))
                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">
                                <!-- Previous Page Link -->
                                @if ($logs->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-left"></span></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $logs->previousPageUrl() }}"><span
                                                class="fas fa-angle-left"></span></a>
                                    </li>
                                @endif

                                <!-- Page Number Links -->
                                @foreach ($logs->getUrlRange(1, $logs->lastPage()) as $page => $url)
                                    <li class="page-item {{ $logs->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($logs->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $logs->nextPageUrl() }}"><span
                                                class="fas fa-angle-right"></span></a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-right"></span></span>
                                    </li>
                                @endif
                            </ul>

                            <p class="mt10 mb-0 pagination_page_count text-center">
                                {{ $logs->firstItem() }} – {{ $logs->lastItem() }} of {{ $logs->total() }} audit logs
                            </p>
                        </div>
                    @else
                        {{-- When "All Records" is selected --}}
                        <div class="mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $logsTotal }} Logs
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
