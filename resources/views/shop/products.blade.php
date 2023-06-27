@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <h3>{{ __('Shop') }}</h3>
            </div>
            @if ($products)
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-sm-3">
                            @isset($product->image)
                                <p class="text-center">
                                    <img class="center-block" src="{{ url($product->image) }}" width="200px">
                                </p>
                            @endisset
                            <p class="fw-bold text-center fs-5">{{ $product->name }}</p>
                            <p class="text-center fs-4">{{ $product->price }}</p>
                            @include('forms.add-to-cart', ['price' => $product->price, 'product' => $product->id])
                        </div>
                    @endforeach
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
@section('custom-scripts')
    <script>
        $(document).ready(function () {
            $(".add-product-button").click(function (event) {
                var formData = {
                    price: $(this).parent().find('.price').val(),
                    product_id: $(this).parent().find('.product_id').val(),
                    _token: '{!! csrf_token() !!}',
                    qty: $(this).parent().find('.qty').val()
                };
                $.ajax({
                    type: "POST",
                    url: $(this).parent().attr('action'),
                    data: formData,
                    dataType: "json",
                    encode: true,
                    context: this
                }).done(function (data) {
                    if (data.products_action) {
                        $.ajax({
                            type: "GET",
                            url: data.products_action,
                            encode: true,
                            context: this
                        }).done(function (data) {
                            $('body').html(data);
                        });
                    }
                });
                event.preventDefault();
            });
        });
    </script>
@endsection
