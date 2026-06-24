<x-app-layout>
    @php
        $items = $designations;
    @endphp

    <x-slot name="title">{{ __('Designations') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Designations') }}</h2>
            @canany(['designations.*', 'designations.create'])
                <a href="{{ route('designations.create') }}" class="ud-btn btn-light-thm py-1 px-3">Add new</a>
            @endcanany
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="list-title mt-2">{{ __('Designations') }}</h5>

                    @canany(['designations.*', 'designations.restore', 'designations.force-delete'])
                        <div class="d-flex gap-2">
                            <a href="{{ route('designations.index') }}" class="btn btn-sm btn-outline-primary">All</a>
                            <a href="{{ route('designations.index', array_merge(request()->query(), ['with_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-secondary">With Trashed</a>
                            <a href="{{ route('designations.index', array_merge(request()->query(), ['only_trashed' => 1])) }}"
                                class="btn btn-sm btn-outline-danger">Only Trashed</a>
                        </div>
                    @endcanany
                </div>

                <p class="text-muted">A list of all designations.</p>

                <div class="table-responsive">
                    <table class="table-style3 table">
                        <thead class="t-head">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="t-body text-center">
                            @foreach ($items as $it)
                                <tr>
                                    <td>{{ $it->id }}</td>
                                    <td>{{ $it->title }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @canany(['designations.*', 'designations.edit'])
                                                <a href="{{ route('designations.edit', $it) }}" class="icon me-2"
                                                    title="Edit"><span class="fas fa-pen"></span></a>
                                            @endcanany

                                            @canany(['designations.*', 'designations.destroy'])
                                                <form action="{{ route('designations.destroy', $it) }}" method="POST"
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
                                                @canany(['designations.*', 'designations.restore',
                                                    'designations.force-delete'])
                                                    <x-delete-restore-buttons routePrefix="designations"
                                                        :model="$it" />
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
                                            class="fas fa-angle-left"></span></span>
                                </li>
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
