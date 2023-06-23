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
        return !empty(Cart::find(session('cart_id'))) ? Cart::find(session('cart_id'))->getCartItem->count() : 0;
    }
}
