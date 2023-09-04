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
                            <th class="table-light">{{ __('Response') }}</th>
                            <th class="table-light">{{ __('Event code') }}</th>
                            <th class="table-light">{{ __('Provider') }}</th>
                            <th class="table-light">{{ __('Created at') }}</th>
                        </tr>
                        @foreach($data as $webhookResponseHistory)
                            <tr>
                                <td class="">{{ $webhookResponseHistory->id }}</td>
                                <td class="">{{$webhookResponseHistory->response }}</td>
                                <td class="">{{ $webhookResponseHistory->eventCode }}</td>
                                <td class="">{{ $webhookResponseHistory->provider }}</td>
                                <td class="">{{ $webhookResponseHistory->created_at  }}</td>
                                <td class="">

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
