<?php

namespace App\Models\Frontend;

use App\Models\Admin\Products\Product;
use App\UserDetail;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'user_detail_id',
        'product_id',
        'product_qty',
        'product_price',
        'checkout_date',
        'ip_address',
        'is_pay',
        'product_color',
        'product_size',
        'is_confirm'
    ];

    public function userDetails()
    {
        return $this->hasMany(UserDetail::class);
    }
}
