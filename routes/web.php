<?php

use App\Http\Controllers\LandingPageController;
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


Route::get('/',[LandingPageController::class,'index'])->name('landing-page');


Route::view('/shop', 'shop');
Route::view('/product', 'product');
Route::view('/cart', 'cart');
Route::view('/checkout', 'checkout');
Route::view('/thankyou', 'thankyou');


