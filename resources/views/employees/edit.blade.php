<x-app-layout>
    <x-slot name="title">{{ __('Edit Employee') }}</x-slot>

    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center w-100">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Edit Employee') }}</h2>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-xl-8">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <form method="POST" action="{{ route('employees.update', $employee) }}">
                    @csrf @method('PUT')
                    @include('employees.form', ['employee' => $employee])
                    <div class="mt-3"><button class="ud-btn btn-thm">Update</button></div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
