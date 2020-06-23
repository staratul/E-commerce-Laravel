<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Admin\HomeSlider;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $homeSliders = HomeSlider::with('image')->with('category')->latest()->get();
        return view('welcome', compact('homeSliders'));
    }

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
