@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>{{ __('Payments history') }}</h3>
        </div>
        @if ($data->total() > 0)
            <div class="table-responsive">
                <table class="table table-borderless table-striped">
                    <tr>
                        <th class="table-light">{{ __('id') }}</th>
                        <th class="table-light">{{ __('Method') }}</th>
                        <th class="table-light">{{ __('Customer') }}</th>
                        <th class="table-light">{{ __('Date') }}</th>
                        <th class="table-light">{{ __('Created at') }}</th>
                    </tr>
                    @foreach($data as $paymentHistory)
                        <tr>
                            <td class="">{{ $paymentHistory->id }}</td>
                            <td class="">{{ $paymentHistory->method }}</td>
                            <td class="">{{ $paymentHistory->customer }}</td>
                            <td class="">{{ $paymentHistory->date }}</td>
                            <td class="">{{ $paymentHistory->created_at }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="d-felx justify-content-center pagination">
                {{ $data->links() }}
            </div>
        @else
            <p>
                {{ __('No payments history') }}
            </p>
        @endif
    </div>
</div>
@endsection
