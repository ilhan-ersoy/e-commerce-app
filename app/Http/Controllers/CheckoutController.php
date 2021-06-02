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

        return view('checkout')->with([
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'newTax' => $this->getNumbers()->get('newTax'),
            'newTotal' => $this->getNumbers()->get('newTotal')
        ]);
    }

    public function store(CheckoutRequest $request)
    {
        $stripe = new Stripe('sk_test_51IvnE6EqXQIluMZ7Yg30iI6R4WNrvJwN1se32qfAuuW8gWHn0DmiReMa6ekNMQPSImzD4IGmCJaG9bh5GTD47kYy00ari4NlUd');

        $contents = Cart::content()->map(function ($item){
            return 'Product : '.$item->model->slug.', Product Quantity : '.$item->qty;
        })->values()->toJson();

        try {
            $charge = $stripe->charges()->create([
                'amount' => $this->getNumbers()->get('newTotal') / 10,
                'currency'=>'USD',
                'source' => $request->stripeToken,
                'description'=>'Order',
                'receipt_email' => $request->email,
                'metadata' => [
                    // Changes the orde id after we start using DB
                    'contents' => $contents,
                    'quantity' => Cart::instance('default')->count(),
                    'discount' => collect(session()->get('coupon'))->toJson()
                ]
            ]);

            Cart::instance('default')->destroy();
            session()->forget('coupon');
            return redirect()->route('confirmation.index')->with('success_message','Thank you! Your payment has been successfully accepted !');
        }
        catch (CardErrorException $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    private function getNumbers()
    {
        $tax = config('cart.tax') / 100; // 13 / 100
        $discount = session()->get('coupon')['discount'] ?? 0;
        $newSubtotal = (Cart::subtotal() - $discount);
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax);

        return collect([
            'tax'=>$tax,
            'discount'=>$discount,
            'newSubtotal'=>$newSubtotal,
            'newTax'=>$newTax,
            'newTotal'=>$newTotal
        ]);

    }


}
