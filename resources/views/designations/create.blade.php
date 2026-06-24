<x-app-layout>
    <x-slot name="title">{{ __('Create Designation') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Designation') }}</h2>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <form method="POST" action="{{ route('designations.store') }}" class="form-style1">
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('Create') . ' ' . __('Designation') }}</h5>
                    </div>
                    <div class="col-lg-10">
                        <div class="row">
                            @include('designations.form', ['item' => null])
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
