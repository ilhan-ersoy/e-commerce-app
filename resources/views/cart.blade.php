@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')

@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="#">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shopping Cart</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="cart-section container">
        <div>
            @if (session()->has('success_message'))
                <div class="alert alert-success">
                    {{ session()->get('success_message') }}
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (Cart::count() > 0)
                <h2>{{Cart::count()}} item(s) in Shopping Cart</h2>
            @else
                    <a href="#">No items in cart :(</a> <br><br>

                    <a href="{{route('shop.index')}}" class="button">Continue Shopping</a>

                @endif

            <div class="cart-table">
{{--            {{dd(Cart::instance('default')->content())}}--}}

                @foreach(Cart::content() as $item)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{route('shop.show',$item->model->slug)}}"><img src="{{asset('img/products/'.$item->model->slug.'.jpg')}}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">

                            <div class="cart-table-item"><a href="{{route('shop.show',$item->model->slug)}}">{{$item->model->name}}</a></div>

                            <div class="cart-table-description">{{$item->model->details}}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            <form action="{{ route('cart.destroy',$item->rowId) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: white;border: white;cursor:pointer;font-size: 15px;">Remove</button>
                            </form>

                            <br>
                            <form action="{{route('cart.switchToSaveForLater',$item->rowId)}}" method="POST">
                                @csrf
                                <button type="submit" style="background: white;border: white;cursor:pointer;font-size: 15px;">Save For Later </button>
                            </form>
                        </div>
                        <div>
                            <select class="quantity" item-id="{{$item->rowId}}" >
                                @for ($i = 1; $i < 5 + 1; $i++)
                                    <option @if ($item->qty == $i) selected @endif > {{ $i }} </option>
                                @endfor
                            </select>
                        </div>
                        <div>{{ presentPrice($item->subTotal()) }}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach


            </div> <!-- end cart-table -->

            <div class="cart-totals">
                <div class="cart-totals-left">
                    Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :).
                </div>

                <div class="cart-totals-right">
                    <div>
                        Fiyat <br>
                        Vergi(%110) <br>
                        <span class="cart-totals-total">Toplam</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        {{presentPrice(Cart::subtotal())}} <br>
                        {{presentPrice(Cart::tax() )}} <br>
                        <span class="cart-totals-total">{{presentPrice(Cart::total() )}}</span>
                    </div>
                </div>
            </div> <!-- end cart-totals -->

            <div class="cart-buttons">
                @if (Cart::count() > 0)
                    <a href="{{route('shop.index')}}" class="button">Continue Shopping</a>

                    <a href="{{route('checkout.index')}}" class="button-primary">Proceed to Checkout</a>
                @endif
            </div>

            <h2>{{Cart::instance('saveForLater')->count()}} items Saved For Later</h2>

                @foreach(Cart::instance('saveForLater')->content() as $item)
                    <div class="cart-table-row">
                        <div class="cart-table-row-left">
                            <a href="{{route('shop.show',$item->model->slug)}}"><img src="{{asset('img/products/'.$item->model->slug.'.jpg')}}" alt="item" class="cart-table-img"></a>
                            <div class="cart-item-details">
                                <div class="cart-table-item"><a href="#">{{$item->model->name}}</a></div>
                                <div class="cart-table-description">{{$item->model->details}}</div>
                            </div>
                        </div>
                        <div class="cart-table-row-right">
                            <div class="cart-table-actions">
                                <form action="{{route('safeForLater.destroy',$item->rowId)}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background: white;border: white;cursor:pointer;font-size: 15px;">Remove</button>
                                </form>
                                <form action="{{route('safeForLater.switchToCart',$item->rowId)}}" method="POST">
                                    @csrf
                                    <button type="submit" style="background: white;border: white;cursor:pointer;font-size: 15px;">To Cart</button>
                                </form>

                            </div>
                             <div>
                                <select class="quantity">
                                    <option selected="">1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                </select>
                            </div>
                            <div>$2499.99</div>
                        </div>
                    </div> <!-- end cart-table-row -->
                @endforeach



        </div>

    </div> <!-- end cart-section -->
    @include('partials.might-like')
@endsection

@section('extra-js')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        (function(){

            let item = $('.quantity');

            item.change(function (){
                const id = $(this).attr('item-id');

                const itemQuantity = $(this).val();

                axios.patch('/cart/'+id,{
                    rowId : id,
                    quantity : itemQuantity
                }).then(function (response) {
                    // console.log(response);
                    window.location.href = '{{route('cart.index')}}'
                }).then(function (error) {
                    // console.log(error);
                    window.location.href = '{{route('cart.index')}}'
                });

            });

        })();
    </script>

@endsection
