<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Tag;
use App\Models\Admin\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\SubMenu;
use App\Models\Admin\Category;
use Illuminate\Validation\Rule;
use App\Models\Admin\SubCategory;
use App\Models\Common\SingleImage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;

class HeaderController extends Controller
{
    public function category(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            if(isset($request->category_id) && $request->category_id) {
                if(isset($request->status)) {
                    if($request->status == '0') {
                        $request->status = '1';
                    }else if($request->status == '1') {
                        $request->status = '0';
                    }
                    Category::where('id', $request->category_id)->update([
                        'status' => $request->status
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'Category Status Updated successfully'
                    ], 200);
                }
                $category = Category::where('id', $request->category_id)->with('sub_categories')->get(['id', 'category', 'category_url']);
                return response()->json($category);
            }
            $categories = Category::with('sub_categories')->latest()->get();
            return response()->json($categories);
        } else if($request->isMethod('get')) {
            return view('admin.pages.categories');
        }else if($request->isMethod('post')) {
            try {
                if(isset($request->categories_id) && $request->categories_id > 0) {
                    $rules = [
                        'category' => [
                                        'required',
                                        Rule::unique('categories')->ignore($request->categories_id),
                                    ]
                    ];
                } else {
                    $rules = [
                        'category' => 'required|string|max:255|unique:categories'
                    ];
                }

                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }
                if(isset($request->categories_id) && $request->categories_id > 0) {
                    Category::where('id', $request->categories_id)->update([
                        'category' => $request->category,
                        'category_url' => Str::slug($request->category_url)
                    ]);

                    if(isset($request->sub_category)) {
                        $imagenameArray = []; $imagePublicPath = [];
                        $subcategories = SubCategory::where('category_id', $request->categories_id)->get();
                        if(isset($subcategories)) {
                            foreach($subcategories as $key => $sub) {
                                if($sub->image) {
                                    $imagenameArray[] = $sub->image->name;
                                    $imagePublicPath[] = public_path() . "/uploads/admin/image/".$sub->image->name;
                                    $sub->image->delete();
                                }
                            }
                        }
                        SubCategory::where('category_id', $request->categories_id)->delete();
                        foreach($request->sub_category as $key => $subCategory) {
                            $insertedSubCategory = SubCategory::create([
                                'category_id' => $request->categories_id,
                                'sub_category' => $subCategory,
                                'sub_category_url' => Str::slug($request->sub_category_url[$key])
                            ]);
                            if($request->file('images') && isset($request->images[$key])) {
                                if(isset($imagePublicPath[$key])){
                                    if(File::exists($imagePublicPath[$key])) {
                                        File::delete($imagePublicPath[$key]);
                                    }
                                }
                                if(isset($request->file('images')[$key])) {
                                    $file = $request->file('images')[$key];
                                    $image = Image::make($file);
                                    $path = 'uploads/admin/image/';
                                    $image = $image->resize(270, 303);
                                    $imagename = Str::slug($request->sub_category[$key]).time().$file->getClientOriginalName();
                                    $image->save($path.$imagename);
                                    $insertedSubCategory->image()->create([
                                       'url' => env('APP_URL').'/'.$path.$imagename,
                                       'name' => $imagename
                                    ]);
                                }
                            } else {
                                if(isset($imagenameArray[$key])) {
                                    $insertedSubCategory->image()->create([
                                        'url' => env('APP_URL').'/'.$imagenameArray[$key],
                                        'name' => $imagenameArray[$key]
                                     ]);
                                }
                            }
                        }
                    }
                    // dd($imagePublicPath);
                    return response()->json([
                        'success' => true,
                        'msg' => 'Category Updated successfully'
                    ], 200);
                }

                $category = Category::create([
                    'category' => $request->category,
                    'category_url' => Str::slug($request->category_url),
                    'status' => '0'
                ]);

                if(isset($request->sub_category)) {
                    foreach($request->sub_category as $key => $subCategory) {
                        $subCategory = SubCategory::create([
                            'category_id' => $category->id,
                            'sub_category' => $subCategory,
                            'sub_category_url' => Str::slug($request->category).'-'.Str::slug($request->sub_category_url[$key])
                        ]);
                        if($request->file('images')) {
                             if(isset($request->file('images')[$key])) {
                                 $file = $request->file('images')[$key];
                                 $image = Image::make($file);
                                 $path = 'uploads/admin/image/';
                                 $image = $image->resize(270, 303);
                                 $imagename = Str::slug($request->sub_category[$key]).time().$file->getClientOriginalName();
                                 $image->save($path.$imagename);
                                $subCategory->image()->create([
                                    'url' => env('APP_URL').'/'.$path.$imagename,
                                    'name' => $imagename
                                ]);
                             }
                        }
                    }
                }

                return response()->json([
                    'success' => true,
                    'msg' => 'Category Added successfully'
                ], 201);

            } catch(\Exception $e) {
                return response()->json(['Error' => $e->getMessage()]);
            }
        } else if($request->isMethod('delete')) {
            if(isset($request->category_id) && $request->category_id > 0) {
                $subcategories = SubCategory::where('category_id', $request->category_id)->get();
                foreach($subcategories as $key => $sub) {
                    if($sub->image) {
                        $imagePath = public_path() . "/uploads/admin/image/".$sub->image->name;
                        if(File::exists($imagePath)) {
                            File::delete($imagePath);
                        }
                        $sub->image->delete();
                    }
                }
                SubCategory::where('category_id', $request->category_id)->delete();
                Category::where('id', $request->category_id)->delete();

                return response()->json([
                    'success' => true,
                    'msg' => 'Category Deleted successfully'
                ], 200);
            }
        }
    }

    public function menu(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            if(isset($request->menu_id) && $request->menu_id) {
                // Update Status
                if(isset($request->status)) {
                    if($request->status == '0') {
                        $request->status = '1';
                    }else if($request->status == '1') {
                        $request->status = '0';
                    }
                    Menu::where('id', $request->menu_id)->update([
                        'status' => $request->status
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'Menu Status Updated successfully'
                    ], 200);
                }
                // Return Edit Menus
                $menu = Menu::where('id', $request->menu_id)->with('sub_menus')->get(['id', 'menu', 'menu_url']);
                return response()->json($menu);
            }
            // Return All Menus
            $menu = Menu::with('sub_menus')->latest()->get();
            return response()->json($menu);
        } else if($request->isMethod('get')) {
            return view('admin.pages.menus');
        }else if($request->isMethod('post')) {
            try {
                if(isset($request->menus_id) && $request->menus_id > 0) {
                    $rules = [
                        'menu' => [
                                        'required',
                                        Rule::unique('menus')->ignore($request->menus_id),
                                    ]
                    ];
                } else {
                    $rules = [
                        'menu' => 'required|string|max:255|unique:menus'
                    ];
                }
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }
                if(isset($request->menus_id) && $request->menus_id > 0) {
                    Menu::where('id', $request->menus_id)->update([
                        'menu' => $request->menu,
                        'menu_url' => Str::slug($request->menu_url)
                    ]);

                    if(isset($request->sub_menu)) {
                        SubMenu::where('menu_id', $request->menus_id)->delete();
                        foreach($request->sub_menu as $key => $submenu) {
                            SubMenu::create([
                                'menu_id' => $request->menus_id,
                                'sub_menu' => $submenu,
                                'sub_menu_url' => Str::slug($request->sub_menu_url[$key])
                            ]);
                        }
                    }

                    return response()->json([
                        'success' => true,
                        'msg' => 'Menu Updated successfully'
                    ], 200);
                }
                $menu = Menu::create([
                    'menu' => $request->menu,
                    'menu_url' => Str::slug($request->menu_url),
                    'status' => '0'
                ]);

                if(isset($request->sub_menu)) {
                    foreach($request->sub_menu as $key => $submenu) {
                        SubMenu::create([
                            'menu_id' => $menu->id,
                            'sub_menu' => $submenu,
                            'sub_menu_url' => Str::slug($request->sub_menu_url[$key])
                        ]);
                    }
                }

                return response()->json([
                    'success' => true,
                    'msg' => 'Menu Added successfully'
                ], 201);

            } catch(\Exception $e) {
                return response()->json(['Error' => $e->getMessage()]);
            }
        } else if($request->isMethod('delete')) {
            if(isset($request->menu_id) && $request->menu_id > 0) {
                Menu::where('id', $request->menu_id)->delete();
                SubMenu::where('menu_id', $request->menu_id)->delete();
                return response()->json([
                    'success' => true,
                    'msg' => 'Menu Deleted successfully'
                ], 200);
            }
        }
    }

    public function tag(Request $request)
    {
        if($request->isMethod('get') && $request->ajax()) {
            if(isset($request->tags_id) && $request->tags_id) {
                // Update Status
                if(isset($request->status)) {
                    if($request->status == '0') {
                        $request->status = '1';
                    }else if($request->status == '1') {
                        $request->status = '0';
                    }
                    Tag::where('id', $request->tags_id)->update([
                        'status' => $request->status
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'Tag Status Updated successfully'
                    ], 200);
                }
                // Return Edit Tag
                $tags = Tag::where('id', $request->tags_id)->with('category')->first();
                return response()->json($tags);
            }
            // Return All Tag
            $tags = Tag::with('category')->latest()->get();
            return response()->json($tags);
        } else if($request->isMethod('get')) {
            $categories = Category::all();
            return view('admin.pages.tags', compact('categories'));
        }else if($request->isMethod('post')) {
            try {
                if(isset($request->tags_id) && $request->tags_id > 0) {
                    $rules = [
                        'category_id' => [
                                        'required',
                                        Rule::unique('tags')->ignore($request->tags_id),
                                    ],
                        'tags' => 'required'

                    ];
                } else {
                    $rules = [
                        'category_id' => 'required|unique:tags',
                        'tags' => 'required'
                    ];
                }
                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }
                if(isset($request->tags_id) && $request->tags_id > 0) {
                    Tag::where('id', $request->tags_id)->update([
                        'category_id' => $request->category_id,
                        'tags' => $request->tags
                    ]);

                    return response()->json([
                        'success' => true,
                        'msg' => 'Tag Updated successfully'
                    ], 200);
                }
                Tag::create([
                    'category_id' => $request->category_id,
                    'tags' => $request->tags,
                    'status' => '0'
                ]);

                return response()->json([
                    'success' => true,
                    'msg' => 'Tags Added successfully'
                ], 201);

            } catch(\Exception $e) {
                return response()->json(['Error' => $e->getMessage()]);
            }
        } else if($request->isMethod('delete')) {
            if(isset($request->tags_id) && $request->tags_id > 0) {
                Tag::where('id', $request->tags_id)->delete();
                return response()->json([
                    'success' => true,
                    'msg' => 'Tags Deleted successfully'
                ], 200);
            }
        }
    }

}
