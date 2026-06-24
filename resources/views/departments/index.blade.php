<x-app-layout>
     @php
        $items = $departments;
    @endphp

    <x-slot name="title">{{ __('Departments') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Departments') }}</h2>
            @canany(['departments.*', 'departments.create'])
                <a href="{{ route('departments.create') }}" class="ud-btn btn-light-thm py-1 px-3">Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Departments') }}</h5>

                    @canany(['departments.*', 'departments.restore', 'departments.force-delete'])
                        <div class="d-flex gap-2">
                            <a href="{{ route('departments.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                            <a href="{{ route('departments.index', array_merge(request()->query(), ['with_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-secondary">With Trashed</a>
                            <a href="{{ route('departments.index', array_merge(request()->query(), ['only_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-danger">Only Trashed</a>
                        </div>
                    @endcanany
                </div>

                <p class="text-muted">A list of all departments.</p>

                <div class="table-responsive">
                    <table class="table-style3 table">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="t-body text-center">
                            @foreach ($items as $it)
                                <tr>
                                    <td>{{ $it->id }}</td>
                                    <td>{{ $it->name }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['departments.*', 'departments.edit'])
                                                <a href="{{ route('departments.edit', $it) }}" class="icon me-2"
                                                    title="Edit"><span class="fas fa-pen"></span></a>
                                            @endcanany

                                            @canany(['departments.*', 'departments.destroy'])
                                                <form action="{{ route('departments.destroy', $it) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a href="#" class="icon" data-confirm
                                                        data-confirm-title="Delete?"
                                                        data-confirm-text="This cannot be undone"><span
                                                            class="fas fa-trash text-danger"></span></a>
                                                </form>
                                            @endcanany

                                            @if (method_exists($it, 'trashed') && $it->trashed())
                                                @canany(['departments.*', 'departments.restore',
                                                    'departments.force-delete'])
                                                    <x-delete-restore-buttons routePrefix="departments" :model="$it" />
                                                @endcanany
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mbp_pagination mt30 text-center">
                        <ul class="page_navigation">
                            @if ($items->onFirstPage())
                                <li class="page-item"><span class="page-link"><span
                                            class="fas fa-angle-left"></span></span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $items->previousPageUrl() }}"><span
                                            class="fas fa-angle-left"></span></a></li>
                            @endif

                            @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                                <li class="page-item {{ $items->currentPage() == $page ? 'active' : '' }}"><a
                                        class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endforeach

                            @if ($items->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $items->nextPageUrl() }}"><span
                                            class="fas fa-angle-right"></span></a></li>
                            @else
                                <li class="page-item"><span class="page-link"><span
                                            class="fas fa-angle-right"></span></span></li>
                            @endif
                        </ul>

                        <p class="mt10 mb-0 pagination_page_count text-center">
                            {{ $items->firstItem() }} – {{ $items->lastItem() }} of {{ $items->total() }} Records
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
