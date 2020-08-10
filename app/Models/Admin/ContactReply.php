<?php

namespace App\Models\Admin;

use App\Models\Frontend\Contact;
use Illuminate\Database\Eloquent\Model;

class ContactReply extends Model
{
    protected $fillable = ['contact_id', 'reply'];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }
}
