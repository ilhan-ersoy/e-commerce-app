<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;


Route::get('/',[LandingPageController::class,'index'])->name('landing-page');
Route::get('/shop',[ShopController::class,'index'])->name('shop.index');
Route::get('/shop/{product}',[ShopController::class,'show'])->name('shop.show');


Route::get('/cart',[CartController::class,'index'])->name('cart.index');
Route::post('/cart',[CartController::class,'store'])->name('cart.store');
Route::delete('/cart/{product}/delete',[CartController::class,'destroy'])->name('cart.destroy');
Route::post('/cart/switchToSaveForLater/{product}',[CartController::class,'switchToSaveForLater'])->name('cart.switchToSaveForLater');

Route::get('/empty',function (){
   Cart::instance('saveForLater')->destroy();
});


Route::view('/product', 'product');

Route::view('/checkout', 'checkout');
Route::view('/thankyou', 'thankyou');


