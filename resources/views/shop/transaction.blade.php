@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <form method="POST" action="{{ route('processTransaction') }}">
            @csrf
            <div class="mb-3 mt-3">
                <input type="submit" class="btn btn-primary form-control" value="{{ 'Pay' }}">
            </div>
        </form>
    </div>
</div>
@endsection
