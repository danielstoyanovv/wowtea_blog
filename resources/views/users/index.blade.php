@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <h3>{{ __('Users') }}</h3>
        @if ($users)
            <div class="table-responsive">
                <table class="table table-borderless table-striped">
                    <tr>
                        <th class="table-light">{{ __('id') }}</th>
                        <th class="table-light">{{ __('Name') }}</th>
                        <th class="table-light">{{ __('E-mail') }}</th>
                        <th class="table-light">{{ __('Created at') }}</th>
                        <th class="table-light">{{ __('Action') }}</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td class="">{{ $user->id }}</td>
                            <td class="">{{ $user->name }}</td>
                            <td class="">{{ $user->email }}</td>
                            <td class="">{{ $user->created_at  }}</td>
                            <td class="">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ __('Select') }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">{{ __('Edit') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="d-felx justify-content-center pagination">
                {{ $users->links() }}
            </div>
        @else
            <p>
                {{ __('No users') }}
            </p>
        @endif
    </div>
</div>
@endsection
