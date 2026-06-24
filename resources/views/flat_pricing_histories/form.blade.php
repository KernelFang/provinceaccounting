<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="flat_id" :value="__('Flat')" />
        <select id="flat_id" name="flat_id" class="form-control" required>
            <option value="" hidden>{{ __('Select flat') }}</option>
            @foreach ($flats ?? [] as $f)
                <option value="{{ $f->id }}" @selected(old('flat_id', $flatPricingHistory->flat_id ?? '') == $f->id)>{{ $f->flat_no }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('flat_id')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="price" :value="__('Price')" />
        <x-text-input type="number" class="form-control" id="price" name="price" :value="old('price', $flatPricingHistory->price ?? '')" step="0.01"
            min="0" required />

        <x-input-error :messages="$errors->get('price')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="effective_date" :value="__('Effective Date')" />
        <x-text-input type="date" class="form-control" id="effective_date" name="effective_date" :value="old(
            'effective_date',
            isset($flatPricingHistory->effective_date)
                ? $flatPricingHistory->effective_date->format('Y-m-d')
                : now()->format('Y-m-d'),
        )" />

        <x-input-error :messages="$errors->get('effective_date')" />
    </div>
</div>

<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="remarks" :value="__('Remarks')" />
        <textarea class="character-count" maxlength="500" cols="30" rows="4" name="remarks" id="remarks"
            placeholder="Remarks (Max 500 characters)">{{ old('remarks', $flatPricingHistory->remarks ?? '') }}</textarea>
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
