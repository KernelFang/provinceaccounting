@php
    $portals = $portals ?? collect();
    $service_types = $service_types ?? collect();
    $airlines = $airlines ?? collect();
    $flight_types = $flight_types ?? collect();
    $trips = $trips ?? collect();
    $sale = $sale ?? null;
@endphp

<div class="row">
    {{-- Issue Date --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="issue_date" :value="__('Issue Date')" />
            <x-text-input type="date" class="form-control" id="issue_date" name="issue_date" :value="old('issue_date', isset($sale->issue_date) ? $sale->issue_date->format('Y-m-d') : '')"
                required />
            <x-input-error :messages="$errors->get('issue_date')" />
        </div>
    </div>

    {{-- Issued Portal --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="issued_portal" :value="__('Issued Portal')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="issued_portal" name="issued_portal"
                        required>
                        <option value="" disabled
                            {{ is_null(old('issued_portal', $sale->issued_portal ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($portals as $p)
                            <option value="{{ $p->name }}" @selected(old('issued_portal', $sale->issued_portal ?? null) === $p->name)>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('issued_portal')" />
            </div>
        </div>
    </div>

    {{-- Service Type --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="service_type" :value="__('Service Type')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="service_type" name="service_type" required>
                        <option value="" disabled
                            {{ is_null(old('service_type', $sale->service_type ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($service_types as $s)
                            <option value="{{ $s->name }}" @selected(old('service_type', $sale->service_type ?? null) === $s->name)>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('service_type')" />
            </div>
        </div>
    </div>

    {{-- Trip --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="trip" :value="__('Trip')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="trip" name="trip" required>
                        <option value="" disabled
                            {{ is_null(old('trip', $sale->trip ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($trips as $t)
                            <option value="{{ $t->name }}" @selected(old('trip', $sale->trip ?? null) === $t->name)>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('trip')" />
            </div>
        </div>
    </div>

    {{-- GDS PNR --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="gds_pnr" :value="__('GDS PNR')" />
            <x-text-input type="text" class="form-control" id="gds_pnr" name="gds_pnr" :value="old('gds_pnr', $sale->gds_pnr ?? '')"
                required />
            <x-input-error :messages="$errors->get('gds_pnr')" />
        </div>
    </div>

    {{-- Airline PNR --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="airline_pnr" :value="__('Airline PNR')" />
            <x-text-input type="text" class="form-control" id="airline_pnr" name="airline_pnr" :value="old('airline_pnr', $sale->airline_pnr ?? '')" />
            <x-input-error :messages="$errors->get('airline_pnr')" />
        </div>
    </div>

    {{-- Segment --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="segment" :value="__('Segment')" />
            <x-text-input type="text" class="form-control" id="segment" name="segment" :value="old('segment', $sale->segment ?? '')"
                required />
            <x-input-error :messages="$errors->get('segment')" />
        </div>
    </div>

    {{-- Airline --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="airline" :value="__('Airline')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="airline" name="airline" required>
                        <option value="" disabled
                            {{ is_null(old('airline', $sale->airline ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($airlines as $a)
                            <option value="{{ $a->name }}" @selected(old('airline', $sale->airline ?? null) === $a->name)>
                                {{ $a->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('airline')" />
            </div>
        </div>
    </div>

    {{-- Agent Fare --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="agent_fare" :value="__('Agent Fare (Net Cost)')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="agent_fare"
                name="agent_fare" :value="old('agent_fare', $sale->agent_fare ?? '')" required />
            <x-input-error :messages="$errors->get('agent_fare')" />
        </div>
    </div>

    {{-- Customer Fare --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_fare" :value="__('Customer Fare')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_fare"
                name="customer_fare" :value="old('customer_fare', $sale->customer_fare ?? '')" required />
            <x-input-error :messages="$errors->get('customer_fare')" />
        </div>
    </div>

    {{-- Segment Fare --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="segment_fare" :value="__('Segment Fare')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="segment_fare"
                name="segment_fare" :value="old('segment_fare', $sale->segment_fare ?? '')" />
            <x-input-error :messages="$errors->get('segment_fare')" />
        </div>
    </div>

    {{-- Customer Payment --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_payment" :value="__('Customer Payment')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_payment"
                name="customer_payment" :value="old('customer_payment', $sale->customer_payment ?? '')" required />
            <x-input-error :messages="$errors->get('customer_payment')" />
        </div>
    </div>

    {{-- Customer Due --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_due" :value="__('Customer Due')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_due"
                name="customer_due" :value="old('customer_due', $sale->customer_due ?? '')" readonly />
            <x-input-error :messages="$errors->get('customer_due')" />
        </div>
    </div>

    {{-- Last Date Of Payment --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="last_date_of_payment" :value="__('Last Date Of Payment')" />
            <x-text-input type="date" class="form-control" id="last_date_of_payment" name="last_date_of_payment"
                :value="old(
                    'last_date_of_payment',
                    isset($sale->last_date_of_payment) ? $sale->last_date_of_payment->format('Y-m-d') : '',
                )" />
            <x-input-error :messages="$errors->get('last_date_of_payment')" />
        </div>
    </div>

    {{-- Flight Type --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="flight_type" :value="__('Flight Type')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="flight_type" name="flight_type">
                        <option value="" disabled
                            {{ is_null(old('flight_type', $sale->flight_type ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($flight_types as $f)
                            <option value="{{ $f->name }}" @selected(old('flight_type', $sale->flight_type ?? null) === $f->name)>
                                {{ $f->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('flight_type')" />
            </div>
        </div>
    </div>

    {{-- Pax Name --}}
    {{-- <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="pax_name" :value="__('PAX Name')" />
            <x-text-input type="text" class="form-control" id="pax_name" name="pax_name" :value="old('pax_name', $sale->pax_name ?? '')" />
            <x-input-error :messages="$errors->get('pax_name')" />
        </div>
    </div> --}}

    {{-- Customer Name --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_name" :value="__('Passenger Name')" />
            <x-text-input type="text" class="form-control" id="customer_name" name="customer_name"
                :value="old('customer_name', $sale->customer_name ?? '')" />
            <x-input-error :messages="$errors->get('customer_name')" />
        </div>
    </div>

    {{-- Customer Phone (optional) --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_phone" :value="__('Customer Phone (optional)')" />
            <x-text-input type="text" class="form-control" id="customer_phone" name="customer_phone"
                :value="old('customer_phone', $sale->customer_phone ?? '')" />
            <x-input-error :messages="$errors->get('customer_phone')" />
        </div>
    </div>

    {{-- Contact No --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="contact_no" :value="__('Emergency Contact No')" />
            <x-text-input type="text" class="form-control" id="contact_no" name="contact_no"
                :value="old('contact_no', $sale->contact_no ?? '')" />
            <x-input-error :messages="$errors->get('contact_no')" />
        </div>
    </div>

    {{-- Ticket Number --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="tkt_number" :value="__('Ticket Number')" />
            <x-text-input type="text" class="form-control" id="tkt_number" name="tkt_number"
                :value="old('tkt_number', $sale->tkt_number ?? '')" />
            <x-input-error :messages="$errors->get('tkt_number')" />
        </div>
    </div>

    {{-- Passport / NID --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="passport_nid" :value="__('Passport / NID')" />
            <x-text-input type="text" class="form-control" id="passport_nid" name="passport_nid"
                :value="old('passport_nid', $sale->passport_nid ?? '')" />
            <x-input-error :messages="$errors->get('passport_nid')" />
        </div>
    </div>

    {{-- Flight Date --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="flight_date" :value="__('Flight Date')" />
            <x-text-input type="date" class="form-control" id="flight_date" name="flight_date"
                :value="old('flight_date', isset($sale->flight_date) ? $sale->flight_date->format('Y-m-d') : '')" />
            <x-input-error :messages="$errors->get('flight_date')" />
        </div>
    </div>

    {{-- Return Date --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="return_date" :value="__('Return Date')" />
            <x-text-input type="date" class="form-control" id="return_date" name="return_date"
                :value="old('return_date', isset($sale->return_date) ? $sale->return_date->format('Y-m-d') : '')" />
            <x-input-error :messages="$errors->get('return_date')" />
        </div>
    </div>

    {{-- Flight Status --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="flight_status" :value="__('Flight Status')" />
            <div class="bootselect-multiselect">
                <select class="selectpicker" data-live-search="true" id="flight_status" name="flight_status">
                    <option value="" disabled
                        {{ is_null(old('flight_status', $sale->flight_status ?? null)) ? 'selected' : '' }}>
                        Select
                    </option>
                    <option value="issued" @selected(old('flight_status', $sale->flight_status ?? null) === 'issued')>Issued</option>
                    <option value="completed" @selected(old('flight_status', $sale->flight_status ?? null) === 'completed')>Completed</option>
                    {{-- <option value="reissued" @selected(old('flight_status', $sale->flight_status ?? null) === 'reissued')>Reissued</option>
                    <option value="refunded" @selected(old('flight_status', $sale->flight_status ?? null) === 'refunded')>Refunded</option> --}}
                    <option value="cancelled" @selected(old('flight_status', $sale->flight_status ?? null) === 'cancelled')>Cancelled</option>
                </select>
            </div>
            <x-input-error :messages="$errors->get('flight_status')" />
        </div>
    </div>

    {{-- Profit --}}
    {{-- <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="profit" :value="__('Profit')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="profit"
                name="profit" :value="old('profit', $sale->profit ?? '')" />
            <x-input-error :messages="$errors->get('profit')" />
        </div>
    </div> --}}

    {{-- Agent Price --}}
    {{-- <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="agent_price" :value="__('Agent Price')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="agent_price"
                name="agent_price" :value="old('agent_price', $sale->agent_price ?? '')" />
            <x-input-error :messages="$errors->get('agent_price')" />
        </div>
    </div> --}}

    {{-- Sell Price --}}
    {{-- <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="sell_price" :value="__('Sell Price')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="sell_price"
                name="sell_price" :value="old('sell_price', $sale->sell_price ?? '')" />
            <x-input-error :messages="$errors->get('sell_price')" />
        </div>
    </div> --}}

    {{-- Top Balance --}}
    {{-- <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="top_balance" :value="__('Top Balance')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="top_balance"
                name="top_balance" :value="old('top_balance', $sale->top_balance ?? '')" />
            <x-input-error :messages="$errors->get('top_balance')" />
        </div>
    </div> --}}

    {{-- Current Balance --}}
    {{-- <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="current_balance" :value="__('Current Balance')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="current_balance"
                name="current_balance" :value="old('current_balance', $sale->current_balance ?? '')" />
            <x-input-error :messages="$errors->get('current_balance')" />
        </div>
    </div> --}}
</div>

<div class="row">
    {{-- Images --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="images" :value="__('Images')" />
            {{-- Preview existing images --}}
            @if (isset($sale) && is_array($sale->images) && count($sale->images))
                <div class="mb10">
                    @foreach ($sale->images as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="image"
                            style="max-height:80px; margin-right:8px;" />
                    @endforeach
                </div>
            @endif
            <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple />
            <x-input-error :messages="$errors->get('images')" />
            <x-input-error :messages="$errors->get('images.*')" />
        </div>
    </div>

    {{-- Videos --}}
    <!--  <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="videos" :value="__('Videos')" />
            {{-- Preview existing videos --}}
            @if (isset($sale) && is_array($sale->videos) && count($sale->videos))
<div class="mb10">
                    @foreach ($sale->videos as $v)
<video controls style="max-height:120px; margin-right:8px;">
                            <source src="{{ asset('storage/' . $v) }}">
                        </video>
@endforeach
                </div>
@endif
            <input type="file" class="form-control" id="videos" name="videos[]" accept="video/*" multiple />
            <x-input-error :messages="$errors->get('videos')" />
            <x-input-error :messages="$errors->get('videos.*')" />
        </div>
    </div> -->

    {{-- Documents --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="documents" :value="__('Documents')" />
            {{-- Preview existing documents --}}
            @if (isset($sale) && is_array($sale->documents) && count($sale->documents))
                <div class="mb10">
                    @foreach ($sale->documents as $d)
                        <div><a href="{{ asset('storage/' . $d) }}" target="_blank">{{ basename($d) }}</a></div>
                    @endforeach
                </div>
            @endif
            <input type="file" class="form-control" id="documents" name="documents[]"
                accept=".pdf,.doc,.docx,.xls,.xlsx" multiple />
            <x-input-error :messages="$errors->get('documents')" />
            <x-input-error :messages="$errors->get('documents.*')" />
        </div>
    </div>

    {{-- Links (one per line) --}}
    <div class="col-sm-12">
        <div class="mb20">
            <x-input-label class="heading-color" for="links" :value="__('Links (one per line)')" />
            {{-- Preview existing links --}}
            @if (isset($sale) && is_array($sale->links) && count($sale->links))
                <div class="mb10">
                    @foreach ($sale->links as $ln)
                        <div><a href="{{ $ln }}" target="_blank">{{ $ln }}</a></div>
                    @endforeach
                </div>
            @endif
            <textarea class="form-control" id="links" name="links" rows="3">{{ old('links') ? (is_array(old('links')) ? implode("\n", old('links')) : old('links')) : (isset($sale) && is_array($sale->links) ? implode("\n", $sale->links) : '') }}</textarea>
            <x-input-error :messages="$errors->get('links')" />
        </div>
    </div>

    {{-- Description --}}
    <div class="col-md-12">
        <div class="mb10">
            <x-input-label for="description" :value="__('Description')" />
            <textarea class="character-count" maxlength="400" cols="30" rows="4" name="description"
                id="description" placeholder="Description (Max 400 characters)">{{ old('description', $tour->description ?? '') }}</textarea>

            <div class="form-feedback d-flex justify-content-between">
                <div class="form-error text-start">
                    <x-input-error :messages="$errors->get('description')" />
                </div>
                <div class="form-helper-text small text-muted text-end mt-2">
                    <span class="remaining-characters">400</span>
                    <span class="remaining-characters-text">characters remaining</span>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        (function() {
            const price = document.getElementById('customer_fare');
            const payment = document.getElementById('customer_payment');
            const due = document.getElementById('customer_due');

            function compute() {
                const p = parseFloat(price?.value) || 0;
                const pay = parseFloat(payment?.value) || 0;
                if (due) due.value = (p - pay).toFixed(2);
            }

            [price, payment].forEach(el => {
                if (el) el.addEventListener('input', compute);
            });
            compute();

            // Handle trip type and return date readonly state
            const tripDropdown = document.getElementById('trip');
            const returnDateField = document.getElementById('return_date');

            function updateReturnDateState() {
                const selectedTrip = tripDropdown?.value?.toLowerCase() || '';
                if (returnDateField) {
                    if (selectedTrip === 'one way') {
                        returnDateField.setAttribute('readonly', 'readonly');
                        returnDateField.value = ''; // Clear value for one way
                    } else {
                        returnDateField.removeAttribute('readonly');
                    }
                }
            }

            if (tripDropdown) {
                tripDropdown.addEventListener('change', updateReturnDateState);
                // Call on initial load
                updateReturnDateState();
            }
        })();
    </script>
@endpush
