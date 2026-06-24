<x-app-layout>
    <x-slot name="title">{{ __('Visa') . ' ' . __('Details') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Visa') . ' ' . __('Details') }}
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

                                        {{-- Basic Information --}}
                                        <div class="price-widget pt25 bdrs8">
                                            <h4>
                                                <i class="fa fa-passport text-thm2 pe-2 vam"></i>
                                                {{ __('Basic Information') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-hashtag text-thm2 pe-2"></i>
                                                        {{ __('Visa ID') }}
                                                    </span>
                                                    <span>#{{ $visa->id }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-globe text-thm2 pe-2"></i>
                                                        {{ __('Country') }}
                                                    </span>
                                                    <span>{{ $visa->country ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-bullseye text-thm2 pe-2"></i>
                                                        {{ __('Purpose') }}
                                                    </span>
                                                    <span>{{ $visa->purpose ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-align-left text-thm2 pe-2"></i>
                                                        {{ __('Description') }}
                                                    </span>
                                                    <span>{{ $visa->description ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-circle-check text-thm2 pe-2"></i>
                                                        {{ __('Status') }}
                                                    </span>
                                                    <span>{{ $visa->status ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Duration & Travel Information --}}
                                        <div class="price-widget pt25 bdrs8 mt30">
                                            <h4>
                                                <i class="fa fa-calendar text-thm2 pe-2 vam"></i>
                                                {{ __('Duration & Travel Information') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-alt text-thm2 pe-2"></i>
                                                        {{ __('Purchase Date') }}
                                                    </span>
                                                    <span>{{ $visa->purchase_date ? $visa->purchase_date->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-day text-thm2 pe-2"></i>
                                                        {{ __('From Date') }}
                                                    </span>
                                                    <span>{{ $visa->from_date ? $visa->from_date->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-check text-thm2 pe-2"></i>
                                                        {{ __('To Date') }}
                                                    </span>
                                                    <span>{{ $visa->to_date ? $visa->to_date->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Customer Information --}}
                                        <div class="price-widget pt25 bdrs8 mt30">
                                            <h4>
                                                <i class="fa fa-user text-thm2 pe-2 vam"></i>
                                                {{ __('Customer Information') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-user text-thm2 pe-2"></i>
                                                        {{ __('Customer') }}
                                                    </span>
                                                    <span>{{ $visa->customer ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-users text-thm2 pe-2"></i>
                                                        {{ __('Number of Persons') }}
                                                    </span>
                                                    <span>{{ $visa->person ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-phone text-thm2 pe-2"></i>
                                                        {{ __('Mobile Number') }}
                                                    </span>
                                                    <span>{{ $visa->mobile_number ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-phone-alt text-thm2 pe-2"></i>
                                                        {{ __('Emergency Number') }}
                                                    </span>
                                                    <span>{{ $visa->emergency_number ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Financial Information --}}
                                        <div class="price-widget pt25 bdrs8 mt30">
                                            <h4>
                                                <i class="fa fa-money-bill-wave text-thm2 pe-2 vam"></i>
                                                {{ __('Financial Information') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-bill text-thm2 pe-2"></i>
                                                        {{ __('Agent Cost') }}
                                                    </span>
                                                    <span>{{ $visa->agent_cost ? $visa->agent_cost . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-bill-wave text-thm2 pe-2"></i>
                                                        {{ __('Customer Price') }}
                                                    </span>
                                                    <span class="fw-semibold text-success">
                                                        {{ $visa->customer_price ? $visa->customer_price . ' TK' : 'N/A' }}
                                                    </span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-wallet text-thm2 pe-2"></i>
                                                        {{ __('Customer Payment') }}
                                                    </span>
                                                    <span>{{ $visa->customer_payment ? $visa->customer_payment . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-check text-thm2 pe-2"></i>
                                                        {{ __('Customer Due') }}
                                                    </span>
                                                    <span class="text-danger">{{ $visa->customer_due ? $visa->customer_due . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-chart-line text-thm2 pe-2"></i>
                                                        {{ __('Profit') }}
                                                    </span>
                                                    <span class="fw-semibold text-success">
                                                        {{ $visa->profit ? $visa->profit . ' TK' : 'N/A' }}
                                                    </span>
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">

                                            @canany(['visas.*', 'visas.edit'])
                                                <a href="{{ route('visas.edit', $visa->id) }}"
                                                    class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                    <i class="fa fa-edit me-1"></i> {{ __('Edit') }}
                                                </a>
                                            @endcanany

                                            @canany(['visas.*', 'visas.destroy'])
                                                <form action="{{ route('visas.destroy', $visa->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="ud-btn btn-thm6 py-0 ps-1 pe-2" data-confirm
                                                        data-confirm-title="Delete this visa?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <i class="fas fa-trash-alt pe-1"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            @endcanany

                                            <a href="{{ route('visas.index') }}"
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
