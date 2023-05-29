@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if (count($errors) > 0)
            <ul class="list-group">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <h3>{{ __('Edit') }}</h3>
        <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="mb-3 mt-3">
                <input class="form-control" type="text" name="name" placeholder="{{ 'Name' }}" value="{{ $user->name }}" required>
            </div>
            <div class="mb-3 mt-3">
                <input type="text" class="form-control" name="email" value="{{ $user->email }}" required>
            </div>
            <div class="mb-3 mt-3">
                <input type="file" name="image">
            </div>
            @isset($user->image)
               <img src="{{ url($user->image) }}" width="150px">
            @endisset
            <div class="mb-3 mt-3">
                <input type="submit" class="btn btn-primary form-control" value="{{ 'Update' }}">
            </div>
        </form>
    </div>
</div>
@endsection
