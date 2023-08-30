@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <h3>{{ __('Details') }}</h3>
        </div>
        <div class="col-4">
            <a href="{{ route('paymentsApisResponseHistory')  }}" class="btn btn-info float-end">{{ __('Back') }}</a>
        </div>
        @if ($data)
        <div>
            <b>
                {{ __('Content') }}
            </b>
            <p>
                {{ $data->content }}
            </p>
            <b>
                {{ __('Response') }}
            </b>
            <p>
                {{ $data->response }}
            </p>
            <b>
                {{ __('Method') }}
            </b>
            <p>
                {{ $data->method }}
            </p>
            <b>
                {{ __('Provider') }}
            </b>
            <p>
                {{ $data->provider }}
            </p>
            <b>
                {{ __('Provider config') }}
            </b>
            <p>
                {{ $data->provider_config }}
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
