<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SafeForLaterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;


// Routes
Route::get('/',[LandingPageController::class,'index'])->name('landing-page');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{product}',[ShopController::class,'show'])->name('shop.show');


// Shopping Cart
Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart',[CartController::class,'store'])->name('cart.store');
Route::patch('/cart/{id}',[CartController::class,'update'])->name('cart.update');
Route::delete('/cart/{product}/delete',[CartController::class,'destroy'])->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}',[CartController::class,'switchToSaveForLater'])->name('cart.switchToSaveForLater');


// Safeforlater
Route::delete('/saveForLater/{product}/delete',[SafeForLaterController::class,'destroy'])->name('safeForLater.destroy');
Route::post('/saveForLater/switchToCart/{product}',[SafeForLaterController::class,'switchToCart'])->name('safeForLater.switchToCart');


// Checkout
Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout.index')->middleware('auth');
Route::post('/checkout',[CheckoutController::class,'store'])->name('checkout.store');

//Confirmation
Route::get('/thankyou',[ConfirmationController::class,'index'])->name('confirmation.index');

Route::post('/coupon',[CouponsController::class,'store'])->name('coupon.store');
Route::delete('/coupon/delete',[CouponsController::class,'destroy'])->name('coupon.destroy');

Route::get('/empty',function (){
   Cart::instance('saveForLater')->destroy();
});


Route::view('/product', 'product');





Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
