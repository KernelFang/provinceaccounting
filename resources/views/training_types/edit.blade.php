@php
    $trainingType = $trainingType ?? $trainingType;
@endphp

<x-app-layout>
    <x-slot name="title">{{ __('Edit Training Type') }}</x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Training Type') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <form method="post" action="{{ route('training-types.update', $trainingType) }}" class="form-style1">
                {{ method_field('PATCH') }}
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">
                            {{ __('Update') . ' ' . __('Training Type') . ' ' . __('Details') }}
                        </h5>
                    </div>

                    <div class="col-lg-7">
                        <div class="row">
                            @include('training_types.form')
                        </div>
                    </div>
                </div>

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="col-md-12">
                        <div class="text-start">
                            <x-primary-button type="submit">
                                {{ __('Update Record') }}
                            </x-primary-button>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
