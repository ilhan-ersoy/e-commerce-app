@extends('layout')

@section('title', 'Checkout')

@section('extra-css')
    <script src="https://js.stripe.com/v3/"></script>

@endsection

@section('content')

    <div class="container">

        <h1 class="checkout-heading stylish-heading">Checkout</h1>
        <div class="checkout-section">
            <div>
                <form action="#">
                    <h2>Billing Details</h2>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="">
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="">
                    </div>

                    <div class="half-form">
                        <div class="form-group">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" value="">
                        </div>
                        <div class="form-group">
                            <label for="province">Province</label>
                            <input type="text" class="form-control" id="province" name="province" value="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="half-form">
                        <div class="form-group">
                            <label for="postalcode">Postal Code</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode" value="">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="">
                        </div>
                    </div> <!-- end half-form -->

                    <div class="spacer"></div>

                    <h2>Payment Details</h2>



                    <input type="submit" class="button-primary full-width" value="Complete Order">


                </form>
            </div>



            <div class="checkout-table-container">
                <h2>Your Order</h2>

                @foreach(Cart::instance('default')->content() as $item)

                        <div class="checkout-table-row">
                                <div class="checkout-table-row-left">
                                    <img src="{{asset('img/products/laptop-'.$item->model->id.'.png')}}" alt="item" class="checkout-table-img">
                                    <div class="checkout-item-details">
                                        <div class="checkout-table-item">{{$item->model->name}}</div>
                                        <div class="checkout-table-description">{{$item->model->details}}</div>
                                        <div class="checkout-table-price">{{$item->model->presentPrice()}}</div>
                                    </div>
                                </div> <!-- end checkout-table -->

                                <div class="checkout-table-row-right">
                                    <div class="checkout-table-quantity">1</div>
                                </div>
                        </div> <!-- end checkout-table-row -->

                 @endforeach


                <div class="checkout-totals">
                    <div class="checkout-totals-left">
                        Subtotal <br>
{{--                        Discount (10OFF - 10%) <br>--}}
                        Tax <br>
                        <span class="checkout-totals-total">Total</span>

                    </div>

                    <div class="checkout-totals-right">
                        {{presentPrice(Cart::subtotal())}} <br>
{{--                        -$750.00 <br>--}}
                        {{presentPrice(Cart::tax())}} <br>
                        <span class="checkout-totals-total">{{presentPrice(Cart::total())}}</span>

                    </div>
                </div> <!-- end checkout-totals -->

                <a href="#" class="have-code">Have a Code?</a>

                <div class="have-code-container">
                    <form action="#">
                        <input type="text">
                        <input type="submit" class="button" value="Apply">
                    </form>
                </div>
            </div>

        </div> <!-- end checkout-section -->
    </div>

@endsection
