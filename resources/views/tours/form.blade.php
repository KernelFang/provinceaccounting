@php
    $purposes = $purposes ?? collect();
    $countries = $countries ?? collect();
    $tour = $tour ?? null;
@endphp

<div class="row">
    {{-- Title --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="title" :value="__('Title')" />
            <x-text-input type="text" class="form-control" id="title" name="title" :value="old('title', $tour->title ?? '')" />
            <x-input-error :messages="$errors->get('title')" />
        </div>
    </div>

    {{-- Purpose --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="purpose" :value="__('Purpose')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="purpose" name="purpose" required>
                        <option value="" disabled
                            {{ is_null(old('purpose', $tour->purpose ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($purposes as $p)
                            <option value="{{ $p->name }}" @selected(old('purpose', $tour->purpose ?? null) === $p->name)>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('purpose')" />
            </div>
        </div>
    </div>

    {{-- Country --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="country" :value="__('Country')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="country" name="country" required>
                        <option value="" disabled
                            {{ is_null(old('country', $tour->country ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($countries as $c)
                            <option value="{{ $c->name }}" @selected(old('country', $tour->country ?? null) === $c->name)>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('country')" />
            </div>
        </div>
    </div>

    {{-- From Date --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="from_date" :value="__('From Date')" />
            <x-text-input type="date" class="form-control" id="from_date" name="from_date" :value="old('from_date', isset($tour->from_date) ? $tour->from_date->format('Y-m-d') : '')" />
            <x-input-error :messages="$errors->get('from_date')" />
        </div>
    </div>

    {{-- To Date --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="to_date" :value="__('To Date')" />
            <x-text-input type="date" class="form-control" id="to_date" name="to_date" :value="old('to_date', isset($tour->to_date) ? $tour->to_date->format('Y-m-d') : '')" />
            <x-input-error :messages="$errors->get('to_date')" />
        </div>
    </div>

    {{-- Purchase Date --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="purchase_date" :value="__('Purchase Date')" />
            <x-text-input type="date" class="form-control" id="purchase_date" name="purchase_date"
                :value="old('purchase_date', isset($tour->purchase_date) ? $tour->purchase_date->format('Y-m-d') : '')" />
            <x-input-error :messages="$errors->get('purchase_date')" />
        </div>
    </div>

    {{-- Status --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="status" :value="__('Status')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="status" name="status" required>
                        <option value="" disabled
                            {{ is_null(old('status', $tour->status ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        <option value="pending" @selected(old('status', $tour->status ?? null) === 'pending')>Pending</option>
                        <option value="inprogress" @selected(old('status', $tour->status ?? null) === 'inprogress')>In Progress</option>
                        <option value="completed" @selected(old('status', $tour->status ?? null) === 'completed')>Completed</option>
                        <option value="cancelled" @selected(old('status', $tour->status ?? null) === 'cancelled')>Cancelled</option>
                    </select>
                </div>

                <x-input-error :messages="$errors->get('status')" />
            </div>
        </div>
    </div>

    {{-- Customer --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer" :value="__('Customer')" />
            <x-text-input type="text" class="form-control" id="customer" name="customer" :value="old('customer', $tour->customer ?? '')" />
            <x-input-error :messages="$errors->get('customer')" />
        </div>
    </div>

    {{-- Person --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="person" :value="__('Person')" />
            <x-text-input type="number" class="form-control" id="person" name="person" :value="old('person', $tour->person ?? '')" />
            <x-input-error :messages="$errors->get('person')" />
        </div>
    </div>

    {{-- Mobile Number --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="mobile_number" :value="__('Mobile Number')" />
            <x-text-input type="text" class="form-control" id="mobile_number" name="mobile_number"
                :value="old('mobile_number', $tour->mobile_number ?? '')" />
            <x-input-error :messages="$errors->get('mobile_number')" />
        </div>
    </div>

    {{-- Emergency Number --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="emergency_number" :value="__('Emergency Number')" />
            <x-text-input type="text" class="form-control" id="emergency_number" name="emergency_number"
                :value="old('emergency_number', $tour->emergency_number ?? '')" />
            <x-input-error :messages="$errors->get('emergency_number')" />
        </div>
    </div>

    {{-- Agent Cost --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="agent_cost" :value="__('Agent Cost')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="agent_cost"
                name="agent_cost" :value="old('agent_cost', $tour->agent_cost ?? '')" />
            <x-input-error :messages="$errors->get('agent_cost')" />
        </div>
    </div>

    {{-- Customer Price --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_price" :value="__('Customer Price')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_price"
                name="customer_price" :value="old('customer_price', $tour->customer_price ?? '')" />
            <x-input-error :messages="$errors->get('customer_price')" />
        </div>
    </div>

    {{-- Customer Payment --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_payment" :value="__('Customer Payment')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_payment"
                name="customer_payment" :value="old('customer_payment', $tour->customer_payment ?? '')" />
            <x-input-error :messages="$errors->get('customer_payment')" />
        </div>
    </div>

    {{-- Customer Due --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_due" :value="__('Customer Due')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_due"
                name="customer_due" :value="old('customer_due', $tour->customer_due ?? '')" readonly />
            <x-input-error :messages="$errors->get('customer_due')" />
        </div>
    </div>

    {{-- Profit --}}
    {{-- <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="profit" :value="__('Profit')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control"
                id="profit" name="profit"
                :value="old('profit', $tour->profit ?? '')" />
            <x-input-error :messages="$errors->get('profit')" />
        </div>
    </div> --}}

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
            const price = document.getElementById('customer_price');
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
        })();
    </script>
@endpush
