<?php

namespace App\Models\Frontend;

use App\Http\Helper;
use App\Models\Admin\ContactReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Contact extends Model
{
    use Notifiable;

    protected $fillable = ['name', 'email', 'message'];

    public function getCreatedAtAttribute($date) {
        return Helper::dateFormat($date);
    }

    public function contact_reply()
    {
        return $this->hasOne(ContactReply::class);
    }
}
