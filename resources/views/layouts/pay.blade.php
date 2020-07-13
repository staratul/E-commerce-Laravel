{{-- Include Header Link --}}
@include('layouts.inc.header_link')

{{-- Include Top Header --}}
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
                    <a href="{{ url('/') }}" style="margin-left: 150px">
                        <img src="{{ asset('img/logo.png') }}" alt="" style="margin-bottom: 5px;">
                    </a>
                </div>
            </div>
            <div class="ht-right">
                @guest
                    <a href="{{ route('login') }}" class="login-panel"><i class="fa fa-user"></i>Login</a>
                @else
                    <a href="#" id="profile-dropdown" class="login-panel"><i class="fa fa-user"></i>{{ Auth::user()->name }}</a>
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
</header>
<!-- Header End -->


{{-- Content --}}
@yield('content')

{{-- Include Footer Link --}}
@include('layouts.inc.footer_link')
