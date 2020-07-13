<?php

namespace App\Models\Frontend;

class ShoppingCart
{
    public $items = null;
    public $totalQty = 0;
    public $totalPrice = 0;

    public function __construct($oldCart)
    {
        if($oldCart) {
            $this->items = $oldCart->items;
            $this->totalQty = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        } else {
            $this->totalQty = 0;
            $this->totalPrice = 0;
        }
    }

    public function addToCart($item, $id) {
        try {
            $sizes=[];$colors=[];$quantity=[];
            $storedItem = ['qty' => 0, 'price' => $item->selling_price, 'item'=> $item, 'sizes' => [], 'colors' => [], 'product_qty' => []];
            if($this->items) {
                if(array_key_exists($id, $this->items)) {
                    $this->items[$id]['item'] = $item;
                    $storedItem = $this->items[$id];
                    foreach($storedItem['sizes'] as $size) {
                        array_push($sizes, $size);
                    }
                    foreach($storedItem['colors'] as $color) {
                        array_push($colors, $color);
                    }
                    foreach($storedItem['product_qty'] as $qty) {
                        array_push($quantity, $qty);
                    }
                    $this->totalQty = $this->totalQty - $storedItem['qty'];
                    $this->totalPrice = $this->totalPrice - $storedItem['price'];
                    $item->cart->quantity = $item->cart->quantity + $storedItem['qty'];
                }
            }
            array_push($sizes, $item->cart->size);
            array_push($colors, $item->cart->color);
            array_push($quantity, (int)$item['cart']->unreadNotifications[0]->data['cart']['quantity']);
            $storedItem['qty'] = $item->cart->quantity;
            $storedItem['price'] = $item->selling_price * $storedItem['qty'];
            $storedItem['sizes'] = $sizes;
            $storedItem['product_qty'] = $quantity;
            $storedItem['colors'] = $colors;
            $this->items[$id] = $storedItem;
            $this->totalQty += $storedItem['qty'];
            $this->totalPrice += $item->selling_price * $storedItem['qty'];
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function removeItemFromCart($id) {
        if($this->items) {
            if(array_key_exists($id, $this->items)) {
                $this->totalQty = $this->totalQty - $this->items[$id]["qty"];
                $this->totalPrice = $this->totalPrice - $this->items[$id]["price"];
                unset($this->items[$id]);
            }
        }
    }

    public function decreaseCartQty($id, $qty)
    {
        if($qty > 1) {
            if($this->items) {
                if(array_key_exists($id, $this->items)) {
                    $this->totalQty = $this->totalQty - 1;
                    $this->items[$id]["qty"] = $this->items[$id]["qty"] - 1;
                    $this->totalPrice = $this->totalPrice - $this->items[$id]["price"];
                    $this->items[$id]["price"] = $this->items[$id]["item"]->selling_price * $this->items[$id]["qty"];
                    $this->totalPrice = $this->totalPrice + $this->items[$id]["price"];
                }
            }
        }
    }

    public function increaseCartQty($id, $qty)
    {
        if($qty >= 1 && $qty < 10) {
            if($this->items) {
                if(array_key_exists($id, $this->items)) {
                    $this->totalQty = $this->totalQty + 1;
                    $this->items[$id]["qty"] = $this->items[$id]["qty"] + 1;
                    $this->totalPrice = $this->totalPrice - $this->items[$id]["price"];
                    $this->items[$id]["price"] = $this->items[$id]["item"]->selling_price * $this->items[$id]["qty"];
                    $this->totalPrice = $this->totalPrice + $this->items[$id]["price"];
                }
            }
        }
    }
}
