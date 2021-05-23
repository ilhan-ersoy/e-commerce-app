<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

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

        Cart::add($request->id,$request->input('name'),1,$request->input('price'))
            ->associate(Product::class);

        return redirect()->route('cart.index')->with('success_message','Item was added to your cart !');
    }


}
