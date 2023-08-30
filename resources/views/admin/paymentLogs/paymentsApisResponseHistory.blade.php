@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3>{{ __('Payments apis response history') }}</h3>
        </div>
        @if ($data->total() > 0)
            <div class="table-responsive">
                <table class="table table-borderless table-striped">
                    <tr>
                        <th class="table-light">{{ __('id') }}</th>
                        <th class="table-light">{{ __('Method') }}</th>
                        <th class="table-light">{{ __('Provider') }}</th>
                        <th class="table-light">{{ __('Created at') }}</th>
                        <th class="table-light">{{ __('Action') }}</th>
                    </tr>
                    @foreach($data as $paymentApisResponseHistory)
                        <tr>
                            <td class="">{{ $paymentApisResponseHistory->id }}</td>
                            <td class="">{{ $paymentApisResponseHistory->method }}</td>
                            <td class="">{{ $paymentApisResponseHistory->provider }}</td>
                            <td class="">{{ $paymentApisResponseHistory->created_at }}</td>
                            <td class="">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ __('Select') }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('paymentApisResponseHistoryDetails', [
                                                'paymentApisResponseHistory' => $paymentApisResponseHistory]) }}">
                                                {{ __('Details') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="d-felx justify-content-center pagination">
                {{ $data->links() }}
            </div>
        @else
            <p>
                {{ __('No payments apis response history') }}
            </p>
        @endif
    </div>
</div>
@endsection
