<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    public function index()
    {
        $mightAlsoLike = Product::MightAlsoLike()->get();

        return view('cart')->with([
            'mightAlsoLike'=>$mightAlsoLike
        ]);
    }


    public function store(Request $request)
    {

        $duplicates = Cart::search(function ($cardItem) use($request){
            return $cardItem->id === $request->id;
        });

        if ($duplicates->isNotEmpty()){
            return redirect()->route('cart.index')->with('success_message','Item is already in your cart !');
        }

        Cart::add($request->id, $request->name, 1, $request->price)
            ->associate('App\Models\Product');


        return redirect()->route('cart.index')
            ->with('success_message','Item was added to your cart !');
    }

    public function destroy($id)
    {
        Cart::remove($id);

        return back()->with('success_message','Item has been removed !');
    }

    public function switchToSaveForLater($id)
    {
        $item = Cart::instance('default')->get($id);

        $duplicates = Cart::instance('saveForLater')->search(function ($cardItem) use ($item) {
            return $cardItem->id === $item->id;
        });

        if ($duplicates) {
            return back()->with('success_message','Item has already Saved For Later !');
        }

        Cart::instance('default')->remove($id);

        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
            ->associate('App\Models\Product');

        return back()->with('success_message', 'Item has been saved !');
    }
}
