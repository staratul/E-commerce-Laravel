<?php

namespace App\Repositories;

use App\Http\Helper;
use PHPUnit\TextUI\Help;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Models\Admin\Products\Product;
use Illuminate\Support\Facades\File;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function insertOrUpdateArray($data)
    {
        return $array = [
            'category_id' => $data['category_id'],
            'tags' => Helper::implode($data['tags']),
            'sub_category_id' => $data['sub_category_id'],
            'title' => $data['title'],
            'sub_title' => $data['sub_title'],
            'states' => Helper::implode($data['states']),
            'size' => Helper::implode($data['size']),
            'colors' => Helper::implode($data['colors']),
            'original_price' => $data['original_price'],
            'discount' => $data['discount'],
            'selling_price' => $data['selling_price'],
            'free_delivery_price' => $data['free_delivery_price'],
            'weight' => $data['weight'],
            'brand' => $data['brand'],
            'seller_name' => $data['seller_name'],
            'seller_state' => $data['seller_state'],
            'total_in_stock' => $data['total_in_stock'],
            'pay_on_delivery' => $data['pay_on_delivery'],
            'status' => $data['status'],
            'product_details' => $data['product_details'],
            'description' => $data['description']
        ];
    }

    public function createProductImage($imageFile, $title, $product)
    {
        $path = 'uploads/products/';
        $file = $imageFile;
        $image = Image::make($file);
        $image = $image->resize(270, 330);
        $imageName = Str::slug($title).time().$file->getClientOriginalName();
        $image->save($path.$imageName);
        $product->product_image()->create([
            'product_image_url' => env('APP_URL') . '/' .$path.$imageName,
            'product_image_name' => $imageName
        ]);
    }

    public function createProductPreviewImage($imageFile, $title, $product)
    {
        $path = 'uploads/products/prev/';
        $file = $imageFile;
        $image = Image::make($file);
        $image = $image->resize(270, 330);
        $imageName = Str::slug($title).'-'.$product->id.'-'.time().$file->getClientOriginalName();
        $image->save($path.$imageName);
        $product->product_preview_images()->create([
            'product_preview_image_url' => env('APP_URL') . '/' .$path.$imageName,
            'product_preview_image_name' => $imageName
        ]);
    }

    public function getAllProduct()
    {
        return Product::latest()->with('product_image')->with('category')->with('sub_category')->get();
    }

    public function storeProduct($data)
    {
        // dd($data);
        DB::beginTransaction();
        try {
            if(!isset($data['pay_on_delivery'])) $data['pay_on_delivery'] = '0';
            if(!isset($data['status'])) $data['status'] = '0';

            $product = Product::create($this->insertOrUpdateArray($data));

            if(isset($data['size_of_product']) && isset($data['stock_of_size'])) {
                foreach($data['size_of_product'] as $key => $size) {
                    $product->product_size_stocks()->create([
                        'product_id' => $product->id,
                        'size' => $size,
                        'stock_in_size' => $data["stock_of_size"][$key]
                    ]);
                }
            }

            if(isset($data['color_of_product']) && isset($data['stock_of_color'])) {
                foreach($data['color_of_product'] as $key => $color) {
                    $product->product_color_stocks()->create([
                        'product_id' => $product->id,
                        'color' => $color,
                        'stock_in_color' => $data['stock_of_color'][$key]
                    ]);
                }
            }

            if(isset($data['product_image'])) {
                $this->createProductImage($data['product_image'], $data['title'], $product);
            }

            if(isset($data['preview_image'])) {
                foreach($data['preview_image'] as $key => $preImg) {
                    $this->createProductPreviewImage($preImg, $data['title'], $product);
                }
            }

            DB::commit();
            return $product;
        } catch(\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }

    public function updateProduct($product, $data)
    {
        DB::beginTransaction();
        try {
            if(!isset($data['pay_on_delivery'])) $data['pay_on_delivery'] = '0';
            if(!isset($data['status'])) $data['status'] = '0';

            Product::where('id', $product->id)->update($this->insertOrUpdateArray($data));

            if(isset($data['size_of_product']) && isset($data['stock_of_size'])) {
                $product->product_size_stocks()->delete();
                $product->product_size_stocks()->forceDelete();
                foreach($data['size_of_product'] as $key => $size) {
                    $product->product_size_stocks()->create([
                        'product_id' => $product->id,
                        'size' => $size,
                        'stock_in_size' => $data["stock_of_size"][$key]
                    ]);
                }
            }

            if(isset($data['color_of_product']) && isset($data['stock_of_color'])) {
                $product->product_color_stocks()->delete();
                $product->product_color_stocks()->forceDelete();
                foreach($data['color_of_product'] as $key => $color) {
                    $product->product_color_stocks()->create([
                        'product_id' => $product->id,
                        'color' => $color,
                        'stock_in_color' => $data['stock_of_color'][$key]
                    ]);
                }
            }

            if(isset($data['product_image'])) {
                $path = 'uploads/products/';
                if(isset($product->product_image)){
                    if(File::exists($path.$product->product_image->product_image_name)) {
                        File::delete($path.$product->product_image->product_image_name);
                    }
                    $product->product_image()->delete();
                    $product->product_image()->forceDelete();
                }
                $this->createProductImage($data['product_image'], $data['title'], $product);
            }

            if(isset($data['preview_image'])) {
                $path = 'uploads/products/prev/';
                if(isset($product->product_preview_images)) {
                    foreach($product->product_preview_images as $img) {
                        if(File::exists($path.$img->product_preview_image_name)) {
                            File::delete($path.$img->product_preview_image_name);
                        }
                        $product->product_preview_images()->delete();
                        $product->product_preview_images()->forceDelete();
                    }
                }
                foreach($data['preview_image'] as $key => $preImg) {
                    $this->createProductPreviewImage($preImg, $data['title'], $product);
                }
            }

            DB::commit();
            return $product;
        } catch(\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }

    }
}
