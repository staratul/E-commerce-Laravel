<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class SingleImage extends Model
{
    protected $guarded = [];

    public function imageable()
    {
        return $this->morphTo();
    }
}
