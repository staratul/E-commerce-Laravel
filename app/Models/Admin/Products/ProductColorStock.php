<?php

namespace App\Models\Admin\Products;

use App\Models\Admin\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductColorStock extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_id', 'color', 'stock_in_color'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
