<?php

namespace App\Models\Admin\Products;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = ['color', 'code', 'status'];
}
