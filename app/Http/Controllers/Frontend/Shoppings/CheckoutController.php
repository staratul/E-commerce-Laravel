<?php

namespace App\Http\Controllers\Frontend\Shoppings;

use Stripe\Charge;
use Stripe\Stripe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Frontend\Order;
use App\UserDetail;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function getCheckoutPayment(UserDetail $userDetail)
    {
        $products = Session::has('shoppingcart') ? Session::get('shoppingcart') : null;
        if(Session::has('shoppingcart') && count($products->items) > 0) {
            return view('frontend.pages.check-out-payment', compact('products', 'userDetail'));
        } else {
            return back();
        }
    }

    public function postCheckoutPayment(Request $request, UserDetail $userDetail)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $customer = \Stripe\Customer::create([
              'name' => $userDetail->first_name.' '.$userDetail->last_name,
              'email' => $userDetail->email,
              'address' => [
                'line1' => $userDetail->address1.','.$userDetail->address2,
                'postal_code' => $userDetail->pincode,
                'city' => $userDetail->city,
                'state' => 'DL',
                'country' => 'IN',
              ],
            ]);

            \Stripe\Customer::createSource(
              $customer->id,
              ['source' => $request->stripeToken]
            );

            \Stripe\Charge::create ([
                "customer" => $customer->id,
                "amount" => 100 * $request->total_price,
                "currency" => "inr",
                "description" => "Test payment from stripe.test." ,
            ]);

            if(isset($request->payment_type)) {
                Order::where('user_detail_id', $userDetail->id)
                            ->update([
                                        'payment_type_id' => $request->payment_type,
                                        'is_pay' => 1
                                    ]);
            }

            return redirect()->route('order.details', $userDetail->id);

            } catch (\Exception $ex) {
                Session::flash('error','Payment Failed.');
                return $ex->getMessage().' error occured';
            }
    }

    public function payOnDelivery(Request $request, UserDetail $userDetail)
    {
        request()->validate([
            'g-recaptcha-response' => 'required|captcha'
        ]);
        // Order::where()
        if(isset($request->payment_type)) {
            Order::where('user_detail_id', $userDetail->id)
                        ->update(['payment_type_id' => $request->payment_type]);
        }
        return redirect()->route('order.details', $userDetail->id);
    }

    public function upiPaymentChoose(Request $request, UserDetail $userDetail)
    {
        if($request->isMethod('post')) {
            if(isset($request->upi_payment_mode)) {
                switch($request->upi_payment_mode) {
                    case 'Paytm':
                        return redirect()->route('initiate.payment', [$userDetail->id,$request->payment_type]);
                        break;
                    case 'PayPal':
                        return redirect()->route('payment.paypal', [$userDetail->id,$request->payment_type]);
                        break;
                    case 'PhonePe':
                        dd("PhonePey");
                        break;
                    case 'GooglePay':
                        dd("googlepay");
                        break;
                    default:
                        return back();
                }
            }
        }
    }
}
