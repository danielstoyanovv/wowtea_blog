<?php

namespace App\Helpers;

use App\Models\Cart;
class CartCount
{
    /**
     * @return int
     */
    public static function products(): int
    {
        return !empty($cart = Cart::find(session('cart_id'))) ? $cart->getCartItem->count() : 0;
    }
}
