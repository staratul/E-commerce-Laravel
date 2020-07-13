<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\Frontend\OTPVerification;

class CheckValidForPayments
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $products = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;
        if(Session::has('shoppingcart') && count($products->items) > 0) {
            $oldOtp = OTPVerification::where('user_id', $request->userDetail->id)
                                        ->orderBy('created_at', 'desc')
                                        ->first(['otp','created_at','is_verified']);
            $createdTime = $oldOtp->created_at->diffForHumans(null, true, true, 2);
            if(!str_contains($createdTime,'d')) {
                if($oldOtp->is_verified == "1") {
                    return $next($request);
                }
            }
        } else {
             return redirect()->route('cart.checkout');
        }
         return redirect()->route('cart.checkout');
    }
}
