<?php

namespace App\Models\Admin;

use App\Models\Admin\Category;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['category_id', 'tags', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
