<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="name" :value="__('Project Name')" />
        <x-text-input type="text" class="form-control" id="name" name="name" :value="old('name', $project->name ?? '')" required
            autocomplete="name" />

        <x-input-error :messages="$errors->get('name')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="location" :value="__('Location')" />
        <x-text-input type="text" class="form-control" id="location" name="location" :value="old('location', $project->location ?? '')" required
            autocomplete="location" />

        <x-input-error :messages="$errors->get('location')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="status" :value="__('Status')" />
        <select id="status" name="status" class="form-control" required>
            <option value="pending" @selected(old('status', $project->status ?? '') === 'pending')>{{ __('Pending') }}</option>
            <option value="ongoing" @selected(old('status', $project->status ?? '') === 'ongoing')>{{ __('Ongoing') }}</option>
            <option value="completed" @selected(old('status', $project->status ?? '') === 'completed')>{{ __('Completed') }}</option>
        </select>

        <x-input-error :messages="$errors->get('status')" />
    </div>
</div>

<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="description" :value="__('Description')" />
        <textarea class="character-count" maxlength="500" cols="30" rows="4" name="description" id="description"
            placeholder="Description (Max 500 characters)">{{ old('description', $project->description ?? '') }}</textarea>
        <div class="form-feedback d-flex justify-content-between">
            <div class="form-error d-block text-start">
                <x-input-error :messages="$errors->get('description')" />
            </div>
            <div class="form-helper-text small text-muted d-block mt-2 text-end">
                <span class="remaining-characters">500</span>
                <span class="remaining-characters-text">characters remaining</span>
            </div>
        </div>
    </div>
</div>
