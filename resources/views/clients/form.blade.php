<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="first_name" :value="__('First Name')" />
        <x-text-input type="text" class="form-control" id="first_name" name="first_name" :value="old('first_name', $client->first_name ?? '')" required
            autocomplete="first_name" />

        <x-input-error :messages="$errors->get('first_name')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="last_name" :value="__('Last Name')" />
        <x-text-input type="text" class="form-control" id="last_name" name="last_name" :value="old('last_name', $client->last_name ?? '')" required
            autocomplete="last_name" />

        <x-input-error :messages="$errors->get('last_name')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="phone" :value="__('Phone')" />
        <x-text-input type="text" class="form-control" id="phone" name="phone" :value="old('phone', $client->phone ?? '')" required
            autocomplete="phone" />

        <x-input-error :messages="$errors->get('phone')" />
    </div>
</div>

<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="email" :value="__('Email')" />
        <x-text-input type="email" class="form-control" id="email" name="email" :value="old('email', $client->email ?? '')" required
            autocomplete="email" />

        <x-input-error :messages="$errors->get('email')" />
    </div>
</div>

<div class="col-12">
    <div class="mb20">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control" rows="3">{{ old('address', $client->address ?? '') }}</textarea>
        @error('address')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>
