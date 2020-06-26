<?php

namespace App\Models\Admin\Products;

use App\Models\Admin\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPreviewImage extends Model
{
    use SoftDeletes;

    protected $fillable = ['product_id', 'product_preview_image_name', 'product_preview_image_url'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
