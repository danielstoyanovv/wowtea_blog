@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-8">
            <h3>{{ __('Products') }}</h3>
        </div>
        <div class="col-4">
            <a href="{{ route('products.create')  }}" class="btn btn-info float-end">{{ __('Add product') }}</a>
        </div>
        @if ($products)
            <div class="table-responsive">
                <table class="table table-borderless table-striped">
                    <tr>
                        <th class="table-light">{{ __('id') }}</th>
                        <th class="table-light">{{ __('Name') }}</th>
                        <th class="table-light">{{ __('Price') }}</th>
                        <th class="table-light">{{ __('Created at') }}</th>
                        <th class="table-light">{{ __('Action') }}</th>
                    </tr>
                    @foreach($products as $product)
                        <tr>
                            <td class="">{{ $product->id }}</td>
                            <td class="">{{ $product->name }}</td>
                            <td class="">{{ $product->price }}</td>
                            <td class="">{{ $product->created_at  }}</td>
                            <td class="">
                                @if(!empty(Auth::user()) && (Auth::user()->id === 1))
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ __('Select') }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                                    {{ __('Edit') }}
                                                </a>
                                                  <form method="POST" action="{{ route('products.destroy', $product->id) }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                       <input type="submit"  class="dropdown-item" value="{{ __('Remove') }}">
                                                    </form>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="d-felx justify-content-center pagination">
                {{ $products->links() }}
            </div>
        @else
            <p>
                {{ __('No products') }}
            </p>
        @endif
    </div>
</div>
@endsection
