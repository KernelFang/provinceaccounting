<x-app-layout>
    <x-slot name="title">{{ __('New Tour / Hotel / Car') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('New Tour / Hotel / Car') }}</h2>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <form method="post" action="{{ route('tours.store') }}" class="form-style1">
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('Create') . ' ' . __('Tour') }}</h5>
                    </div>
                    <div class="col-lg-10">
                        <div class="row">
                            @include('tours.form')
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
