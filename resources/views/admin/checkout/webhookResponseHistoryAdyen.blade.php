@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3>{{ __('Webhook response history') }}</h3>
            </div>
            @if ($data->total() > 0)
                <div class="table-responsive">
                    <table class="table table-borderless table-striped">
                        <tr>
                            <th class="table-light">{{ __('id') }}</th>
                            <th class="table-light">{{ __('Event code') }}</th>
                            <th class="table-light">{{ __('Provider') }}</th>
                            <th class="table-light">{{ __('Created at') }}</th>
                            <th class="table-light">{{ __('Action') }}</th>
                        </tr>
                        @foreach($data as $webhookResponseHistory)
                            <tr>
                                <td class="">{{ $webhookResponseHistory->id }}</td>
                                <td class="">{{ $webhookResponseHistory->eventCode }}</td>
                                <td class="">{{ $webhookResponseHistory->provider }}</td>
                                <td class="">{{ $webhookResponseHistory->created_at  }}</td>
                                <td class="">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ __('Select') }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin_test_adyen_webhook_response_history_adyen_details', [
                                                'webhookResponseHistory' => $webhookResponseHistory]) }}">
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
                    {{ __('No data') }}
                </p>
            @endif
        </div>
    </div>
@endsection
