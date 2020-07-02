<?php

namespace App\Http\Controllers\Frontend\Shoppings;

use Illuminate\Http\Request;
use App\Models\Frontend\Cart;
use App\Events\AddToCartEvent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Frontend\ShoppingCart;
use App\Models\Admin\Products\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ShoppingController extends Controller
{
    public function addToCart(Request $request)
    {
        if($request->ajax() && $request->isMethod('post')) {
            try {
                $user_id = null;
                $rules = [
                    'product_id' => 'required',
                    'quantity' => 'required',
                    'size' => 'required',
                    'color' => 'required'
                ];

                $validator = Validator::make($request->all(), $rules);
                if($validator->fails()) {
                    return response()->json(['errors' => $validator->getMessageBag()], 400);
                }

                if(Auth::user()) {
                    $user_id = Auth::user()->id;
                }

                $cart = Cart::create([
                    'product_id' => $request->product_id,
                    'user_id' => $user_id,
                    'quantity' => $request->quantity,
                    'size' => $request->size,
                    'color' => $request->color
                ]);

                // Add notification of add to cart
                event(new AddToCartEvent($cart));

                return response()->json(['success' => 'Cart Added Successfully!', 'cart' => $cart]);

            } catch(\Exception $e) {
                return response()->json(['errors' => $e->getMessage()], 500);
            }
        }
    }

    public function cartNotifications(Request $request, Cart $cart)
    {
            if($request->ajax() && $request->isMethod('get')) {
                // Session::flush();
                $productId = $cart->unreadNotifications[0]->data["cart"]["product_id"];
                $product = Product::with('product_image')
                                    ->where('id', $productId)
                                    ->orderBy('sub_title')
                                    ->first(['id', 'sub_title', 'selling_price']);
                $product->cart = $cart;
                $oldCart = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;
                $obj = new ShoppingCart($oldCart);
                $obj->addToCart($product, $productId);
                Session::put('shoppingcart', $obj);
                return Response::json($obj);
            }
    }

    public function removeCartItem(Request $request)
    {
        if($request->ajax() && $request->isMethod('post')) {
            Cart::where('product_id', $request->id)->delete();
            $oldCart = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;
            $obj = new ShoppingCart($oldCart);
            $obj->removeItemFromCart($request->id);
            Session::put('shoppingcart', $obj);
            return response()->json(['success' => 'Item Deleted From Cart!', 'cart' => $obj]);
        }
    }

    public function decreaseCartQty(Request $request)
    {
        $oldCart = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;
        $obj = new ShoppingCart($oldCart);
        $obj->decreaseCartQty($request->id, $request->qty);
        Session::put('shoppingcart', $obj);
        return response()->json(['cart' => $obj, 'item' => $obj->items[$request->id]]);
    }

    public function increaseCartQty(Request $request)
    {
        $oldCart = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;
        $obj = new ShoppingCart($oldCart);
        $obj->increaseCartQty($request->id, $request->qty);
        Session::put('shoppingcart', $obj);
        return response()->json(['cart' => $obj, 'item' => $obj->items[$request->id]]);
    }

    public function cartCheckOut()
    {
        $products = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;
        if(Session::has('shoppingcart') && count($products->items) > 0) {
            return view('frontend.pages.check-out', compact('products'));
        } else {
            return back();
        }
    }
}
