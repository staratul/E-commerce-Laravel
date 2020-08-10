<?php

namespace App\Http\Controllers\Frontend;

use App\Events\NewContactMessageEvent;
use App\Http\Helper;
use App\Models\Admin\Footer;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Models\Admin\DealOfWeek;
use App\Models\Admin\HomeSlider;
use App\Models\Admin\PartnerLogo;
use App\Models\Admin\SubCategory;
use App\Http\Controllers\Controller;
use App\Models\Admin\Products\Product;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Products\ProductColor;
use App\Models\Frontend\Contact;

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
        $value = Cookie::get('wishlist');
        $wishlists = json_decode($value, true);
        $weekdeal = DealOfWeek::with('image')->where('active', 1)->first();
        return view('welcome', compact('homeSliders', 'products', 'wishlists', 'weekdeal'));
    }

    public function contact(Request $request)
    {
        if($request->isMethod('get')) {
            return view('frontend.pages.contact');
        } else if($request->isMethod('post')) {
            $rules = [
                'name' => 'required',
                'email' => 'email|required',
                'message' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);

            if($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'message' => $request->message
            ]);

            event(new NewContactMessageEvent($contact));

            Session::flash('success', 'Your Message Send Successfully.');
            return redirect()->route('contact');
        }
    }

    public function aboutUs()
    {
        return view('frontend.pages.about');
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
        $value = Cookie::get('wishlist');
        $wishlists = json_decode($value, true);
        return view('frontend.pages.product_details', compact('product','relatedProducts','wishlists'));
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
        $value = Cookie::get('wishlist');
        $wishlists = json_decode($value, true);
        return view('frontend.pages.shop', compact('products', 'wishlists'));
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

    public function searchSuggestion(Request $request)
    {
        $result = Product::select('tags')->where('tags', 'LIKE', "%{$request->input('query')}%")
                    // ->orWhere('sub_title', 'LIKE', "%{$request->input('query')}%")
                    // ->orWhere('tags', 'LIKE', "%{$request->input('query')}%")
                    ->groupBy('tags')
                    ->get();
        return response()->json($result);
    }

    public function searchResult($search)
    {
        $products = Product::where('tags', 'LIKE', "%{$search}%")
                            // ->orWhere('sub_title', 'LIKE', "%{$search}%")
                            // ->orWhere('tags', 'LIKE', "%{$search}%")
                            ->get();
        $value = Cookie::get('wishlist');
        $wishlists = json_decode($value, true);
        return view('frontend.pages.searchresult', compact('products', 'wishlists'));
    }
}
