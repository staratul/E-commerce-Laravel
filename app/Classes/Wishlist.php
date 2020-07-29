<?php

namespace App\Classes;

use Illuminate\Support\Facades\Cookie;

class Wishlist
{
    public $list = [];

    public function __construct($list)
    {
        $this->list = $list;
        // dd($this->list);
    }

    public function addToWishlist($list) {
        try {
            $value = Cookie::get('wishlist');
            // $value = json_decode($value, true);
            // dd($value);
            if($value === null) {
                $this->list[$list['product_id']] = $list;
                Cookie::queue("wishlist", json_encode($this->list) , 2628000);
                return;
            } else {
                $value = Cookie::get('wishlist');
                if(!array_key_exists($list['product_id'], $this->list)) {
                    $this->list[$list['product_id']] = $list;
                    Cookie::queue("wishlist", json_encode($this->list) , 2628000);
                }
                return;
            }
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function removeItemFromWishlist($id) {
        $value = Cookie::get('wishlist');
        $value = json_decode($value, true);
        if(array_key_exists($id, $this->list)) {
            unset($this->list[$id]);
            Cookie::queue("wishlist", json_encode($this->list) , 2628000);
        }
        return;
    }

}
