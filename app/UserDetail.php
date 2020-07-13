<?php

namespace App;

use App\Models\Frontend\OTPVerification;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
                'first_name',
                'last_name',
                'address1',
                'address2',
                'pincode',
                'city',
                'email',
                'phone',
                'is_register'];

    public function o_t_p_verifications()
    {
        return $this->hasMany(OTPVerification::class, 'user_id', 'id');
    }
}
