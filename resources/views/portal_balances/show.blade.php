<x-app-layout>
    <x-slot name="title">{{ __('Portal Transaction') . ' ' . __('Details') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Portal Transaction') . ' ' . __('Details') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="container-sm container-lg">
            <div class="bg-white shadow rounded-3 p-4 p-sm-8">
                <div class="w-100">
                    <section class="pt0 pb90 pb30-md">
                        <div class="container">
                            <div class="row wrap wow fadeInUp">
                                <div class="col-lg-8">
                                    <div class="column" id="printable-area">

                                        {{-- Portal Transaction Details --}}
                                        <div class="price-widget pt25 bdrs8">
                                            <h4>
                                                <i class="fa fa-exchange-alt text-thm2 pe-2 vam"></i>
                                                {{ __('Portal Transaction Details') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-hashtag text-thm2 pe-2"></i>
                                                        {{ __('Transaction ID') }}
                                                    </span>
                                                    <span>#{{ $item->id }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-exchange-alt text-thm2 pe-2"></i>
                                                        {{ __('Transaction Type') }}
                                                    </span>
                                                    <span>{{ $item->transaction_type ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-alt text-thm2 pe-2"></i>
                                                        {{ __('Date') }}
                                                    </span>
                                                    <span>{{ $item->date ? $item->date->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-globe text-thm2 pe-2"></i>
                                                        {{ __('Portal') }}
                                                    </span>
                                                    <span>{{ $item->portal ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-info-circle text-thm2 pe-2"></i>
                                                        {{ __('Info') }}
                                                    </span>
                                                    <span>{{ $item->info ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-user text-thm2 pe-2"></i>
                                                        {{ __('Sender') }}
                                                    </span>
                                                    <span>{{ $item->sender ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-barcode text-thm2 pe-2"></i>
                                                        {{ __('Reference') }}
                                                    </span>
                                                    <span>{{ $item->reference ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-wallet text-thm2 pe-2"></i>
                                                        {{ __('Amount') }}
                                                    </span>
                                                    <span class="fw-semibold text-success">
                                                        {{ $item->recharge ? $item->recharge . ' TK' : 'N/A' }}
                                                    </span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-sticky-note text-thm2 pe-2"></i>
                                                        {{ __('Remarks') }}
                                                    </span>
                                                    <span>{{ $item->remarks ?? 'N/A' }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">

                                            @canany(['portal-balances.*', 'portal-balances.edit'])
                                                <a href="{{ route('portal-balances.edit', $item->id) }}"
                                                    class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                    <i class="fa fa-edit me-1"></i> {{ __('Edit') }}
                                                </a>
                                            @endcanany

                                            @canany(['portal-balances.*', 'portal-balances.destroy'])
                                                <form action="{{ route('portal-balances.destroy', $item->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="ud-btn btn-thm6 py-0 ps-1 pe-2" data-confirm
                                                        data-confirm-title="Delete this transaction?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <i class="fas fa-trash-alt pe-1"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            @endcanany

                                            <a href="{{ route('portal-balances.index') }}"
                                                class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                <i class="fa fa-arrow-left me-1"></i> {{ __('Back') }}
                                            </a>
                                        </div>

                                        <button class="ud-btn btn-white2 py-0 ps-1 pe-2"
                                            onclick="printElement('printable-area')">
                                            <i class="fa fa-print me-1"></i> {{ __('Print') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
