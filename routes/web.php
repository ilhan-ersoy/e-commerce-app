<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\SafeForLaterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;


Route::get('/',[LandingPageController::class,'index'])->name('landing-page');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{product}',[ShopController::class,'show'])->name('shop.show');


Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart',[CartController::class,'store'])->name('cart.store');
Route::delete('/cart/{product}/delete',[CartController::class,'destroy'])->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}',[CartController::class,'switchToSaveForLater'])->name('cart.switchToSaveForLater');

Route::delete('/saveForLater/{product}/delete',[SafeForLaterController::class,'destroy'])->name('safeForLater.destroy');
Route::post('/saveForLater/switchToCart/{product}',[SafeForLaterController::class,'switchToCart'])->name('safeForLater.switchToCart');

Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout.index');




Route::get('/empty',function (){
   Cart::instance('saveForLater')->destroy();
});


Route::view('/product', 'product');

Route::view('/thankyou', 'thankyou');


