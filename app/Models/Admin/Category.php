<?php

namespace App\Models\Admin;

use App\Models\Admin\Tag;
use App\Models\Admin\HomeSlider;
use Illuminate\Database\Eloquent\Model;

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

    public function home_slider()
    {
        return $this->hasOne(HomeSlider::class);
    }

}
