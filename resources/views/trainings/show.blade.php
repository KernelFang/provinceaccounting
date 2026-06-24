<x-app-layout>
    <x-slot name="title">{{ __('Training') . ' ' . __('Details') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Training') . ' ' . __('Details') }}
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

                                        {{-- Training Details --}}
                                        <div class="price-widget pt25 bdrs8">
                                            <h4>
                                                <i class="fa fa-chalkboard-teacher text-thm2 pe-2 vam"></i>
                                                {{ __('Training Details') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-hashtag text-thm2 pe-2"></i>
                                                        {{ __('Training ID') }}
                                                    </span>
                                                    <span>#{{ $training->id }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-layer-group text-thm2 pe-2"></i>
                                                        {{ __('Training Type') }}
                                                    </span>
                                                    <span>{{ $training->training_type ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-heading text-thm2 pe-2"></i>
                                                        {{ __('Title') }}
                                                    </span>
                                                    <span>{{ $training->title ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-tag text-thm2 pe-2"></i>
                                                        {{ __('Package') }}
                                                    </span>
                                                    <span>{{ $training->package ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-alt text-thm2 pe-2"></i>
                                                        {{ __('Purchase Date') }}
                                                    </span>
                                                    <span>{{ $training->purchase_date ? $training->purchase_date->format('d M Y') : 'N/A' }}</span>
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
                                                        {{ __('Customer Name') }}
                                                    </span>
                                                    <span>{{ $training->customer_name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-phone text-thm2 pe-2"></i>
                                                        {{ __('Customer Number') }}
                                                    </span>
                                                    <span>{{ $training->customer_number ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Description Section --}}
                                        <div class="service-about mt30">
                                            <div class="p30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                <h4><i
                                                        class="fa fa-align-left pe-2 text-thm2"></i>{{ __('Description') }}
                                                </h4>
                                                <p class="text mb30">
                                                    {{ $training->description ?? 'No description provided' }}</p>
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
                                                    <span>{{ $training->agent_cost ? $training->agent_cost . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-bill-wave text-thm2 pe-2"></i>
                                                        {{ __('Customer Price') }}
                                                    </span>
                                                    <span class="fw-semibold text-success">
                                                        {{ $training->customer_price ? $training->customer_price . ' TK' : 'N/A' }}
                                                    </span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-wallet text-thm2 pe-2"></i>
                                                        {{ __('Customer Payment') }}
                                                    </span>
                                                    <span class="fw-semibold">
                                                        {{ $training->customer_payment ? $training->customer_payment . ' TK' : 'N/A' }}
                                                    </span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-money-check text-thm2 pe-2"></i>
                                                        {{ __('Customer Due') }}
                                                    </span>
                                                    <span
                                                        class="text-danger">{{ $training->customer_due ? $training->customer_due . ' TK' : 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">

                                            @canany(['trainings.*', 'trainings.edit'])
                                                <a href="{{ route('trainings.edit', $training->id) }}"
                                                    class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                    <i class="fa fa-edit me-1"></i> {{ __('Edit') }}
                                                </a>
                                            @endcanany

                                            @canany(['trainings.*', 'trainings.destroy'])
                                                <form action="{{ route('trainings.destroy', $training->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="ud-btn btn-thm6 py-0 ps-1 pe-2" data-confirm
                                                        data-confirm-title="Delete this training?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <i class="fas fa-trash-alt pe-1"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            @endcanany

                                            <a href="{{ route('trainings.index') }}"
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
