@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if ($errors->any())
            <ul class="list-group">
                @foreach ($errors->all() as $error)
                    <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <div class="col-8">
            <h3>{{ __('Update product') }}</h3>
        </div>
        <div class="col-4">
           <a href="{{ route('products.index')  }}" class="btn btn-info float-end">{{ __('Back') }}</a>
        </div>
        <form method="POST" action="{{ route('products.update', $product->id) }}" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="mb-3 mt-3">
                <input class="form-control" type="text" name="name" placeholder="{{ __('Name') }}" value="{{ $product->name }}" required>
            </div>
            <div class="mb-3 mt-3">
                <textarea class="form-control" placeholder="{{ __('Description') }}" name="description">{{ $product->description }}</textarea>
            </div>
            <div class="mb-3 mt-3">
                <input type="text" class="form-control" name="price" placeholder="{{ __('Price') }}" value="{{ $product->price }}" required>
            </div>
            <div class="mb-3 mt-3">
                <input type="file" name="image">
            </div>
            @isset($product->image)
                <img src="{{ url($product->image) }}" width="150px">
            @endisset
            <div class="mb-3 mt-3">
                <input type="submit" class="btn btn-primary form-control" value="{{ 'Add product' }}">
            </div>
        </form>
    </div>
</div>
@endsection
