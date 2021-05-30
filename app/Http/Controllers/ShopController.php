<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index()
    {

        if (request()->category) {
            //
        }

        $products = Product::inRandomOrder()->take(9)->get();
        $categories = Category::all();

        return view('shop')->with([
            'products'=>$products,
            'categories'=>$categories
        ]);
    }




    public function show($slug)
    {
        $product = Product::where('slug',$slug)->firstOrFail();
        $mightAlsoLike = Product::where('slug','!=',$slug)->mightAlsoLike()->get();

        return view('product')->with([
            'product' => $product,
            'mightAlsoLike'=>$mightAlsoLike
        ]);
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
