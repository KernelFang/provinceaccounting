<x-app-layout>
    <x-slot name="title">{{ __('Sale') . ' ' . __('Details') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sale') . ' ' . __('Details') }}
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

                                        {{-- Basic Information Section --}}
                                        <div class="price-widget pt25 bdrs8">
                                            <h4>
                                                <i class="fa fa-receipt text-thm2 pe-2 vam"></i>
                                                {{ __('Basic Information') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-hashtag text-thm2 pe-2"></i>
                                                        {{ __('Sale ID') }}
                                                    </span>
                                                    <span>#{{ $sale->id }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-alt text-thm2 pe-2"></i>
                                                        {{ __('Issue Date') }}
                                                    </span>
                                                    <span>{{ $sale->issue_date ? $sale->issue_date->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-globe text-thm2 pe-2"></i>
                                                        {{ __('Issued Portal') }}
                                                    </span>
                                                    <span>{{ $sale->issued_portal ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-briefcase text-thm2 pe-2"></i>
                                                        {{ __('Service Type') }}
                                                    </span>
                                                    <span>{{ $sale->service_type ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Customer Information Section --}}
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
                                                    <span>{{ $sale->customer_name ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-phone text-thm2 pe-2"></i>
                                                        {{ __('Customer Phone') }}
                                                    </span>
                                                    <span>{{ $sale->customer_phone ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-phone text-thm2 pe-2"></i>
                                                        {{ __('Emergency Contact No') }}
                                                    </span>
                                                    <span>{{ $sale->contact_no ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-user-circle text-thm2 pe-2"></i>
                                                        {{ __('Passenger Name') }}
                                                    </span>
                                                    <span>{{ $sale->pax_name ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Flight Information Section --}}
                                        <div class="price-widget pt25 bdrs8 mt30">
                                            <h4>
                                                <i class="fa fa-plane text-thm2 pe-2 vam"></i>
                                                {{ __('Flight Information') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-building text-thm2 pe-2"></i>
                                                        {{ __('Airline') }}
                                                    </span>
                                                    <span>{{ $sale->airline ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa-solid fa-plane text-thm2 pe-2"></i>
                                                        {{ __('Flight Type') }}
                                                    </span>
                                                    <span>{{ $sale->flight_type ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-route text-thm2 pe-2"></i>
                                                        {{ __('Trip') }}
                                                    </span>
                                                    <span>{{ $sale->trip ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar text-thm2 pe-2"></i>
                                                        {{ __('Flight Date') }}
                                                    </span>
                                                    <span>{{ $sale->flight_date ? $sale->flight_date->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-calendar text-thm2 pe-2"></i>
                                                        {{ __('Return Date') }}
                                                    </span>
                                                    <span>{{ $sale->return_date ? $sale->return_date->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-info-circle text-thm2 pe-2"></i>
                                                        {{ __('Flight Status') }}
                                                    </span>
                                                    <span>{{ $sale->flight_status ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-cut text-thm2 pe-2"></i>
                                                        {{ __('Segment') }}
                                                    </span>
                                                    <span>{{ $sale->segment ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Ticket Information Section --}}
                                        <div class="price-widget pt25 bdrs8 mt30">
                                            <h4>
                                                <i class="fa fa-ticket-alt text-thm2 pe-2 vam"></i>
                                                {{ __('Ticket Information') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-barcode text-thm2 pe-2"></i>
                                                        {{ __('Ticket Number') }}
                                                    </span>
                                                    <span>{{ $sale->tkt_number ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-id-card text-thm2 pe-2"></i>
                                                        {{ __('Passport/NID') }}
                                                    </span>
                                                    <span>{{ $sale->passport_nid ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- GDS/Airline PNR Section --}}
                                        <div class="price-widget pt25 bdrs8 mt30">
                                            <h4>
                                                <i class="fa fa-code text-thm2 pe-2 vam"></i>
                                                {{ __('GDS/Booking References') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa-solid fa-file text-thm2 pe-2"></i>
                                                        {{ __('GDS PNR') }}
                                                    </span>
                                                    <span>{{ $sale->gds_pnr ?? 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa-solid fa-file text-thm2 pe-2"></i>
                                                        {{ __('Airline PNR') }}
                                                    </span>
                                                    <span>{{ $sale->airline_pnr ?? 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Financial Information Section --}}
                                        <div class="price-widget pt25 bdrs8 mt30">
                                            <h4>
                                                <i class="fa fa-money-bill-wave text-thm2 pe-2 vam"></i>
                                                {{ __('Financial Information') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-bill text-thm2 pe-2"></i>
                                                        {{ __('Agent Fare') }}
                                                    </span>
                                                    <span>{{ $sale->agent_fare ? $sale->agent_fare . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-bill text-thm2 pe-2"></i>
                                                        {{ __('Customer Fare') }}
                                                    </span>
                                                    <span>{{ $sale->customer_fare ? $sale->customer_fare . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-bill text-thm2 pe-2"></i>
                                                        {{ __('Segment Fare') }}
                                                    </span>
                                                    <span>{{ $sale->segment_fare ? $sale->segment_fare . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa-solid fa-tag text-thm2 pe-2"></i>
                                                        {{ __('Agent Price') }}
                                                    </span>
                                                    <span>{{ $sale->agent_price ? $sale->agent_price . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p
                                                    class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa-solid fa-tag text-thm2 pe-2"></i>
                                                        {{ __('Sell Price') }}
                                                    </span>
                                                    <span>{{ $sale->sell_price ? $sale->sell_price . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p
                                                    class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-hand-holding-usd text-thm2 pe-2"></i>
                                                        {{ __('Customer Payment') }}
                                                    </span>
                                                    <span>{{ $sale->customer_payment ? $sale->customer_payment . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p
                                                    class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-money-check text-thm2 pe-2"></i>
                                                        {{ __('Customer Due') }}
                                                    </span>
                                                    <span
                                                        class="text-danger">{{ $sale->customer_due ? $sale->customer_due . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p
                                                    class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-wallet text-thm2 pe-2"></i>
                                                        {{ __('Top Balance') }}
                                                    </span>
                                                    <span>{{ $sale->top_balance ? $sale->top_balance . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p
                                                    class="d-flex align-items-center justify-content-between bdrb1 pb-2">
                                                    <span class="text">
                                                        <i class="fa fa-wallet text-thm2 pe-2"></i>
                                                        {{ __('Current Balance') }}
                                                    </span>
                                                    <span>{{ $sale->current_balance ? $sale->current_balance . ' TK' : 'N/A' }}</span>
                                                </p>

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-chart-line text-thm2 pe-2"></i>
                                                        {{ __('Profit') }}
                                                    </span>
                                                    <span class="fw-semibold text-success">
                                                        {{ $sale->profit ? $sale->profit . ' TK' : 'N/A' }}
                                                    </span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Payment Timeline Section --}}
                                        <div class="price-widget pt25 bdrs8 mt30">
                                            <h4>
                                                <i class="fa fa-calendar-check text-thm2 pe-2 vam"></i>
                                                {{ __('Payment Timeline') }}
                                            </h4>

                                            <div class="category-list mt20">

                                                <p class="d-flex align-items-center justify-content-between">
                                                    <span class="text">
                                                        <i class="fa fa-calendar-check text-thm2 pe-2"></i>
                                                        {{ __('Last Date of Payment') }}
                                                    </span>
                                                    <span>{{ $sale->last_date_of_payment ? $sale->last_date_of_payment->format('d M Y') : 'N/A' }}</span>
                                                </p>

                                            </div>
                                        </div>

                                        {{-- Attachments --}}
                                        @if (!empty($sale->images) || !empty($sale->videos) || !empty($sale->documents) || !empty($sale->links))
                                            <div class="service-about mt30">
                                                <div
                                                    class="p30 mb30 bg-white bdrs12 wow fadeInUp default-box-shadow1 bdr1">
                                                    <h4>
                                                        <i class="fa fa-paperclip pe-2 text-thm2"></i>
                                                        {{ __('Attachments') }}
                                                    </h4>

                                                    {{-- Images --}}
                                                    @if (!empty($sale->images))
                                                        <div class="mt20">
                                                            <h6>Images</h6>
                                                            <div class="d-flex flex-wrap gap-2">
                                                                @foreach ($sale->images as $img)
                                                                    <div style="width:140px" class="border p-1 bdrs6">
                                                                        <a href="{{ asset('storage/' . $img) }}"
                                                                            target="_blank">
                                                                            <img src="{{ asset('storage/' . $img) }}"
                                                                                class="w-100"
                                                                                style="height:100px;object-fit:cover">
                                                                        </a>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Videos --}}
                                                    @if (!empty($sale->videos))
                                                        <div class="mt30">
                                                            <h6>Videos</h6>
                                                            <div class="d-flex flex-wrap gap-3">
                                                                @foreach ($sale->videos as $v)
                                                                    <div style="max-width:595px"
                                                                        class="border p-1 bdrs6">
                                                                        <video controls class="w-100"
                                                                            style="aspect-ratio:16/9;object-fit:cover">
                                                                            <source
                                                                                src="{{ asset('storage/' . $v) }}">
                                                                        </video>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- Documents --}}
                                                    @if (!empty($sale->documents))
                                                        <div class="mt30">
                                                            <h6>Documents</h6>
                                                            <ul class="list-unstyled">
                                                                @foreach ($sale->documents as $d)
                                                                    <li class="mb20">
                                                                        @if (\Illuminate\Support\Str::endsWith($d, '.pdf'))
                                                                            <div style="max-width:595px;aspect-ratio:1/1.414"
                                                                                class="border">
                                                                                <embed
                                                                                    src="{{ asset('storage/' . $d) }}"
                                                                                    type="application/pdf"
                                                                                    width="100%" height="100%">
                                                                            </div>
                                                                        @else
                                                                            <a href="{{ asset('storage/' . $d) }}"
                                                                                target="_blank">
                                                                                {{ __('Download Document') }}
                                                                            </a>
                                                                        @endif
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif

                                                    {{-- Links --}}
                                                    @if (!empty($sale->links))
                                                        <div class="mt30">
                                                            <h6>Links</h6>
                                                            <ul class="list-unstyled">
                                                                @foreach ($sale->links as $ln)
                                                                    <li>
                                                                        <a href="{{ $ln }}"
                                                                            target="_blank">
                                                                            {{ $ln }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex gap-2">

                                            @canany(['sales.*', 'sales.edit'])
                                                <a href="{{ route('sales.edit', $sale->id) }}"
                                                    class="ud-btn btn-white2 py-0 ps-1 pe-2">
                                                    <i class="fa fa-edit me-1"></i> {{ __('Edit') }}
                                                </a>
                                            @endcanany

                                            @canany(['sales.*', 'sales.destroy'])
                                                <form action="{{ route('sales.destroy', $sale->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="ud-btn btn-thm6 py-0 ps-1 pe-2" data-confirm
                                                        data-confirm-title="Delete this sale?"
                                                        data-confirm-text="This cannot be undone!"
                                                        data-confirm-button="Yes, delete it!">
                                                        <i class="fas fa-trash-alt pe-1"></i> {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            @endcanany

                                            <a href="{{ route('sales.index') }}"
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
