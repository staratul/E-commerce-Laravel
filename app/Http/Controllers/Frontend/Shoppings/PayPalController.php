<?php

namespace App\Http\Controllers\Frontend\Shoppings;

use App\UserDetail;
use Illuminate\Http\Request;
use App\Models\Frontend\Order;
use App\Http\Controllers\Controller;
use Srmklive\PayPal\Services\ExpressCheckout;

class PayPalController extends Controller
{
    public function paypal(UserDetail $userDetail, $typeId=null)
    {
        return view('frontend.payments.paypal', compact('userDetail', 'typeId'));
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function payment(UserDetail $userDetail, $typeId=null)
    {
        $data = [];
        $data['items'] = [
            [
                'name' => 'atul',
                'price' => 100,
                'desc'  => 'Description for atul',
                'qty' => 1
            ]
        ];
        $data['invoice_id'] = 'KARAM94_PAYPAL_1';
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success', [$userDetail->id, $typeId]);
        $data['cancel_url'] = route('payment.cancel');
        $data['total'] = 100;

        $provider = new ExpressCheckout;

        $response = $provider->setExpressCheckout($data);

        $response = $provider->setExpressCheckout($data, true);
        return redirect($response['paypal_link']);
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }

    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request, UserDetail $userDetail, $typeId=null)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if (in_array(strtoupper($response['ACK']), ['SUCCESS', 'SUCCESSWITHWARNING'])) {
            Order::where('user_detail_id', $userDetail->id)
                            ->update([
                                        'payment_type_id' => $typeId,
                                        'is_pay' => 1
                                    ]);
            return redirect()->route('order.details', $userDetail->id);
        }

        dd('Something is wrong.');
    }
}
