<?php

namespace App\Models\Admin;

use App\Models\Admin\Category;
use App\Models\Common\SingleImage;
use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $fillable = ['category_id', 'tags', 'title', 'offer', 'content'];

    public function image()
    {
        return $this->morphOne(SingleImage::class, 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // public function getOfferAttribute($offer)
    // {
    //     return $offer . "%";
    // }
}
