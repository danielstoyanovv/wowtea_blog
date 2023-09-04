@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <h3>{{ __('Details') }}</h3>
            </div>
            <div class="col-4">
                <a href="{{ route('admin_test_adyen_webhook_response_history_page')  }}" class="btn btn-info float-end">{{ __('Back') }}</a>
            </div>
            @if ($data)
                <div>
                    <b>
                        {{ __('response') }}
                    </b>
                    <p>
                        {{ $data->response }}
                    </p>
                    <b>
                        {{ __('Event code') }}
                    </b>
                    <p>
                        {{ $data->eventCode }}
                    </p>
                    <b>
                        {{ __('provider') }}
                    </b>
                    <p>
                        {{ $data->provider }}
                    </p>
                    <b>
                        {{ __('Created') }}
                    </b>
                    <p>
                        {{ $data->created_at }}
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection
