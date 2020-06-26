<?php

namespace App\Models\Admin\Products;

use App\Models\Admin\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSizeStock extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_id', 'size', 'stock_in_size'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
