<?php

namespace App\Http\Controllers;

use App\Models\Coupon;

use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $coupon = Coupon::findByCode($request->coupon_code);

        if (!$coupon){
            return redirect()->route('checkout.index')->with('success_message','Invalid Coupon code.Please try again !');
        }

        session()->put('coupon',[
            'name' => $coupon->code,
            'discount' => $coupon->discount(Cart::instance('default')->subtotal())
        ]);


        return redirect()->route('checkout.index')->with('success_message','Coupon has been applied !');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        session()->forget('coupon');

        return redirect()->route('checkout.index')->with('success_message','Coupon has been removed');
    }
}
