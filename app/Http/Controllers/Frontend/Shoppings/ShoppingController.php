<?php

namespace App\Http\Controllers\Frontend\Shoppings;

use App\User;
use App\UserDetail;
use App\Http\Helper;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\Frontend\Cart;
use App\Events\AddToCartEvent;
use App\Models\Frontend\Order;
use Nexmo\Laravel\Facade\Nexmo;
use App\Events\OrderShippedEvent;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Frontend\ShoppingCart;
use App\Models\Admin\Products\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UserDetailStoreRequest;

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
                $productId = $cart->unreadNotifications[0]->data["cart"]["product_id"];
                $product = Product::with('product_image')
                                    ->where('id', $productId)
                                    ->orderBy('sub_title')
                                    ->first(['id','sub_title','selling_price']);
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
            Cart::where('id', $request->cart_id)->delete();
            DB::table('notifications')->where('notifiable_id', $request->cart_id)->delete();
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

    public function placeOrder(Request $request)
    {
        $products = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;

        if(!isset($request->is_register)) {
            $request->is_register = '0';
        }

        $userDetail = UserDetail::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'pincode' => $request->pincode,
            'city' => $request->city,
            'email' => $request->email,
            'phone' => $request->phone,
            'is_register' => $request->is_register
        ]);

        if($request->is_register == "1") {
            $user = User::where('email', $userDetail->email)->first();
            if(!isset($user)) {
                $user = User::create([
                    'name' => $userDetail->first_name.' '.$userDetail->last_name,
                    'email' => $userDetail->email,
                    'password' => '',
                    'phone' => $userDetail->phone
                ]);
                UserDetail::where('id', $userDetail->id)->update(['user_id' => $user->id]);
            }
        }

        $user_id = null;
        if(isset($user)) {
            $user_id = $user->id;
        }
        foreach($products->items as $product) {
            $order = Order::create([
                'user_id' => $user_id,
                'user_detail_id' => $userDetail->id,
                'product_id' => $product['item']->id,
                'product_qty' => Helper::implode($product['product_qty']),
                'product_price' => (double)$product['price'],
                'checkout_date' => now(),
                'ip_address' =>  $request->ip(),
                'is_pay' =>  '0',
                'product_color' => Helper::implode($product['colors']),
                'product_size' => Helper::implode($product['sizes']),
                'is_confirm' => '0'
            ]);
        }
        return redirect()->route('send.OTP', $userDetail->id);
    }

    public function orderDetails(UserDetail $userDetail)
    {
        $orders = DB::table('orders')->select(
                                'orders.*', 'products.title', 'products.sub_title',
                                'product_images.product_image_url'
                                )
                            ->join('products', 'products.id', 'orders.product_id')
                            ->join('product_images', 'product_images.product_id', 'products.id')
                            ->where('user_detail_id', $userDetail->id)
                            ->get();
         // event(new OrderShippedEvent($userDetail, $orders));
         return view('frontend.orders.order_details', compact('userDetail', 'orders'));
    }
}
