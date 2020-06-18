<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\Admin\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Admin\SubCategory;

class ProductCategoryController extends Controller
{
    public function queryCategories($category) {
        $Subcategories = Category::where('category', $category)->first();
        if($Subcategories) {
            $Subcategories = $Subcategories->sub_categories;
        } else {
            return null;
        }
        if($Subcategories) {
            foreach($Subcategories as $key => $categogory) {
                $Subcategories[$key]->image = $categogory->image;
            }
        }
        return $Subcategories;
    }

    public function womensClothing() {
        $subCategory = $this->queryCategories("Women’s Clothing");
        return view('frontend.pages.product-categories', compact('subCategory'));
    }

    public function mensClothing() {
        $subCategory = $this->queryCategories("Men’s Clothing");
        return view('frontend.pages.product-categories', compact('subCategory'));
    }

    public function kidsClothing() {
        $subCategory = $this->queryCategories("Kid's Clothing");
        return view('frontend.pages.product-categories', compact('subCategory'));
    }

    public function homeLiving() {
        $subCategory = $this->queryCategories("Home & Living");
        return view('frontend.pages.product-categories', compact('subCategory'));
    }

    public function accessories() {
        $subCategory = $this->queryCategories("Accessories");
        return view('frontend.pages.product-categories', compact('subCategory'));
    }

    public function essentials() {
        $subCategory = $this->queryCategories("Essentials");
        return view('frontend.pages.product-categories', compact('subCategory'));
    }

    public function luxuryBrands() {
        $subCategory = $this->queryCategories("Luxury Brands");
        return view('frontend.pages.product-categories', compact('subCategory'));
    }

}
