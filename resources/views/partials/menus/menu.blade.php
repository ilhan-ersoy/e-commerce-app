<ul>
    <li><a href="{{route('shop.index')}}">Shop</a></li>
    <li><a href="#">About</a></li>
    <li><a href="#">Blog</a></li>
    <li>
        <a href="{{route('cart.index')}}">Cart
            @if (Cart::count() > 0)
                <span style="background-color:forestgreen;border-radius: 40%;padding: 4px;">
                                {{Cart::instance('default')->count()}}
                            </span>
            @endif
        </a>
    </li>
</ul>
