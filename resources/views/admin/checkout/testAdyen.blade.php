@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h3>{{ __('Process form') }}</h3>
            <form method="post" action="{{ route('admin_test_adyen_process') }}">
               @csrf
               <p>
                   <select name="countries" required>
                       <option value="">{{ __('Choose country') }}</option>
                       <option value="us">{{ __('US') }}</option>
                       <option value="bg">{{ __('BG') }}</option>
                       <option value="de">{{ __('DE') }}</option>
                       <option value="hu">{{ __('HU') }}</option>
                   </select>
               </p>
               <p>
                   <select name="payment_methods" required>
                       <option value="">{{ __('Choose payment method') }}</option>
                       <option value="card">{{ __('Card') }}</option>
                   </select>
               </p>
               <input class="form-control" type="submit" value="{{ __('Send') }}">
           </form>

            <h3>{{ __('Subscription form') }}</h3>
            <form method="post" action="{{ route('admin_test_adyen_subscription') }}">
                @csrf
                <input placeholder="{{ __('Email') }}" type="text" name="email" required>
                <p>
                    <select name="payment_methods" required>
                        <option value="">{{ __('Choose payment method') }}</option>
                        <option value="card">{{ __('Card') }}</option>
                    </select>
                </p>
                <p>
                    <select name="subscription_intervals" required>
                        <option value="">{{ __('Choose subscription interval') }}</option>
                        <option value="21">21</option>
                        <option value="30">30</option>
                        <option value="60">60</option>
                    </select>
                </p>
                <input class="form-control" type="submit" value="{{ __('Send') }}">
            </form>
            <h3>{{ __('Test webhook') }}</h3>
            <a class="btn btn-primary" href="{{ route("admin_test_adyen_webhook") }}">
                {{ __('Send') }}
            </a>
        </div>
    </div>
@endsection
