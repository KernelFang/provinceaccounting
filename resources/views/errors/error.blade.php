@extends('errors::layout')

@section('title', __('Error'))

@section('message')
    <div class="row">
        <div class="col-xl-12">
            <div class="ps-widget bgc-white bdrs4 p30 mb30 overflow-hidden position-relative">
                <div class="packages_table table-responsive text-center">
                    <h4>Error {{ $status ?? 'Unknown' }}</h4>
                    <p>{{ $error ?? 'An unexpected error occurred.' }}</p>
                    <a href="{{ route('login') }}" class="btn btn-primary mt-4">Go Back to Login</a>
                </div>
            </div>
        </div>
    </div>
@endsection
