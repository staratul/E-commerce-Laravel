<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function blogDetails()
    {
        return view('frontend.pages.blog-details');
    }

    public function blog()
    {
        return view('frontend.pages.blog');
    }

    public function checkOut()
    {
        return view('frontend.pages.check-out');
    }

    public function faq()
    {
        return view('frontend.pages.faq');
    }

    public function product()
    {
        return view('frontend.pages.product');
    }

    public function shop()
    {
        return view('frontend.pages.shop');
    }

    public function shoppingCart()
    {
        return view('frontend.pages.shopping-cart');
    }
}
