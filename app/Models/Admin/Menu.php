<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['menu', 'menu_url', 'status'];

    public function sub_menus()
    {
        return $this->hasMany(SubMenu::class);
    }
}
