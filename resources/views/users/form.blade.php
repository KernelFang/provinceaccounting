<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="name" :value="__('Name')" />
        <x-text-input type="text" class="form-control" id="name" name="name" :value="old('name', $user->name)" required
            autocomplete="name" />

        <x-input-error :messages="$errors->get('name')" />
    </div>
</div>
<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="email" :value="__('Email')" />
        <x-text-input type="email" class="form-control" id="email" name="email" :value="old('email', $user->email)" required
            autocomplete="email" />

        <x-input-error :messages="$errors->get('email')" />

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
            <div>
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="btn btn-primary">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            </div>
        @endif
    </div>
</div>
<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="username" :value="__('Username')" />

        @if (isset($mode) && $mode === 'edit')
            <x-text-input type="text" class="form-control" id="username" :value="$user->username" disabled />
        @else
            <x-text-input type="text" class="form-control" id="username" name="username" :value="old('username', $user->username)"
                required />
        @endif

        <x-input-error :messages="$errors->get('username')" />
    </div>
</div>
<div class="col-sm-6">
    <div class="mb20">
        <div class="form-style1">
            <x-input-label class="heading-color" for="user_type" :value="__('Role')" />
            <div class="bootselect-multiselect">
                <select class="selectpicker" data-live-search="true" id="user_type" name="user_type" required>
                    <option value="" disabled {{ is_null(old('user_type', $user->user_type)) ? 'selected' : '' }}>
                        Select</option>
                    @if (auth()->user()->user_type === 'admin')
                        <option value="admin" @selected(old('user_type', $user->user_type) === 'admin')>Admin</option>
                    @endif
                    <option value="staff" @selected(old('user_type', $user->user_type) === 'staff')>Staff</option>
                </select>
            </div>

            <x-input-error :messages="$errors->get('user_type')" />
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="mb20">
        <div class="form-style1">
            <x-input-label class="heading-color" for="gender" :value="__('Gender')" />
            <div class="bootselect-multiselect">
                <select class="selectpicker" data-live-search="true" id="gender" name="gender" required>
                    <option value="" disabled {{ is_null(old('gender', $user->gender)) ? 'selected' : '' }}>
                        Select</option>
                    <option value="male" @selected(old('gender', $user->gender) === 'male')>Male</option>
                    <option value="female" @selected(old('gender', $user->gender) === 'female')>Female</option>
                    <option value="other" @selected(old('gender', $user->gender) === 'others')>Others</option>
                </select>
            </div>

            <x-input-error :messages="$errors->get('gender')" />
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="joining_date" :value="__('Joining Date')" />
        <x-text-input type="date" class="form-control" id="joining_date" name="joining_date" :value="old('joining_date', $user->joining_date?->format('Y-m-d'))"
            required />

        <x-input-error :messages="$errors->get('joining_date')" />
    </div>
</div>
<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="contact" :value="__('Contact')" />
        <x-text-input type="text" class="form-control" id="contact" name="contact" :value="old('contact', $user->contact)" required />

        <x-input-error :messages="$errors->get('contact')" />
    </div>
</div>
<div class="col-sm-6">
    <div class="mb20">
        <x-input-label class="heading-color" for="date_of_birth" :value="__('Date of Birth')" />
        <x-text-input type="date" class="form-control" id="date_of_birth" name="date_of_birth" :value="old('date_of_birth', $user->date_of_birth?->format('Y-m-d'))"
            required />

        <x-input-error :messages="$errors->get('date_of_birth')" />
    </div>
</div>
<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="address" :value="__('Address')" />
        <textarea class="character-count" maxlength="250" cols="30" rows="2" name="address" id="address"
            placeholder="Address (Max 250 characters)">{{ old('address', $user->address) }}</textarea>
        <div class="form-feedback d-flex justify-content-between">
            <div class="form-error d-block text-start">
                <x-input-error :messages="$errors->get('address')" />
            </div>
            <div class="form-helper-text small text-muted d-block mt-2 text-end">
                <span class="remaining-characters">250</span>
                <span class="remaining-characters-text">characters remaining</span>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12">
    <div class="mb10">
        <x-input-label for="about_me" :value="__('Introduce Yourself')" />
        <textarea class="character-count" maxlength="600" cols="30" rows="6" name="about_me" id="about_me"
            placeholder="Describe yourself (Max 600 characters)">{{ old('about_me', $user->about_me) }}</textarea>
        <div class="form-feedback d-flex justify-content-between">
            <div class="form-error d-block text-start">
                <x-input-error :messages="$errors->get('about_me')" />
            </div>
            <div class="form-helper-text small text-muted d-block mt-2 text-end">
                <span class="remaining-characters">600</span>
                <span class="remaining-characters-text">characters remaining</span>
            </div>
        </div>
    </div>
</div>
