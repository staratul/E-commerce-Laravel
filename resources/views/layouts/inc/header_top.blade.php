    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <div class="ht-left">
                    <div class="mail-service">
                        <i class=" fa fa-envelope"></i>
                        hello.colorlib@gmail.com
                    </div>
                    <div class="phone-service">
                        <i class=" fa fa-phone"></i>
                        +65 11.188.888
                    </div>
                </div>
                <div class="ht-right">
                    @guest
                        <a href="{{ route('login') }}" class="login-panel"><i class="fa fa-user"></i>Login</a>
                    @else
                        <a href="{{ route('home') }}" id="profile-dropdown" class="login-panel"><i class="fa fa-user"></i>{{ Auth::user()->name }}</a>
                        <div class="dropdown-content">
                            <a href="{{ route('logout') }}" class="login-panel"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    @endguest
                    <div class="lan-selector">
                        <select class="language_drop" name="countries" id="countries" style="width:300px;">
                            <option value='yt' data-image="{{ asset('img/flag-1.jpg') }}" data-imagecss="flag yt"
                                data-title="English">English</option>
                            <option value='yu' data-image="{{ asset('img/flag-2.jpg') }}" data-imagecss="flag yu"
                                data-title="Bangladesh">German </option>
                        </select>
                    </div>
                    <div class="top-social">
                        <a href="#"><i class="ti-facebook"></i></a>
                        <a href="#"><i class="ti-twitter-alt"></i></a>
                        <a href="#"><i class="ti-linkedin"></i></a>
                        <a href="#"><i class="ti-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('img/logo.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7" style="padding-left: 100px;">
                        <form id="product_search_form" method="GET" action="">
                            @csrf
                            <div class="advanced-search">
                                {{-- <button type="button" class="category-btn">All Categories</button> --}}
                                <div class="input-group">
                                    <input type="text" id="search" name="search" placeholder="What do you need?" autocomplete="off" class="text-dark">
                                    <button type="button"><i class="ti-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3 text-right col-md-3">
                        <ul class="nav-right">
                            <li class="heart-icon">
                                <a href="{{ route('wishlist') }}">
                                    <i class="icon_heart_alt"></i>
                                    <span id="icon_heart_alt">
                                        @if (Cookie::get('wishlist') !== null)
                                            {{ count(json_decode(Cookie::get('wishlist'), true)) }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="cart-icon">
                                <a href="{{ url('shopping-cart') }}">
                                    <i class="icon_bag_alt"></i>
                                    <span id="icon_bag_total">
                                        @if (Session::has('shoppingcart'))
                                            {{ count(Session::get('shoppingcart')->items) }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </a>
                            </li>
                            <li class="cart-price">
                                @if (Session::has('shoppingcart'))
                                    ₹{{ Session::get('shoppingcart')->totalPrice }}.00
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>All departments</span>
                        <ul class="depart-hover">
                            @foreach ($categories as $key => $category)
                                <li @if($key===0) class="active" @endif>
                                    <a href="{{ url('/'.$category->category_url) }}">{{ $category->category }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        @foreach ($menus as $key => $menu)
                            <li @if($key===0) class="active" @endif>
                                <a href="{{ url($menu->menu_url) }}">{{ $menu->menu }}</a>
                                @if($menu->sub_menus !== null && isset($menu->sub_menus))
                                    <ul class="dropdown">
                                        @foreach(explode(",", $menu->sub_menus) as $k => $sub)
                                            <li>
                                                <a href="{{ url(explode(",", $menu->sub_menu_urls)[$k]) }}">{{ $sub }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>
    <!-- Header End -->

@push('js')
    <script type="text/javascript">
        let path = "{{ route('search.suggestion') }}";

        $('#search').typeahead({
            minLength: 2,
            source:  function (query, process) {
            return $.get(path, { query: query }, function (data) {
                var dataset = [];
                    data.forEach(function(value){
                        let val = value.tags.split(',');
                        val.forEach((val) => {
                            var el = dataset.find(a =>a.includes(val));
                            if(!el) {
                                dataset.push(val);
                            }
                        })
                    });
                    return process(dataset);
                });
            }
        });

        $("#search").on("change", () => {
            $("#loader").css("display", "block")
            let search = $("#search").val();
            let url = "{{ route('search.result', 'type') }}";
            url = url.replace("type", search);;
            $("#product_search_form").attr("action", url);
            $("#product_search_form").submit();
        });
    </script>
@endpush

@push('css')
    <style>
        #loader {
            display: none; position: fixed; left: 0px; top: 0px; width: 100%; height: 100%;
            z-index: 9999;
            background: url('/img/loader3.gif') 50% 50% no-repeat rgb(10,10,10);
            opacity: .8;
        }
    </style>
@endpush
