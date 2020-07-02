<?php

namespace App\Models\Frontend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Cart extends Model
{
    use Notifiable;

    protected $fillable = ['product_id', 'user_id', 'quantity', 'size', 'color'];
}
