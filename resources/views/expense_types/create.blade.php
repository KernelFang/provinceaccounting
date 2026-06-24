<x-app-layout>
    <x-slot name="title">{{ __('Create Expense Type') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Expense Type') }}
            </h2>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <form method="POST" action="{{ route('expense-types.store') }}" class="form-style1">
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">
                            {{ __('Create') . ' ' . __('Expense Type') }}
                        </h5>
                    </div>

                    <div class="col-lg-10">
                        <div class="row">
                            @include('expense_types.form')
                        </div>
                    </div>
                </div>

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="col-md-12">
                        <div class="text-start">
                            <x-primary-button type="submit">
                                {{ __('Create Record') }}
                            </x-primary-button>

                            <a href="{{ route('expense-types.index') }}"
                               class="btn btn-link ms-2">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>