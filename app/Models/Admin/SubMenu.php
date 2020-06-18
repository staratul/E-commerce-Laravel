<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $fillable = ['menu_id', 'sub_menu', 'sub_menu_url'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
