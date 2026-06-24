<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="project_id" :value="__('Project')" />
        <select id="project_id" name="project_id" class="form-control" required>
            <option value="" hidden>{{ __('Select project') }}</option>
            @foreach ($projects ?? [] as $p)
                <option value="{{ $p->id }}" @selected(old('project_id', $income->project_id ?? '') == $p->id)>{{ $p->name }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('project_id')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="flat_id" :value="__('Flat')" />
        <select id="flat_id" name="flat_id" class="form-control" required>
            <option value="" hidden>{{ __('Select flat') }}</option>
            @foreach ($flats ?? [] as $f)
                <option value="{{ $f->id }}" @selected(old('flat_id', $income->flat_id ?? '') == $f->id)>{{ $f->flat_no }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('flat_id')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="client_id" :value="__('Client')" />
        <select id="client_id" name="client_id" class="form-control" required>
            <option value="" hidden>{{ __('Select client') }}</option>
            @foreach ($clients ?? [] as $c)
                <option value="{{ $c->id }}" @selected(old('client_id', $income->client_id ?? '') == $c->id)>{{ $c->first_name }}
                    {{ $c->last_name }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('client_id')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="payment_method_id" :value="__('Payment Method')" />
        <select id="payment_method_id" name="payment_method_id" class="form-control">
            <option value="" hidden>{{ __('Select payment method') }}</option>
            @foreach ($paymentMethods ?? [] as $pm)
                <option value="{{ $pm->id }}" @selected(old('payment_method_id', $income->payment_method_id ?? '') == $pm->id)>{{ $pm->name }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('payment_method_id')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="purpose" :value="__('Purpose')" />
        <x-text-input type="text" class="form-control" id="purpose" name="purpose" :value="old('purpose', $income->purpose ?? '')" />

        <x-input-error :messages="$errors->get('purpose')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="price" :value="__('Price')" />
        <x-text-input type="number" class="form-control" id="price" name="price" :value="old('price', $income->price ?? '')"
            step="0.01" min="0" required />

        <x-input-error :messages="$errors->get('price')" />
    </div>
</div>

<div class="col-sm-3">
    <div class="mb20">
        <x-input-label class="heading-color" for="invoice_no" :value="__('Invoice No')" />
        <x-text-input type="text" class="form-control" id="invoice_no" name="invoice_no" :value="old('invoice_no', $income->invoice_no ?? '')" />

        <x-input-error :messages="$errors->get('invoice_no')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="clearing_status" :value="__('Clearing Status')" />
        <select id="clearing_status" name="clearing_status" class="form-control" required>
            <option value="pending" @selected(old('clearing_status', $income->clearing_status ?? '') === 'pending')>{{ __('Pending') }}</option>
            <option value="cleared" @selected(old('clearing_status', $income->clearing_status ?? '') === 'cleared')>{{ __('Cleared') }}</option>
            <option value="bounced" @selected(old('clearing_status', $income->clearing_status ?? '') === 'bounced')>{{ __('Bounced') }}</option>
        </select>

        <x-input-error :messages="$errors->get('clearing_status')" />
    </div>
</div>

<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="remarks" :value="__('Remarks')" />
        <textarea class="character-count" maxlength="500" cols="30" rows="4" name="remarks" id="remarks"
            placeholder="Remarks (Max 500 characters)">{{ old('remarks', $income->remarks ?? '') }}</textarea>
        <div class="form-feedback d-flex justify-content-between">
            <div class="form-error d-block text-start">
                <x-input-error :messages="$errors->get('remarks')" />
            </div>
            <div class="form-helper-text small text-muted d-block mt-2 text-end">
                <span class="remaining-characters">500</span>
                <span class="remaining-characters-text">characters remaining</span>
            </div>
        </div>
    </div>
</div>
