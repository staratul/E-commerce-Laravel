<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $fillable = ['logo', 'icons', 'address', 'phone', 'email', 'information_links', 'account_links', 'newsletter_text'];
}
