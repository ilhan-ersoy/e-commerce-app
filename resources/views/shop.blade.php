@extends('layout')

@section('title', 'Products')

@section('extra-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shop</span>
        </div>
    </div> <!-- end breadcrumbs -->

    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>

                @foreach ($categories as $category)
                    <li class="{{ setActiveCategory($category->slug) }}">
                        <a href="{{ route('shop.index',['category'=>$category->slug]) }}">{{ $category->name }} </a>
                    </li>
                @endforeach
            </ul>

{{--            <h3>By Price</h3>--}}
{{--            <ul>--}}
{{--                <li><a href="#">$0 - $700</a></li>--}}
{{--                <li><a href="#">$700 - $2500</a></li>--}}
{{--                <li><a href="#">$2500+</a></li>--}}
{{--            </ul>--}}
        </div> <!-- end sidebar -->
        <div>

            <div class="products-header">
                <h1 class="stylish-heading">{{ $categoryName }}</h1>
                <div>
                    <strong>Price:</strong>
                    <a href="{{ route('shop.index',['category'=>request()->category,'sort'=>'low_high']) }}">Low to High <i class="fas fa-dollar-sign"></i> <i class="fas fa-arrow-up"></i></a>
                    <a href="{{ route('shop.index',['category'=>request()->category,'sort'=>'high_low']) }}">High to Low <i class="fas fa-dollar-sign"></i> <i class="fas fa-arrow-down"></i> </a>
                </div>
            </div>
            <div class="products text-center">
                @forelse($products as $product)
                    <div class="product">
                        <a href="{{route('shop.show',$product->slug)}}"><img src="{{ asset('storage/'.$product->image) }}" alt="product"></a>
                        <a href="{{route('shop.show',$product->slug)}}"><div class="product-name">{{$product->name}}</div></a>
                        <div class="product-price">{{$product->presentPrice()}}</div>
                    </div>
                @empty
                    <div style="text-align: left">No items found !</div>
                @endforelse


            </div> <!-- end products -->
{{--            {{ $products->links() }}--}}
{{--            {{ $products->appends(request()->input())->links() }}--}}
            {{ $products->withQueryString()->links() }}
        </div>
    </div>


@endsection
