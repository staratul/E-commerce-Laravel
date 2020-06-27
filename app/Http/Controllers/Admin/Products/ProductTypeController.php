<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Helper;
use App\Models\Admin\State;
use Illuminate\Http\Request;
use App\Models\Admin\Category;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Models\Admin\Products\Brand;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Products\ProductSize;
use App\Models\Admin\Products\ProductColor;

class ProductTypeController extends Controller
{
    public function productSize(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            if(isset($request->size_id) && $request->size_id) {
                // Update Status
                if(isset($request->status)) {
                    if($request->status == '0') {
                        $request->status = '1';
                    }else if($request->status == '1') {
                        $request->status = '0';
                    }
                    ProductSize::where('id', $request->size_id)->update([
                        'status' => $request->status
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'size Status Updated successfully'
                    ], 200);
                }
                // Return Edit size
                $size = ProductSize::with('category')->where('id', $request->size_id)->first();
                return response()->json($size);
            }
            // Return All size
            $size = ProductSize::with('category')->latest()->get();
            return response()->json($size);
        } else if($request->isMethod('get')) {
            $categories = Category::latest()->get();
            return view('admin.pages.products.product_size', compact('categories'));
        }else if($request->isMethod('post')) {
            try {
                if(isset($request->size_id)) {
                    $rules = [
                        'size' => 'required',
                        'category_id' => ['required',
                                        Rule::unique('product_sizes')->ignore($request->size_id),
                                    ],
                    ];
                } else {
                    $rules = [
                        'size' => 'required',
                        'category_id' => 'required|unique:product_sizes'
                    ];
                }
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }
                if(isset($request->size_id)) {
                    ProductSize::where('id', $request->size_id)->update([
                        'size' => Helper::implode($request->size),
                        'category_id' => $request->category_id
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'Size Updated Successfully'
                    ], 200);
                }
                ProductSize::create([
                    'size' => Helper::implode($request->size),
                    'category_id' => $request->category_id,
                    'status' => '1'
                ]);

                return response()->json([
                    'success' => true,
                    'msg' => 'Size Added Successfully'
                ], 201);

            } catch(\Exception $e) {
                return response()->json(['Error' => $e->getMessage()]);
            }
        } else if($request->isMethod('delete')) {
            if(isset($request->size_id) && $request->size_id > 0) {
                ProductSize::where('id', $request->size_id)->delete();
                return response()->json([
                    'success' => true,
                    'msg' => 'Size Deleted Successfully'
                ], 200);
            }
        }
    }

    public function productColor(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            if(isset($request->color_id) && $request->color_id) {
                // Update Status
                if(isset($request->status)) {
                    if($request->status == '0') {
                        $request->status = '1';
                    }else if($request->status == '1') {
                        $request->status = '0';
                    }
                    ProductColor::where('id', $request->color_id)->update([
                        'status' => $request->status
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'Color Status Updated successfully'
                    ], 200);
                }
                // Return Edit Color
                $color = ProductColor::where('id', $request->color_id)->first();
                return response()->json($color);
            }
            // Return All Color
            $color = ProductColor::latest()->get();
            return response()->json($color);
        } else if($request->isMethod('get')) {
            return view('admin.pages.products.product_color');
        }else if($request->isMethod('post')) {
            try {
                if(isset($request->color_id) && $request->color_id > 0) {
                    $rules = [
                        'color' => ['required',
                                        Rule::unique('product_colors')->ignore($request->color_id),
                                    ],
                        'code' => ['required',
                                        Rule::unique('product_colors')->ignore($request->color_id),
                                    ],
                    ];
                } else {
                    $rules = [
                        'color' => 'required|unique:product_colors',
                        'code' => 'required|unique:product_colors'
                    ];
                }
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }
                if(isset($request->color_id) && $request->color_id > 0) {
                    ProductColor::where('id', $request->color_id)->update([
                        'color' => $request->color,
                        'code' => $request->code
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'Color Updated successfully'
                    ], 200);
                }
                ProductColor::create([
                    'color' => $request->color,
                    'code' => $request->code,
                    'status' => '1'
                ]);

                return response()->json([
                    'success' => true,
                    'msg' => 'color Added successfully'
                ], 201);

            } catch(\Exception $e) {
                return response()->json(['Error' => $e->getMessage()]);
            }
        } else if($request->isMethod('delete')) {
            if(isset($request->color_id) && $request->color_id > 0) {
                ProductColor::where('id', $request->color_id)->delete();
                return response()->json([
                    'success' => true,
                    'msg' => 'color Deleted successfully'
                ], 200);
            }
        }
    }

    public function state(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            if(isset($request->state_id) && $request->state_id) {
                $state = State::where('id', $request->state_id)->first();
                return response()->json($state);
            }
            // Return All state
            $state = State::latest()->get();
            return response()->json($state);
        } else if($request->isMethod('get')) {
            return view('admin.pages.products.states');
        }else if($request->isMethod('post')) {
            try {
                if(isset($request->state_id)) {
                    $rules = [
                        'state' => ['required',
                                        Rule::unique('states')->ignore($request->state_id),
                                    ]
                    ];
                } else {
                    $rules = [
                        'state' => 'required|unique:states'
                    ];
                }
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }
                if(isset($request->state_id)) {
                    State::where('id', $request->state_id)->update([
                        'state' => $request->state
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'State Updated successfully'
                    ], 200);
                }
                State::create([
                    'state' => $request->state
                ]);

                return response()->json([
                    'success' => true,
                    'msg' => 'State Added successfully'
                ], 201);

            } catch(\Exception $e) {
                return response()->json(['Error' => $e->getMessage()]);
            }
        } else if($request->isMethod('delete')) {
            if(isset($request->state_id)) {
                State::where('id', $request->state_id)->delete();
                return response()->json([
                    'success' => true,
                    'msg' => 'State Deleted successfully'
                ], 200);
            }
        }
    }

    public function brand(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            if(isset($request->brand_id) && $request->brand_id) {
                $brand = Brand::where('id', $request->brand_id)->first();
                return response()->json($brand);
            }
            // Return All brand
            $brand = Brand::latest()->get();
            return response()->json($brand);
        } else if($request->isMethod('get')) {
            return view('admin.pages.products.brands');
        }else if($request->isMethod('post')) {
            try {
                if(isset($request->brand_id)) {
                    $rules = [
                        'brand' => ['required',
                                        Rule::unique('brands')->ignore($request->brand_id),
                                    ]
                    ];
                } else {
                    $rules = [
                        'brand' => 'required|unique:brands'
                    ];
                }
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }
                if(isset($request->brand_id)) {
                    Brand::where('id', $request->brand_id)->update([
                        'brand' => $request->brand
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'Brand Updated successfully'
                    ], 200);
                }
                Brand::create([
                    'brand' => $request->brand
                ]);

                return response()->json([
                    'success' => true,
                    'msg' => 'Brand Added successfully'
                ], 201);

            } catch(\Exception $e) {
                return response()->json(['Error' => $e->getMessage()]);
            }
        } else if($request->isMethod('delete')) {
            if(isset($request->brand_id)) {
                Brand::where('id', $request->brand_id)->delete();
                return response()->json([
                    'success' => true,
                    'msg' => 'Brand Deleted successfully'
                ], 200);
            }
        }
    }
}
