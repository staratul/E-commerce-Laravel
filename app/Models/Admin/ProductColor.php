<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    protected $fillable = ['color', 'code', 'status'];
}
