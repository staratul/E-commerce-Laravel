<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function homeSlider(Request $request)
    {
        if($request->isMethod('get')) {
            return view('admin.pages.homeslider');
        }
    }

    public function addHomeSlider(Request $request)
    {
        if($request->isMethod('get')) {
            $categories = Category::with('tag')->orderBy('category')->get();
            return view('admin.pages.add_homeslider', compact('categories'));
        }
    }
}
