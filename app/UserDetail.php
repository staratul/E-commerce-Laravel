<?php

namespace App;

use App\Models\Admin\Products\Product;
use App\Models\Frontend\Order;
use App\Models\Frontend\OTPVerification;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
                'first_name',
                'last_name',
                'address1',
                // 'address2',
                'pincode',
                'city',
                'email',
                'phone',
                'is_register',
                'user_id'];

    public function o_t_p_verifications()
    {
        return $this->hasMany(OTPVerification::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id', 'user_detail_id');
    }

}
