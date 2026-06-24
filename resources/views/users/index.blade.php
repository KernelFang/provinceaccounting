<x-app-layout>
    <x-slot name="title">{{ __('User') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('User') . ' ' . __('Management') }}</h2>
            @canany(['users.*', 'users.create'])
                <a href="{{ route('users.create') }}" class="ud-btn btn-light-thm py-1 px-3"><i
                        class="fa-solid fa-plus me-2 ms-0" style="transform: rotate(0)"></i>Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <p class="text-muted text-decoration-underline">Advanced Search</p>

                <!-- Advanced Search Form -->
                <form method="GET" action="{{ route('users.index') }}" class="form-style1 g-3">
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
                                <input type="text" name="q" value="{{ request('q') }}"
                                    class="form-control h-auto" placeholder="Name, email or username">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <input type="text" name="contact" value="{{ request('contact') }}"
                                    class="form-control h-auto" placeholder="Contact">
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <select name="user_type" class="form-control h-auto">
                                    <option value="">Any type</option>
                                    <option value="admin" @if (request('user_type') == 'admin') selected @endif>Admin
                                    </option>
                                    <option value="user" @if (request('user_type') == 'user') selected @endif>User
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="mb20">
                                <select name="status" class="form-control h-auto">
                                    <option value="">Any status</option>
                                    <option value="1" @if (request('status') === '1') selected @endif>Active
                                    </option>
                                    <option value="0" @if (request('status') === '0') selected @endif>Inactive
                                    </option>
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

                        <div class="col-md-3">
                            <div class="mb20">
                                <button type="submit" class="btn ud-btn btn-light-thm px-3"
                                    style="min-width: max-content; padding: 6px;">
                                    <i class="fa-solid fa-search me-2 ms-0" style="transform: rotate(0);"></i>Search
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Users') }}</h5>
                </div>

                <p class="text-muted">A list of all the {{ __('Users') }}.</p>

                <div class="packages_table table-responsive">
                    <table class="table-style3 table at-savesearch" id="recordDataTableOne">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">User ID</th>
                                <th scope="col">User</th>
                                <th scope="col" class="text-center">Username</th>
                                <th scope="col" class="text-center">Contact</th>
                                <th scope="col" class="text-center">Joining Date</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="t-body">
                            @php $i = 0; @endphp
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">{{ ++$i }}</td>
                                    <td class="text-center">{{ $user->id }}</td>
                                    <td class="text-start">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : asset('storage/profile_images/default-profile.jpg') }}"
                                                class="me-3 rounded-circle" alt="user1"
                                                style="width: 40px; height: 40px;">
                                            <div>
                                                <h6 class="mb-0">
                                                    {!! $user->name ? ucwords(strtolower($user->name)) : '<span class="text-muted">Name not Found</span>' !!}
                                                </h6>
                                                <p class="mb-0 text-muted">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <h6 class="mb-0">{{ $user->username }}</h6>
                                        <p class="mb-0 text-muted">({{ $user->user_type }})</p>
                                    </td>
                                    <td class="text-center">{{ $user->contact }}</td>
                                    <td class="text-center">{{ $user->joining_date?->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['users.*', 'users.show'])
                                                <a href="{{ route('users.show', $user->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Show user details"><span class="fas fa-eye"></span>
                                                </a>
                                            @endcanany

                                            @canany(['users.*', 'users.edit'])
                                                <a href="{{ route('users.edit', $user->id) }}" class="icon me-2"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                                    <span class="fas fa-pen"></span>
                                                </a>
                                            @endcanany

                                            @canany(['users.*', 'users.destroy'])
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="icon" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" title="Delete" data-confirm
                                                        data-confirm-title="Delete your account?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!"><span
                                                            class="fas fa-trash text-danger"></span></a>
                                                </form>
                                            @endcanany
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @php
                        if (!isset($usersTotal)) {
                            $usersTotal = method_exists($users, 'total') ? $users->total() : $users->count();
                        }
                    @endphp

                    {{-- Pagination --}}
                    @if (method_exists($users, 'total'))
                        <div class="mbp_pagination mt30 text-center">
                            <ul class="page_navigation">
                                <!-- Previous Page Link -->
                                @if ($users->onFirstPage())
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-left"></span></span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->previousPageUrl() }}"><span
                                                class="fas fa-angle-left"></span></a>
                                    </li>
                                @endif

                                <!-- Page Number Links -->
                                @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                    <li class="page-item {{ $users->currentPage() == $page ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach

                                <!-- Next Page Link -->
                                @if ($users->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->nextPageUrl() }}"><span
                                                class="fas fa-angle-right"></span></a>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <span class="page-link"><span class="fas fa-angle-right"></span></span>
                                    </li>
                                @endif
                            </ul>
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                {{ $users->firstItem() }} – {{ $users->lastItem() }} of {{ $users->total() }}
                                users
                            </p>
                        </div>
                    @else
                        {{-- When "All Records" is selected --}}
                        <div class="mt30 text-center">
                            <p class="mt10 mb-0 pagination_page_count text-center">
                                Showing all {{ $usersTotal }} users
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
