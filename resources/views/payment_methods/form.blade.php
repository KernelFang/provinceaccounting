<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="name" :value="__('Name')" />
        <x-text-input type="text" class="form-control" id="name" name="name" :value="old('name', $paymentMethod->name ?? '')" required
            autocomplete="name" />

        <x-input-error :messages="$errors->get('name')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="code_identifier" :value="__('Code Identifier')" />
        <x-text-input type="text" class="form-control" id="code_identifier" name="code_identifier"
            :value="old('code_identifier', $paymentMethod->code_identifier ?? '')" />

        <x-input-error :messages="$errors->get('code_identifier')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="type" :value="__('Type')" />
        <select id="type" name="type" class="form-control" required>
            <option value="" hidden>{{ __('Select type') }}</option>
            <option value="Cash" @selected(old('type', $paymentMethod->type ?? '') === 'Cash')>{{ __('Cash') }}</option>
            <option value="Bank" @selected(old('type', $paymentMethod->type ?? '') === 'Bank')>{{ __('Bank') }}</option>
            <option value="Mobile Banking" @selected(old('type', $paymentMethod->type ?? '') === 'Mobile Banking')>{{ __('Mobile Banking') }}</option>
            <option value="Gateway" @selected(old('type', $paymentMethod->type ?? '') === 'Gateway')>{{ __('Gateway') }}</option>
        </select>

        <x-input-error :messages="$errors->get('type')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="is_active" :value="__('Active')" />
        <select id="is_active" name="is_active" class="form-control" required>
            <option value="1" @selected(old('is_active', $paymentMethod->is_active ?? 1))>{{ __('Yes') }}</option>
            <option value="0" @selected(old('is_active', $paymentMethod->is_active ?? 1) == false)>{{ __('No') }}</option>
        </select>

        <x-input-error :messages="$errors->get('is_active')" />
    </div>
</div>

<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="account_details" :value="__('Account Details')" />
        <textarea class="character-count" maxlength="500" cols="30" rows="4" name="account_details"
            id="account_details" placeholder="Account Details (Max 500 characters)">{{ old('account_details', $paymentMethod->account_details ?? '') }}</textarea>
        <div class="form-feedback d-flex justify-content-between">
            <div class="form-error d-block text-start">
                <x-input-error :messages="$errors->get('account_details')" />
            </div>
            <div class="form-helper-text small text-muted d-block mt-2 text-end">
                <span class="remaining-characters">500</span>
                <span class="remaining-characters-text">characters remaining</span>
            </div>
        </div>
    </div>
</div>
