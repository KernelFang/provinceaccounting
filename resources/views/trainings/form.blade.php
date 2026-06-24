@php
    $item = $item ?? null;
@endphp

<div class="row">
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="training_type" :value="__('Training Type')" />

                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="training_type" name="training_type">
                        <option value="" disabled
                            {{ is_null(old('training_type', $item->training_type ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>

                        @foreach ($trainingTypes ?? collect() as $tt)
                            <option value="{{ $tt->name }}" @selected(old('training_type', $item->training_type ?? null) === $tt->name)>
                                {{ $tt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <x-input-error :messages="$errors->get('training_type')" />
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="title" :value="__('Title')" />
            <x-text-input type="text" class="form-control" id="title" name="title" :value="old('title', $item->title ?? '')" />
            <x-input-error :messages="$errors->get('title')" />
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_name" :value="__('Customer Name')" />
            <x-text-input type="text" class="form-control" id="customer_name" name="customer_name"
                :value="old('customer_name', $item->customer_name ?? '')" />
            <x-input-error :messages="$errors->get('customer_name')" />
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_number" :value="__('Customer Number')" />
            <x-text-input type="text" class="form-control" id="customer_number" name="customer_number"
                :value="old('customer_number', $item->customer_number ?? '')" />
            <x-input-error :messages="$errors->get('customer_number')" />
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="package" :value="__('Package')" />
            <x-text-input type="text" class="form-control" id="package" name="package" :value="old('package', $item->package ?? '')" />
            <x-input-error :messages="$errors->get('package')" />
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="agent_cost" :value="__('Agent Cost')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="agent_cost"
                name="agent_cost" :value="old('agent_cost', $item->agent_cost ?? '')" />
            <x-input-error :messages="$errors->get('agent_cost')" />
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_price" :value="__('Customer Price')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_price"
                name="customer_price" :value="old('customer_price', $item->customer_price ?? '')" />
            <x-input-error :messages="$errors->get('customer_price')" />
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_payment" :value="__('Customer Payment')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_payment"
                name="customer_payment" :value="old('customer_payment', $item->customer_payment ?? '')" />
            <x-input-error :messages="$errors->get('customer_payment')" />
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="customer_due" :value="__('Customer Due')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control" id="customer_due"
                name="customer_due" :value="old('customer_due', $item->customer_due ?? '')" readonly />
            <x-input-error :messages="$errors->get('customer_due')" />
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="purchase_date" :value="__('Purchase Date')" />
            <x-text-input type="date" class="form-control" id="purchase_date" name="purchase_date"
                :value="old('purchase_date', isset($item->purchase_date) ? $item->purchase_date->format('Y-m-d') : '')" />
            <x-input-error :messages="$errors->get('purchase_date')" />
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb10">
            <x-input-label for="description" :value="__('Description')" />
            <textarea class="character-count" maxlength="400" cols="30" rows="4" name="description" id="description"
                placeholder="Description (Max 400 characters)">{{ old('description', $item->description ?? '') }}</textarea>
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
