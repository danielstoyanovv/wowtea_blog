@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <form action="{{ route('admin_test_paypal') }}" method="POST">
                @csrf
                <input placeholder="{{ __('Price') }}" type="text" name="price" class="price" value="" required>
                <input type="submit" class="btn btn-primary form-control add-product-button" value="{{ __('Pay') }}">
            </form>
        </div>
    </div>
@endsection
