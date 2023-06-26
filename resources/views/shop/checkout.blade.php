@extends('layouts.checkout')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <p class="text-uppercase fs-2 fw-bold">{{ __('Order details') }}</p>
            </div>
            @if ($cart)
                <div class="row">
                    <p class="text-uppercase fs-5 fw-bold">
                        {{ __('Product(S)') }}
                    </p>
                    @foreach($cart->getCartItem as $cartItem)
                        <div class="border-top p-2">
                            <div class="float-lg-end">
                                {{ $cartItem->product->price }}
                            </div>
                            @isset($cartItem->product->image)
                                <p class="float-lg-start">
                                    <img class="center-block p-2" src="{{ url($cartItem->product->image) }}" width="50px">
                                </p>
                            @endisset
                            <div>
                                {{ $cartItem->product->name }}
                            </div>
                            <div>
                                {!! Str::limit($cartItem->product->description, 40, ' ...') !!}
                            </div>
                            <div
                                data-checkout-action="{{ route('checkout') }}"
                                data-action="{{ route('decreaseProductQty') }}"
                                data-product_id="{{ $cartItem->product->id  }}"
                                data-cart_id="{{ $cartItem->cart->id  }}"
                                class="decrease-product-qty">
                                -
                            </div>
                            {{ $cartItem->qty }}
                            <div
                                data-checkout-action="{{ route('checkout') }}"
                                data-action="{{ route('increaseProductQty') }}"
                                data-product_id="{{ $cartItem->product->id  }}"
                                data-cart_id="{{ $cartItem->cart->id  }}"
                                class="increase-product-qty">
                                +
                            </div>
                        </div>
                    @endforeach
                    <div>
                        {{ __('Subtotal') }}
                        <div class="float-lg-end">
                            {!! CartCount::subtotal() !!}
                        </div>
                    </div>

                </div>
            @endif
        </div>
    </div>
@endsection
@section('custom-scripts')
    <script>
        $(document).ready(function () {
            $(".decrease-product-qty").click(function (event) {
                var formData = {
                    product_id: $(this).data('product_id'),
                    cart_id: $(this).data('cart_id'),
                    _token: '{!! csrf_token() !!}'
                };
                $.ajax({
                    type: "POST",
                    url: $(this).data('action'),
                    data: formData,
                    dataType: "json",
                    encode: true,
                    context: this
                }).done(function (data) {
                    $.ajax({
                        type: "GET",
                        url: $(this).data('checkout-action'),
                        encode: true,
                        context: this
                    }).done(function (data) {
                        $('body').html(data);
                    });
                });
                event.preventDefault();
            });

            $(".increase-product-qty").click(function (event) {
                var formData = {
                    product_id: $(this).data('product_id'),
                    cart_id: $(this).data('cart_id'),
                    _token: '{!! csrf_token() !!}'
                };
                $.ajax({
                    type: "POST",
                    url: $(this).data('action'),
                    data: formData,
                    dataType: "json",
                    encode: true,
                    context: this
                }).done(function (data) {
                    $.ajax({
                        type: "GET",
                        url: $(this).data('checkout-action'),
                        encode: true,
                        context: this
                    }).done(function (data) {
                        $('body').html(data);
                    });
                });
                event.preventDefault();
            });
        });
    </script>
@endsection
