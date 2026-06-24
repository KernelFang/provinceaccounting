<x-app-layout>
    <x-slot name="title">{{ __('User') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <h2 class="">
            {{ __('User') . ' ' . __('Management') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <form method="post" action="{{ route('users.store') }}" class="form-style1">
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('User') . ' ' . __('Registration') }}</h5>
                    </div>
                    <div class="col-lg-7">

                        <div class="row">
                            @include('users.form')
                        </div>
                    </div>
                </div>

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('Change') . ' ' . __('Password') }}</h5>
                    </div>
                    <div class="col-lg-7">
                        <div class="col-sm-6">
                            <div class="mb20">
                                <x-input-label class="heading-color" for="password" :value="__('Password')" />
                                <x-text-input type="password" class="form-control" id="password" name="password"
                                    required autocomplete="new-password" placeholder="********" />

                                <x-input-error :messages="$errors->get('password')" />
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="mb20">
                                <x-input-label class="heading-color" for="password_confirmation" :value="__('Confirm Password')" />
                                <x-text-input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="********" />

                                <x-input-error :messages="$errors->get('password_confirmation')" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="col-md-12">
                        <div class="text-start">
                            <x-primary-button type="submit">{{ __('Create Record') }}</x-primary-button>

                            @if (session('status') === 'User-created')
                                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                    class="text-sm text-gray">
                                    <i class="fal fa-arrow-right-long"></i>
                                    {{ __('Saved.') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
</x-app-layout>
