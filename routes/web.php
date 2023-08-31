<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Shop\PayPalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PaymentLogsController;
use App\Http\Controllers\Admin\Checkout\TestPaypalController;
use App\Http\Controllers\Admin\Checkout\TestAdyenController;
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

Route::post('/adyen/webhook', [AdyenController::class, 'webhook'])->name('webhook');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('auth')->group(function () {
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('/users', UsersController::class);
        Route::resource('/products', \App\Http\Controllers\Admin\ProductsController::class);
        Route::group(['prefix' => 'payment-logs'], function () {
            Route::get('/payments-history', [PaymentLogsController::class, 'paymentsHistory'])
                ->name('paymentsHistory');
            Route::get('/payments-apis-response-history', [PaymentLogsController::class, 'paymentsApisResponseHistory'])
                ->name('paymentsApisResponseHistory');
            Route::get('{paymentApisResponseHistory}/payment-apis-response-history-details', [
                PaymentLogsController::class, 'paymentApisResponseHistoryDetails'
            ])->name('paymentApisResponseHistoryDetails');
        });
        Route::group(['prefix' => 'checkout'], function () {
            Route::group(['prefix' => 'test-paypal'], function () {
                Route::get('/', [TestPaypalController::class, 'index'])
                    ->name('admin_test_paypal_page');
                Route::post('/payment', [TestPaypalController::class, 'payment'])
                    ->name('admin_test_paypal');
                Route::get('/success-transaction', [TestPaypalController::class, 'successTransaction'])
                    ->name('admin_test_paypal_success');
                Route::get('/cancel-transaction', [TestPaypalController::class, 'cancelTransaction'])
                    ->name('admin_test_paypal_cancel');
            });
            Route::group(['prefix' => 'test-adyen'], function () {
                Route::get('/', [TestAdyenController::class, 'index'])
                    ->name('admin_test_adyen_page');
                Route::post('/process', [TestAdyenController::class, 'process'])
                    ->name('admin_test_adyen_process');
                Route::post('/subscription', [TestAdyenController::class, 'subscription'])
                    ->name('admin_test_adyen_subscription');
            });
        });
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
