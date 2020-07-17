<?php

namespace App\Http\Controllers\Frontend\Shoppings;

use App\UserDetail;
use Illuminate\Http\Request;
use App\Models\Frontend\Order;
use App\Models\Frontend\Paytm;
use App\Http\Controllers\Controller;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;

class PaytmController extends Controller
{
    // display a form for payment
    public function initiate(UserDetail $userDetail, $typeId=null)
    {
        return view('frontend.payments.paytm',compact('userDetail', 'typeId'));
    }

    public function pay(Request $request, UserDetail $userDetail, $typeId=null)
    {
        $amount = 100; //Amount to be paid

        $userData = [
            'name' => $userDetail->first_name, // Name of user
            'mobile' => $userDetail->phone, //Mobile number of user
            'email' => $userDetail->email, //Email of user
            'fee' => $amount,
            'order_id' => $userDetail->phone."_".rand(1,1000) //Order id
        ];

        $paytmuser = Paytm::create($userData); // creates a new database record

        $payment = PaytmWallet::with('receive');

        $payment->prepare([
            'order' => $userData['order_id'],
            'user' => $paytmuser->id,
            'mobile_number' => $userData['mobile'],
            'email' => $userData['email'], // your user email address
            'amount' => $amount, // amount will be paid in INR.
            'callback_url' => route('status.payment', [$userDetail->id, $typeId]) // callback URL
        ]);
        return $payment->receive();  // initiate a new payment
    }

    public function paymentCallback(UserDetail $userDetail, $typeId=null)
    {
        $transaction = PaytmWallet::with('receive');

        $response = $transaction->response();

        $order_id = $transaction->getOrderId(); // return a order id

        $transaction->getTransactionId(); // return a transaction id


        // update the db data as per result from api call
        if ($transaction->isSuccessful()) {
            Paytm::where('order_id', $order_id)->update(['status' => 1, 'transaction_id' => $transaction->getTransactionId()]);
            Order::where('user_detail_id', $userDetail->id)
                            ->update([
                                        'payment_type_id' => $typeId,
                                        'is_pay' => 1
                                    ]);
            return redirect()->route('order.details', $userDetail->id);

        } else if ($transaction->isFailed()) {
            Paytm::where('order_id', $order_id)->update(['status' => 0, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('home'))->with('message', "Your payment is failed.");

        } else if ($transaction->isOpen()) {
            Paytm::where('order_id', $order_id)->update(['status' => 2, 'transaction_id' => $transaction->getTransactionId()]);
            return redirect(route('home'))->with('message', "Your payment is processing.");
        }
        $transaction->getResponseMessage(); //Get Response Message If Available

        // $transaction->getOrderId(); // Get order id
    }
}
