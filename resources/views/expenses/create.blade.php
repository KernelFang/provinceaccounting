<x-app-layout>
    <x-slot name="title">{{ __('Expense') . ' ' . __('Management') }}</x-slot>

    <x-slot name="header">
        <h2 class="">
            {{ __('Expense') . ' ' . __('Management') }}
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-xl-12">
            <form method="post" action="{{ route('expenses.store') }}" class="form-style1">
                @csrf

                <div class="ps-widget bgc-white bdrs4 p30 mb30 position-relative">
                    <div class="bdrb1 pb15 mb25">
                        <h5 class="list-title">{{ __('Create') . ' ' . __('Expense') }}</h5>
                    </div>
                    <div class="col-lg-7">

                        <div class="row">
                            @include('expenses.form')
                        </div>
                    </div>
                </div>

                <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                    <div class="col-md-12">
                        <div class="text-start">
                            <x-primary-button type="submit">{{ __('Create Record') }}</x-primary-button>

                            @if (session('status') === 'expense-create')
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
