<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use Database\Factories\CartFactory;
use Database\Factories\CartItemFactory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use function Symfony\Component\Translation\t;

class CartController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addProduct(Request $request): JsonResponse
    {
        try {
            if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest') {

                if (!empty($request->get('product_id')) && !empty($request->get('price')) && !empty($request->get('qty'))) {
                    if ($cart = $this->addToCart(
                        $request->get('product_id'),
                        $request->get('qty'),
                        $request->get('price'),
                        $request->getSession()->get('cart_id'))) {
                        session(['cart_id' => $cart->id]);
                    }
                    session()->flash('message', __('Product was added in cart'));


                    return response()->json([
                        'success' => true,
                        'products_action' => request()->headers->get('referer')
                    ]);
                }
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
        return response()->json([
            'success' => false
        ]);

    }

    /**
     * @param int $productId
     * @param int $qty
     * @param float $price
     * @param int|null $cartId
     * @return Cart|false|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|mixed
     */
    private function addToCart(int $productId, int $qty, float $price, int $cartId = null)
    {
        if ($product = Product::find($productId)) {
            $cart = $this->handleCartData($cartId);
            $this->handleCartItemData($cart, $product, $qty, $price);

            return $cart;
        }

        return false;
    }


    /**
     * @param int|null $cartId
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    private function handleCartData(int $cartId = null)
    {
        if (!empty($cartId)) {
            if ($cart = Cart::find($cartId)) {
                return $cart;
            }
        }

        return CartFactory::new()->create();
    }

    /**
     * @param Cart $cart
     * @param Product $product
     * @param int $qty
     * @param float $price
     * @return mixed
     */
    private function handleCartItemData(Cart $cart, Product $product, int $qty, float $price)
    {
        foreach ($cart->getCartItem as $item) {
            if ($product->id == $item->product->id) {
                $currentQty = $item->qty;
                $item->update([
                    'qty' => $currentQty + $qty
                ]);
                return $item;
            }
        }

        return CartItemFactory::new([
            'price' => $price,
            'product_id' => $product->id,
            'qty' => $qty,
            'cart_id' => $cart->id
        ])->create();
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function decreaseProductQty(Request $request): JsonResponse
    {
        try {
            if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest') {
                if (!empty($request->get('product_id')) && !empty($request->get('cart_id'))) {
                    $cartItem = CartItem::where([
                        'product_id' => $request->get('product_id'),
                        'cart_id' => $request->getSession()->get('cart_id')
                    ])->get()->first();
                    if ($cartItem->qty === 1) {
                        CartItem::destroy($cartItem->id);
                        return response()->json([
                            'removed' => true,
                        ]);
                    }
                    $cartItemCurrrentQty = (int) $cartItem->qty;
                    $cartItem->update([
                        'qty' => $cartItemCurrrentQty - 1
                    ]);
                    return response()->json([
                        'updated' => true,
                    ]);
                }
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
        return response()->json([
            'updated' => false
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function increaseProductQty(Request $request): JsonResponse
    {
        try {
            if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') == 'xmlhttprequest') {
                if (!empty($request->get('product_id')) && !empty($request->get('cart_id'))) {
                    $cartItem = CartItem::where([
                        'product_id' => $request->get('product_id'),
                        'cart_id' => $request->getSession()->get('cart_id')
                    ])->get()->first();
                    $cartItemCurrrentQty = (int) $cartItem->qty;
                    $cartItem->update([
                        'qty' => $cartItemCurrrentQty + 1
                    ]);
                    return response()->json([
                        'updated' => true,
                    ]);
                }
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
        return response()->json([
            'updated' => false
        ]);
    }
}
