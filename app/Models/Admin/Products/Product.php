<?php

namespace App\Models\Admin\Products;

use App\Models\Admin\Category;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Products\ProductImage;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Admin\Products\ProductSizeStock;
use App\Models\Admin\Products\ProductColorStock;
use App\Models\Admin\Products\ProductPreviewImage;
use App\Models\Admin\SubCategory;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'tags',
        'sub_category_id',
        'title',
        'sub_title',
        'states',
        'size',
        'colors',
        'original_price',
        'discount',
        'selling_price',
        'free_delivery_price',
        'weight',
        'brand',
        'seller_name',
        'seller_state',
        'total_in_stock',
        'pay_on_delivery',
        'status',
        'product_details',
        'description'
    ];

    public function getSellingPriceAttribute($price)
    {
        return floor($price);
    }

    public function product_image()
    {
        return $this->hasOne(ProductImage::class);
    }

    public function product_preview_images()
    {
        return $this->hasMany(ProductPreviewImage::class);
    }

    public function product_color_stocks()
    {
        return $this->hasMany(ProductColorStock::class);
    }

    public function product_size_stocks()
    {
        return $this->hasMany(ProductSizeStock::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
