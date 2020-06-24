<?php

namespace App\Models\Admin;

use App\Models\Admin\Category;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    protected $fillable = ['category_id', 'size', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
