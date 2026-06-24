@php
    $portals = $portals ?? collect();
    $infos = $infos ?? collect();
    $item = $item ?? ($portal_balance ?? null);
@endphp

<div class="row">
    {{-- Transaction Type --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="transaction_type" :value="__('Transaction Type')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" id="transaction_type" name="transaction_type" required>
                        <option value="" disabled
                            {{ is_null(old('transaction_type', $item->transaction_type ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        <option value="credit"
                            @selected(old('transaction_type', $item->transaction_type ?? null) === 'credit')>
                            Credit
                        </option>
                        <option value="debit"
                            @selected(old('transaction_type', $item->transaction_type ?? null) === 'debit')>
                            Debit
                        </option>
                    </select>
                </div>
                <x-input-error :messages="$errors->get('transaction_type')" />
            </div>
        </div>
    </div>

    {{-- Info --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="info" :value="__('Transaction Platform')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="info" name="info" required>
                        <option value="" disabled
                            {{ is_null(old('info', $item->info ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($infos as $inf)
                            <option value="{{ $inf->name }}"
                                @selected(old('info', $item->info ?? null) === $inf->name)>
                                {{ $inf->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('info')" />
            </div>
        </div>
    </div>

    {{-- Date --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="date" :value="__('Date')" />
            <x-text-input type="date" class="form-control" id="date" name="date"
                :value="old('date', isset($item->date) ? $item->date->format('Y-m-d') : '')"  />
            <x-input-error :messages="$errors->get('date')" />
        </div>
    </div>

    {{-- Portal --}}
    <div class="col-sm-6">
        <div class="mb20">
            <div class="form-style1">
                <x-input-label class="heading-color" for="portal" :value="__('Portal')" />
                <div class="bootselect-multiselect">
                    <select class="selectpicker" data-live-search="true" id="portal" name="portal" required>
                        <option value="" disabled
                            {{ is_null(old('portal', $item->portal ?? null)) ? 'selected' : '' }}>
                            Select
                        </option>
                        @foreach ($portals as $p)
                            <option value="{{ $p->name }}"
                                @selected(old('portal', $item->portal ?? null) === $p->name)>
                                {{ $p->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('portal')" />
            </div>
        </div>
    </div>

    {{-- Recharge --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="recharge" :value="__('Amount')" />
            <x-text-input type="number" step="0.01" min="0" class="form-control"
                id="recharge" name="recharge"
                :value="old('recharge', $item->recharge ?? '')" />
            <x-input-error :messages="$errors->get('recharge')" />
        </div>
    </div>

    {{-- Sender --}}
    <div class="col-sm-6">
        <div class="mb20">
            <x-input-label class="heading-color" for="sender" :value="__('Sender')" />
            <x-text-input type="text" class="form-control" id="sender" name="sender"
                :value="old('sender', $item->sender ?? '')" />
            <x-input-error :messages="$errors->get('sender')" />
        </div>
    </div>

    {{-- Reference --}}
    <div class="col-md-12">
        <div class="mb10">
            <x-input-label class="heading-color" for="reference" :value="__('Reference')" />
            <x-text-input type="text" class="form-control" id="reference" name="reference"
                :value="old('reference', $item->reference ?? '')" />
            <x-input-error :messages="$errors->get('reference')" />
        </div>
    </div>

    {{-- Remarks --}}
    <div class="col-md-12">
        <div class="mb10">
            <x-input-label for="remarks" :value="__('Remarks')" />
            <textarea class="character-count" maxlength="400" cols="30" rows="4"
                name="remarks" id="remarks"
                placeholder="Remarks (Max 400 characters)">{{ old('remarks', $item->remarks ?? '') }}</textarea>

            <div class="form-feedback d-flex justify-content-between">
                <div class="form-error text-start">
                    <x-input-error :messages="$errors->get('remarks')" />
                </div>
                <div class="form-helper-text small text-muted text-end mt-2">
                    <span class="remaining-characters">400</span>
                    <span class="remaining-characters-text">characters remaining</span>
                </div>
            </div>
        </div>
    </div>
</div>
