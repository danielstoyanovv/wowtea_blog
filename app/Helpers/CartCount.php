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

    /**
     * @return float
     */
    public static function subtotal(): float
    {
        $total = 0;
        $cart = Cart::find(session('cart_id'));
        foreach ($cart->getCartItem as $item) {
            $total += $item->price * $item->qty;
        }
        return $total;
    }
}
