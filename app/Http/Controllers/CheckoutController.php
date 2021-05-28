<?php

namespace App\Http\Controllers;


use App\Http\Requests\CheckoutRequest;
use Cartalyst\Stripe\Exception\CardErrorException;
use Cartalyst\Stripe\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Mockery\Exception;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('checkout');
    }

    public function store(CheckoutRequest $request)
    {
        $stripe = new Stripe('sk_test_51IvnE6EqXQIluMZ7Yg30iI6R4WNrvJwN1se32qfAuuW8gWHn0DmiReMa6ekNMQPSImzD4IGmCJaG9bh5GTD47kYy00ari4NlUd');

        $contents = Cart::content()->map(function ($item){
            return $item->model->slug.','.$item->qty;
        })->values()->toJson();

        try {
            $charge = $stripe->charges()->create([
                'amount' => Cart::instance('default')->total() / 10,
                'currency'=>'CAD',
                'source' => $request->stripeToken,
                'description'=>'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    // Changes the orde id after we start using DB
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count()
                ]
            ]);

            Cart::instance('default')->destroy();

            return redirect()->route('confirmation.index')->with('success_message','Thank you! Your payment has been successfully accepted !');
        }
        catch (CardErrorException $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
