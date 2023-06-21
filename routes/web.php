<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Shop\PayPalController;
use Illuminate\Support\Facades\Route;

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
Route::group(['prefix' => 'admin'], function () {
    Route::resource('/users', UsersController::class);
    Route::resource('/products', \App\Http\Controllers\Admin\ProductsController::class);
});

Route::group(['prefix' => 'shop'], function () {
    // Checkout
    Route::group(['prefix' => 'checkout'], function () {
        Route::get('create-transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
        Route::post('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
        Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
        Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
    });
});
