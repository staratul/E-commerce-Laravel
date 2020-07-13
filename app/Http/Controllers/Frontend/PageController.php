<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Helper;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\HomeSlider;
use App\Models\Admin\SubCategory;
use App\Http\Controllers\Controller;
use App\Models\Admin\Products\Product;
use App\Models\Admin\Products\ProductColor;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function index()
    {
        $products = Product::latest()
                            ->with('category')
                            ->with('product_image')
                            ->with('sub_category')
                            ->get();
        $homeSliders = HomeSlider::with('image')->with('category')->latest()->get();
        return view('welcome', compact('homeSliders', 'products'));
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

    public function faq()
    {
        return view('frontend.pages.faq');
    }

    public function productDetails(Product $product, $sulg)
    {
        $colors = Helper::explode($product->colors);
        $product->product_color_stocks = $product->product_color_stocks;
        $product->product_size_stocks = $product->product_size_stocks;
        $product->product_image = $product->product_image;
        $product->product_preview_images = $product->product_preview_images;
        $colors = ProductColor::whereIn('id', $colors)->get();
        $product->productColors = $colors;
        // dd($product);
        $relatedProducts = Product::where('category_id', $product->category_id)
                                ->where('id', '!=', $product->id)
                                ->with('sub_category')->with('product_image')->get();
        // dd($relatedProducts);
        return view('frontend.pages.product_details', compact('product', 'relatedProducts'));
    }

    public function productList($category,$category_id,$subCategory,$subCategory_id)
    {
        $products = Product::where('category_id', $category_id)
                                    ->where('sub_category_id', $subCategory_id)
                                    ->with('sub_category')
                                    ->with('product_image')
                                    ->latest()
                                    ->get();
        // dd($products);
        return view('frontend.pages.product_list', compact('products'));
    }

    public function shop()
    {
        $products = Product::latest()
                            ->with('category')
                            ->with('product_image')
                            ->with('sub_category')
                            ->get();
        return view('frontend.pages.shop', compact('products'));
    }

    public function shoppingCart()
    {
        return view('frontend.pages.shopping-cart');
    }

    public function sessionForgot(Request $request)
    {
        $request->session()->forget('shoppingcart');
        session()->save();
        $oldCart = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;
        dd("done", $oldCart);
    }
}
