<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use Illuminate\Validation\Rule;
use App\Models\Admin\DealOfWeek;
use App\Models\Admin\HomeSlider;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Frontend\PaymentType;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\HomeSliderRequest;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
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

    public function weekDealData(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            $weekdeals = DealOfWeek::with('category')->with('image')->latest()->get();
            return response()->json($weekdeals);
        }
        return back();
    }

    public function weekDeal(Request $request)
    {
        $categories = Category::with('tag')
                                ->orderBy('category')
                                ->get();
        if($request->isMethod('get')) {
            return view('admin.pages.weekdeal', compact('categories'));
        } else if ($request->isMethod('post')) {
            $rules = [
                'category_id' => 'required',
                'deal_type' => 'required',
                'deal_on' => 'required',
                'price' => 'required',
                'image' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];
            
            $validator = Validator::make($request->all(), $rules);
            
            if($validator->fails()) {
                return response()->json(['errors' => $validator->getMessageBag()], 400);
            }
            try {
                if(isset($request->weekdeal_id)) {
                    DB::beginTransaction();
                    $weekdeal = DealOfWeek::where('id', $request->weekdeal_id)->update([
                        'category_id' => $request->category_id,
                        'deal_type' => $request->deal_type,
                        'deal_on' => $request->deal_on,
                        'price' => $request->price,
                        'content' => $request->content
                    ]);
    
                    if(isset($request->image)) {
                        $path = 'uploads/admin/weekdeal/';
                        $dealImage = DealOfWeek::where('id', $request->weekdeal_id)->with('image')->first();
                        if(isset($dealImage->image)){
                            if(File::exists($path.$dealImage->image->name)) {
                                File::delete($path.$dealImage->image->name);
                            }
                        }
                        $file = $request->image;
                        $image = Image::make($file);
                        $image = $image->resize(1769, 569);
                        $imageName = Str::slug($request->deal_on.$request->deal_type).time().$file->getClientOriginalName();
                        $image->save($path.$imageName);
                        $dealImage->image()->update([
                            'url' => env('APP_URL') . '/' .$path.$imageName,
                            'name' => $imageName
                        ]);
                    }
                    DB::commit();
                    return response()->json(['msg' => "Deal Updated Successfully."]);
                }
            } catch(\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
            }

            DB::beginTransaction();
            try {
                $weekdeal = DealOfWeek::create([
                    'category_id' => $request->category_id,
                    'deal_type' => $request->deal_type,
                    'deal_on' => $request->deal_on,
                    'price' => $request->price,
                    'content' => $request->content
                ]);

                if(isset($request->image)) {
                    $path = 'uploads/admin/weekdeal/';
                    $file = $request->image;
                    $image = Image::make($file);
                    $image = $image->resize(1769, 569);
                    $imageName = Str::slug($request->deal_on.$request->deal_type).time().$file->getClientOriginalName();
                    $image->save($path.$imageName);
                    $weekdeal->image()->create([
                        'url' => env('APP_URL') . '/' .$path.$imageName,
                        'name' => $imageName
                    ]);
                } else {
                    $weekdeal->image()->create([
                        'url' => "http://localhost:8000/uploads/admin/weekdeal/tshirtw1596075823time-bg.jpg",
                        'name' => "No Image"
                    ]);
                }
                DB::commit();
                return response()->json(['data' => $weekdeal, 'msg' => 'Deal Added Successfully.']);
            } catch(\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
            }
        }
    }

    public function editWeekdeal(DealOfWeek $dealOfWeek)
    {
        return response()->json($dealOfWeek);
    }

    public function activeWeekdeal(Request $request, DealOfWeek $dealOfWeek)
    {
        if($request->status == 0) {
            $toDate = "";
            if($dealOfWeek->deal_type === "D") {
                $toDate = new \DateTime("+1 day");
            } else if($dealOfWeek->deal_type === "M") {
                $toDate = new \DateTime("+30 day");
            } else if ($dealOfWeek->deal_type === "W") {
                $toDate = new \DateTime("+7 day");
            }
            $dealOfWeek->active = 1;
            $dealOfWeek->from_date = now();
            $dealOfWeek->to_date = $toDate;
            $dealOfWeek->save();
    
            DealOfWeek::where('id', '!=', $dealOfWeek->id)->update([
                'active' => 0
            ]);
        } else {
            $dealOfWeek->active = 0;
            $dealOfWeek->save();
        }

        return response()->json(['msg' => 'Deal Active!']);
    }

    public function weekdealExpired()
    {
        $count = DealOfWeek::where('active', 1)->count();
        if($count == 1) {
            dd($count);
            DealOfWeek::where('active', 1)->update([
                'active' => 0
            ]);
        }
        return response()->json(['msg' => "Deal Expired!"]);
    }
}
