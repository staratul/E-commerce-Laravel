<?php

namespace App\Models\Frontend;

use App\UserDetail;
use Illuminate\Database\Eloquent\Model;

class OTPVerification extends Model
{
    protected $fillable = ['user_id', 'otp', 'is_verified'];

    public function user_detail()
    {
        return $this->belongsTo(UserDetail::class, 'id', 'user_id');
    }
}
