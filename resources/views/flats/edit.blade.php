<x-app-layout>
    <x-slot name="title">{{ __('Flats') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <h2 class="">{{ __('Flats') . ' ' . __('Management') }}</h2>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <form method="post" action="{{ route('flats.update', $flat->id) }}" class="form-style1">
                {{ method_field('PATCH') }}
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('Update') . ' ' . __('Flat') . ' ' . __('Details') }}</h5>
                    </div>
                    <div class="col-lg-10">

                        <div class="row">
                            @include('flats.form')
                        </div>
                    </div>
                </div>

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="col-md-12">
                        <div class="text-start">
                            <x-primary-button type="submit">{{ __('Update Record') }}</x-primary-button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>