<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;
use App\Models\Admin\Category;
use Illuminate\Validation\Rule;
use App\Models\Admin\ProductSize;
use App\Models\Admin\ProductColor;
use App\Http\Controllers\Controller;
use App\Http\Helper;
use Illuminate\Support\Facades\Validator;

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
}
