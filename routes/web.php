<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Shop\PayPalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Shop\PaymentController;
use App\Http\Controllers\Shop\AdyenController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('/users', UsersController::class);
        Route::resource('/products', \App\Http\Controllers\Admin\ProductsController::class);
    });
});

Route::group(['prefix' => 'shop'], function () {
    Route::get('/products', [\App\Http\Controllers\Shop\ProductsController::class, 'index'])->name('shop-products');
    Route::get('/checkout', [\App\Http\Controllers\Shop\CheckoutController::class, 'index'])->name('checkout');
    Route::group(['prefix' => 'cart'], function () {
        Route::post('/add-product', [\App\Http\Controllers\Shop\CartController::class, 'addProduct'])->name('addProduct');
        Route::post('/decrease-product-qty', [\App\Http\Controllers\Shop\CartController::class, 'decreaseProductQty'])->name('decreaseProductQty');
        Route::post('/increase-product-qty', [\App\Http\Controllers\Shop\CartController::class, 'increaseProductQty'])->name('increaseProductQty');
    });
    // Checkout
    Route::group(['prefix' => 'checkout'], function () {
        Route::post('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
        Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
        Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
    });
});

Route::get('/pay', [PaymentController::class, 'pay']);
Route::get('/pay2', [PaymentController::class, 'pay2']);
Route::get('/components-checkout', [PaymentController::class, 'componentsCheckout']);
Route::get('/pay-success', [PaymentController::class, 'paySuccess'])->name('pay.success');
Route::get('/test-checkout', [PaymentController::class, 'testCheckout']);

Route::get('/show-checkout', [AdyenController::class, 'showCheckout'])->name('checkout');
Route::post('/make-payment', [AdyenController::class, 'makePayment'])->name('make-payment');
