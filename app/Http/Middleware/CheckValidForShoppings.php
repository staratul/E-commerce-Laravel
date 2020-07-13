<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Models\Frontend\OTPVerification;

class CheckValidForShoppings
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
            $oldOtp = OTPVerification::where('id', $request->oTPVerification->id)
                                        ->first(['otp','created_at','is_verified']);
            $createdTime = $oldOtp->created_at->diffForHumans(null, true, true, 2);
            $time = explode(":",str_replace(['h', 'm', 's', ' '], ['', '', '', ':'], $createdTime));
            if($time[0] < "5" && $oldOtp->is_verified == "0") {
                return $next($request);
            }
        } else {
            return back();
        }
        return back();
    }
}
