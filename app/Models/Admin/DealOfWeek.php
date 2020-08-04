<?php

namespace App\Models\Admin;

use App\Models\Admin\Category;
use App\Models\Common\SingleImage;
use Illuminate\Database\Eloquent\Model;

class DealOfWeek extends Model
{
    protected $fillable = ['category_id', 'deal_type', 'deal_on', 'price', 'content'];

    public function image()
    {
        return $this->morphOne(SingleImage::class, 'imageable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
