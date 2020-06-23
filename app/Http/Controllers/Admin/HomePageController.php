<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\HomeSliderRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\HomeSliderRepositoryInterface;

class HomePageController extends Controller
{
    protected $homeSlider;

    public function __construct(HomeSliderRepositoryInterface $homeSlider)
    {
        $this->homeSlider = $homeSlider;
    }

    public function homeSlider(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            $homeSliders = $this->homeSlider->getAllSlider();
            // dd($homeSliders);
            return DataTables::of($homeSliders)
                    ->addIndexColumn()
                    ->addColumn('action', function($row) {
                        $btn = '<a href="javascript:;" class="btn btn-info">Edit</a>';
                        return $btn;
                    })
                    ->addColumn('image', function($row) {
                        $url = asset(env('APP_URL')."/uploads/admin/home/thumbnail/".$row->image->name);
                        return '<img src='.$url.'>';
                    })
                    ->addColumn('tags', function($row) {
                        $html = "";
                        $tags = explode(',', $row->tags);
                        foreach($tags as $tag) {
                            $html .= '<span class="badge badge-pill badge-primary ml-2">'.$tag.'</span>';
                        }
                        return $html;
                    })
                    ->rawColumns(['image', 'tags', 'action'])
                    ->make(true);
        } else if($request->isMethod('get')) {
            return view('admin.pages.homeslider');
        }
    }

    public function addHomeSlider(Request $request)
    {
        if($request->isMethod('get')) {
            $categories = Category::with('tag')->orderBy('category')->get();
            return view('admin.pages.add_homeslider', compact('categories'));
        } else if($request->isMethod('post')) {
            try {
                $validator = Validator::make($request->all(), [
                    'category_id' => 'required',
                    'tags' => 'required',
                    'title' => 'required|string|max:50',
                    'offer' => 'required|min:1|max:99',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ]);

                if($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                $homeSlider = $this->homeSlider->addHomeSlider($request->all());

                Session::flash('success', 'Home Slider Added Successfully.');
                return back();

            } catch(\Exception $e) {
                dd($e->getMessage());
            }
        }
    }
}
