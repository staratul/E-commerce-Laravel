<?php

namespace App;

use App\Http\Helper;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getCreatedAtAttribute($date)
    {
        return Helper::dateFormat($date);
    }

    public function userCountByMonths($users)
    {
        $usermcount = [];
        $userArr = [];

        foreach($users as $key => $value) {
            $usermcount[(int)$key] = count($value);
        }

        for($i = 1; $i <= 12; $i++) {
            if(!empty($usermcount[$i])) {
                $userArr[$i] = $usermcount[$i];
            } else {
                $userArr[$i] = 0;
            }
        }

        return $userArr;
    }
}
