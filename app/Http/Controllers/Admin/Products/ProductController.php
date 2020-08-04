<?php

namespace App\Http\Controllers\Admin\Products;

use App\Models\Admin\State;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use App\Models\Admin\Products\Product;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Admin\Products\Brand;
use Illuminate\Support\Facades\Session;
use App\Models\Admin\Products\ProductColor;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{
    protected $product;

    public function __construct(ProductRepositoryInterface $product)
    {
        $this->product = $product;
    }

    public function addProdcutData()
    {
        $categories = Category::with('tag')
                ->with('sub_categories')
                ->with('size')
                ->orderBy('category')
                ->get();
        $states = State::orderBy('state')->get();
        $colors = ProductColor::orderBy('color')->get();
        $brands = Brand::orderBy('brand')->get();

        return [
                "categories" => $categories,
                "states" => $states,
                "colors" => $colors,
                "brands" => $brands
            ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->getAllProduct();
        return view('admin.pages.products.products', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $array = $this->addProdcutData();
        $categories = $array['categories']; $states = $array['states']; $colors = $array['colors'];
        $brands = $array['brands'];
        return view('admin.pages.products.add_products', compact('categories', 'states', 'colors', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        try {
            $product = $this->product->storeProduct($request->all());
            Session::flash('success', 'Product Added Successfully.');
            return redirect()->route('products.index');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->product_color_stocks = $product->product_color_stocks;
        $product->product_size_stocks = $product->product_size_stocks;
        $array = $this->addProdcutData();
        $categories = $array['categories']; $states = $array['states']; $colors = $array['colors'];
        $brands = $array['brands'];
        return view('admin.pages.products.add_products', compact('categories','states','colors','product','brands'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductStoreRequest $request, Product $product)
    {
        $product = $this->product->updateProduct($product, $request->all());
        Session::flash('success', 'Product Updated Successfully.');
        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
