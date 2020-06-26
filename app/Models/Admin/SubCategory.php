<?php

namespace App\Models\Admin;

use App\Models\Common\SingleImage;
use App\Models\Admin\Products\Product;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['category_id', 'sub_category', 'sub_category_url'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function image() 
    {
        return $this->morphOne(SingleImage::class, 'imageable');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
