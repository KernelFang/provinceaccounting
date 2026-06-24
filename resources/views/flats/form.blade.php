<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="project_id" :value="__('Project')" />
        <select id="project_id" name="project_id" class="form-control" required>
            <option value="" hidden>{{ __('Select project') }}</option>
            @foreach ($projects ?? [] as $p)
                <option value="{{ $p->id }}" @selected(old('project_id', $flat->project_id ?? '') == $p->id)>{{ $p->name }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('project_id')" />
    </div>
</div>

<div class="col-sm-2">
    <div class="mb20">
        <x-input-label class="heading-color" for="building_no" :value="__('Building No')" />
        <x-text-input type="text" class="form-control" id="building_no" name="building_no" :value="old('building_no', $flat->building_no ?? '')" />

        <x-input-error :messages="$errors->get('building_no')" />
    </div>
</div>

<div class="col-sm-2">
    <div class="mb20">
        <x-input-label class="heading-color" for="floor_no" :value="__('Floor No')" />
        <x-text-input type="text" class="form-control" id="floor_no" name="floor_no" :value="old('floor_no', $flat->floor_no ?? '')" />

        <x-input-error :messages="$errors->get('floor_no')" />
    </div>
</div>

<div class="col-sm-2">
    <div class="mb20">
        <x-input-label class="heading-color" for="flat_no" :value="__('Flat No')" />
        <x-text-input type="text" class="form-control" id="flat_no" name="flat_no" :value="old('flat_no', $flat->flat_no ?? '')" required />

        <x-input-error :messages="$errors->get('flat_no')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="total_flat_area_sqft" :value="__('Area (sqft)')" />
        <x-text-input type="number" class="form-control" id="total_flat_area_sqft" name="total_flat_area_sqft"
            :value="old('total_flat_area_sqft', $flat->total_flat_area_sqft ?? '')" step="0.01" min="0" />

        <x-input-error :messages="$errors->get('total_flat_area_sqft')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="cost_per_sqft" :value="__('Cost per sqft')" />
        <x-text-input type="number" class="form-control" id="cost_per_sqft" name="cost_per_sqft" :value="old('cost_per_sqft', $flat->cost_per_sqft ?? '')"
            step="0.01" min="0" />

        <x-input-error :messages="$errors->get('cost_per_sqft')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="base_price" :value="__('Base Price')" />
        <x-text-input type="number" class="form-control" id="base_price" name="base_price" :value="old('base_price', $flat->base_price ?? '')"
            step="0.01" min="0" />

        <x-input-error :messages="$errors->get('base_price')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="client_owner_status" :value="__('Owner Status')" />
        <select id="client_owner_status" name="client_owner_status" class="form-control" required>
            <option value="pending" @selected(old('client_owner_status', $flat->client_owner_status ?? '') === 'pending')>{{ __('Pending') }}</option>
            <option value="ongoing" @selected(old('client_owner_status', $flat->client_owner_status ?? '') === 'ongoing')>{{ __('Ongoing') }}</option>
            <option value="cancelled" @selected(old('client_owner_status', $flat->client_owner_status ?? '') === 'cancelled')>{{ __('Cancelled') }}</option>
            <option value="completed" @selected(old('client_owner_status', $flat->client_owner_status ?? '') === 'completed')>{{ __('Completed') }}</option>
        </select>

        <x-input-error :messages="$errors->get('client_owner_status')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="current_owner_id" :value="__('Current Owner')" />
        <select id="current_owner_id" name="current_owner_id" class="form-control">
            <option value="">{{ __('None') }}</option>
            @foreach ($clients ?? [] as $c)
                <option value="{{ $c->id }}" @selected(old('current_owner_id', $flat->current_owner_id ?? '') == $c->id)>{{ $c->first_name }}
                    {{ $c->last_name }}</option>
            @endforeach
        </select>

        <x-input-error :messages="$errors->get('current_owner_id')" />
    </div>
</div>
