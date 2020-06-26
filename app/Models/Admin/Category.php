<?php

namespace App\Models\Admin;

use App\Models\Admin\Tag;
use App\Models\Admin\HomeSlider;
use App\Models\Admin\Products\Product;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Products\ProductSize;

class Category extends Model
{
    protected $fillable = ['category', 'category_url', 'status'];

    public function sub_categories()
    {
        return $this->hasMany(SubCategory::class);
    }

    public function tag()
    {
        return $this->hasOne(Tag::class);
    }

    public function size()
    {
        return $this->hasOne(ProductSize::class);
    }

    public function home_slider()
    {
        return $this->hasOne(HomeSlider::class);
    }

    public function product_size()
    {
        return $this->hasOne(ProductSize::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
