<?php

namespace App\Http\Controllers;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class SafeForLaterController extends Controller
{

    public function destroy($id)
    {
        Cart::instance('saveForLater')->remove($id);

        return back()->with('success_message','Item has been removed !');
    }

    public function switchToCart($id){

        $item = Cart::instance('saveForLater')->get($id);

        $duplicates = Cart::instance('default')->search(function ($cartItem) use($item){
            return $cartItem->id === $item->id;
        });

        if ($duplicates->isNotEmpty()){
            return back()->with('success_message','Item was already in your cart !');
        }

        Cart::instance('saveForLater')->remove($id); // yout must use remove for delete one item which is in your cart !


        Cart::instance('default')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Models\Product');


        return back()->with('success_message','Item was already in your cart !');

    }
}
