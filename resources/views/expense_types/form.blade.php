<div class="col-md-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="name" :value="__('Name')" />
        <x-text-input type="text" class="form-control" id="name" name="name" :value="old('name', $expenseType->name ?? '')" required />
        <x-input-error :messages="$errors->get('name')" />
    </div>
</div>

<div class="col-md-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="is_active" :value="__('Active')" />
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1"
                @checked(old('is_active', $expenseType->is_active ?? true))>
            <label class="form-check-label" for="is_active">{{ __('Enabled') }}</label>
        </div>
        <x-input-error :messages="$errors->get('is_active')" />
    </div>
</div>

<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="description" :value="__('Description')" />
        <textarea class="form-control" name="description" id="description" rows="4">{{ old('description', $expenseType->description ?? '') }}</textarea>
        <x-input-error :messages="$errors->get('description')" />
    </div>
</div>
