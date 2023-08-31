@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
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
        </div>
    </div>
@endsection
