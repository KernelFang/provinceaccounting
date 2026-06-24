<x-app-layout>
    <x-slot name="title">{{ __('Income') . ' ' . __('Details') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Income') . ' ' . __('Details') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="container-sm container-lg">
            <div class="bg-white shadow rounded-3 p-4 p-sm-8">
                <div class="w-100">
                    <!-- Income Details -->
                    <section class="pt0 pb90 pb30-md">
                        <div class="container">
                            <div class="row wrap wow fadeInUp">
                                <div class="col-lg-8">
                                    <div class="column" id="printable-area">
                                        <div class="price-widget pt25 bdrs8">
                                            <h4><i
                                                    class="fa fa-money-bill-wave text-thm2 pe-2 vam align-baseline"></i>{{ __('Income') . ' ' . __('Details') }}
                                            </h4>
                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-file-invoice text-thm2 pe-2 vam"></i> Invoice No
                                                    </span>
                                                    <span>{{ $income->invoice_no }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-project-diagram text-thm2 pe-2 vam"></i> Project
                                                    </span>
                                                    <span>{{ $income->project?->name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-door-open text-thm2 pe-2 vam"></i> Flat
                                                    </span>
                                                    <span>{{ $income->flat?->flat_no ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-user text-thm2 pe-2 vam"></i> Client
                                                    </span>
                                                    <span>{{ $income->client?->first_name . ' ' . $income->client?->last_name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-bill-wave text-thm2 pe-2 vam"></i> Amount
                                                        (TK.)
                                                    </span>
                                                    <span>{{ rtrim(rtrim(number_format($income->price, 2), '0'), '.') }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-info-circle text-thm2 pe-2 vam"></i> Status
                                                    </span>
                                                    <span>{{ ucfirst($income->clearing_status) }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        <div class="service-about">
                                            <div class="p30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                <h4><i class="fa fa-align-left pe-2 text-thm2"></i> Remarks</h4>
                                                <p class="text mb30">
                                                    {{ $income->remarks ?? 'No remarks provided' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">
                                            @canany(['incomes.*', 'incomes.edit'])
                                                <a href="{{ route('incomes.edit', $income->id) }}"
                                                    class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                    <i class="fa fa-edit me-1"></i> Edit
                                                </a>
                                            @endcanany
                                            @canany(['incomes.*', 'incomes.destroy'])
                                                <form action="{{ route('incomes.destroy', $income->id) }}" method="POST"
                                                    class="d-inline">@csrf @method('DELETE')
                                                    <button class="ud-btn btn-thm6 py-0 ps-1 pe-2" data-confirm
                                                        data-confirm-title="Delete this entry?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <i class="fas fa-trash-alt pe-1"></i> Delete
                                                    </button>
                                                </form>
                                            @endcanany
                                            <a href="{{ route('incomes.index') }}"
                                                class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                <i class="fa fa-arrow-left me-1"></i> Back
                                            </a>
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="ud-btn btn-white2 py-0 ps-1 pe-2"
                                                onclick="printElement('printable-area')">
                                                <i class="fa fa-print me-1"></i> Print</button>
                                        </div>
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
