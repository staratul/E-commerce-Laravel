<?php

namespace App\Models\Frontend;

use App\Http\Helper;
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
        return $this->belongsTo(UserDetail::class, 'user_detail_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getCheckoutDateAttribute($date)
    {
        return Helper::dateFormat($date);
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }
}
