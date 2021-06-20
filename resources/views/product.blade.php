@extends('layout')

@section('title', $product->name)

@section('extra-css')

@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <a href="{{route('shop.index')}}">Shop</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Macbook Pro</span>
        </div>
    </div> <!-- end breadcrumbs -->


    <div class="product-section container">

        <div>
            <div class="product-section-image">
                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" id="bigImage">
            </div>

            <div class="product-section-images">
                <div class="product-section-thumbnail selected">
                    <img src="{{ asset('storage/'.$product->image) }}">
                </div>


                @if ($product->images)
                    @foreach (json_decode($product->images) as $image)
                        <div class="product-section-thumbnail">
                            <img src="{{ asset('storage/'.$image) }}" alt="image">
                        </div>
                    @endforeach
                @endif


            </div>
        </div>

        <div class="product-section-information">
            <h1 class="product-section-title">{!! $product->name !!}</h1>
            <div class="product-section-subtitle">{!! $product->details !!}</div>
            <div class="product-section-price">{!! $product->presentPrice() !!}</div>

            <p>
                {!! $product->description !!}
            </p>


{{--            <a href="#" class="button">Add to Cart</a>--}}

            <form action="{{route('cart.store')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}">
                <input type="hidden" name="name" value="{{$product->name}}">
                <input type="hidden" name="price" value="{{$product->price}}">
                <button type="submit" class="button button-plain" style="cursor: pointer">Add to Cart</button>
            </form>
        </div>
    </div> <!-- end product-section -->

    @include('partials.might-like')


@endsection
@section('extra-js')
    <script src="{{asset('js/app.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>
        (function(){

            const images = $('.product-section-thumbnail');
            let currentImage = $('#bigImage');
            currentImage.addClass("active");
            images.click(function () {

                let newImagePath = $(this).children("img").attr("src");

                currentImage.removeClass("active");

                currentImage.on('transitionend',function () {
                   currentImage.attr("src",newImagePath);
                   currentImage.addClass("active");
                });

                images.removeClass("selected");

                $(this).addClass("selected");

            });



        })();
    </script>

@endsection
