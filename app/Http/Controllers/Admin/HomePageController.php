<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\HomeSliderRequest;
use App\Models\Admin\HomeSlider;
use Illuminate\Validation\Rule;
use App\Models\Frontend\PaymentType;
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
                        $editRoute = route('edit-home-slider', $row->id);
                        $deleteRoute = route('delete-home-slider', $row->id);
                        $btn = '<a href="'.$editRoute.'" class="btn btn-info">Edit</a><a href="'.$deleteRoute.'" class="btn btn-danger ml-2">Delete</a>';
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
                $rules = [
                    'category_id' => 'required',
                    'tags' => 'required',
                    'title' => 'required|string|max:50',
                    'offer' => 'required|min:1|max:99',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
                ];

                if(isset($request->home_slider_id)) {
                    $rules['image'] = 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
                }

                $validator = Validator::make($request->all(), $rules);

                if($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                if(isset($request->home_slider_id)) {
                    $homeSlider = $this->homeSlider->updateHomeslider($request->all());

                    Session::flash('success', 'Home Slider Updated Successfully.');
                    return back();
                }

                $homeSlider = $this->homeSlider->addHomeSlider($request->all());

                Session::flash('success', 'Home Slider Added Successfully.');
                return back();

            } catch(\Exception $e) {
                dd($e->getMessage());
            }
        }
    }

    public function editHomeSlider(HomeSlider $homeSlider)
    {
        $categories = Category::with('tag')->orderBy('category')->get();
        return view('admin.pages.add_homeslider', compact('categories', 'homeSlider'));
    }

    public function deleteHomeSlider(HomeSlider $homeSlider)
    {
        $homeSlider->delete();
        Session::flash('success', 'Home Slider Deleted Successfully.');
        return back();
    }

    public function paymentTypes(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            if(isset($request->payment_type_id) && $request->payment_type_id) {
                $payment_type = PaymentType::where('id', $request->payment_type_id)->first();
                return response()->json($payment_type);
            }
            // Return All payment_type
            $payment_type = PaymentType::latest()->get();
            return response()->json($payment_type);
        } else if($request->isMethod('get')) {
            return view('admin.pages.products.payment_types');
        }else if($request->isMethod('post')) {
            try {
                if(isset($request->payment_type_id)) {
                    $rules = [
                        'payment_type' => ['required',
                                        Rule::unique('payment_types')->ignore($request->payment_type_id),
                                    ]
                    ];
                } else {
                    $rules = [
                        'payment_type' => 'required|unique:payment_types'
                    ];
                }
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }
                if(isset($request->payment_type_id)) {
                    PaymentType::where('id', $request->payment_type_id)->update([
                        'payment_type' => $request->payment_type
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'payment_type Updated successfully'
                    ], 200);
                }
                PaymentType::create([
                    'payment_type' => $request->payment_type
                ]);

                return response()->json([
                    'success' => true,
                    'msg' => 'payment_type Added successfully'
                ], 201);

            } catch(\Exception $e) {
                return response()->json(['Error' => $e->getMessage()]);
            }
        } else if($request->isMethod('delete')) {
            if(isset($request->payment_type_id)) {
                PaymentType::where('id', $request->payment_type_id)->delete();
                return response()->json([
                    'success' => true,
                    'msg' => 'payment_type Deleted successfully'
                ], 200);
            }
        }
    }
}
