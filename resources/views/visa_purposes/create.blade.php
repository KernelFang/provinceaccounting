<x-app-layout>
    <x-slot name="title">{{ __('Create Visa Purpose') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Visa Purpose') }}</h2>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <form action="{{ route('visa-purposes.store') }}" method="POST" class="form-style1">
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('Create') . ' ' . __('Visa Purpose') }}</h5>
                    </div>
                    <div class="col-lg-10">
                        <div class="row">
                            @include('visa_purposes.form')
                        </div>
                    </div>
                </div>

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="col-md-12">
                        <div class="text-start">
                            <x-primary-button type="submit">{{ __('Create Record') }}</x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
