<?php

namespace App\Http\Controllers\Email;

use App\UserDetail;
use App\Http\Helper;
use App\Classes\SendSms;
use App\Mail\SendOTPMail;
use App\Events\SendOTPEvent;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Models\Frontend\OTPVerification;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Validator;

class EmailVerificationController extends Controller
{
    public function sendOTP(UserDetail $userDetail)
    {
       try {
           $code = random_int(100000, 999999);
           $otp = $userDetail->o_t_p_verifications()->create([
               'otp' => $code,
               'is_verified' => '0'
            ]);

            event(new SendOTPEvent($userDetail, $code));

            $message = 'To authenticate, please use the following One Time Password(OTP): '.$code;

            // Send OTP on mobile
            // $sendsms = new SendSms();
            // $sendsms->sendNexmoSms($message);
            // $sendsms->sendTwilioSms($message);
            return redirect()->route('otpVerification', [$userDetail->id, $otp->id]);
       } catch(\Exception $e) {
           dd($e->getMessage());
       }
    }

    public function otpVerification(Request $request, UserDetail $userDetail, otpVerification $oTPVerification)
    {
        if($request->isMethod('get')) {
            return view('frontend.email.otpverification', compact('userDetail', 'oTPVerification'));
        } else if($request->isMethod('post')) {
            $rules = [
                'input1' => 'required',
                'input2' => 'required',
                'input3' => 'required',
                'input4' => 'required',
                'input5' => 'required',
                'input6' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $inputs = [];
            $formdata = $request->toArray();
            for($i=1; $i<=6; $i++) {
                $inputs[] = $formdata["input".$i];
            }
            $oldOtp = OTPVerification::where('id', $oTPVerification->id)
                                        ->first(['otp','created_at','is_verified']);
            $createdTime = $oldOtp->created_at->diffForHumans(null, true, true, 2);
            $time = explode(":",str_replace(['h', 'm', 's', ' '], ['', '', '', ':'], $createdTime));
            if($time[0] < "5" && $oldOtp->is_verified == "0") {
                $enterOtp = (int)implode("",$inputs);
                if($oldOtp->otp === $enterOtp) {
                    $userDetail->o_t_p_verifications()->update([
                        'is_verified' => '1'
                    ]);

                    return redirect()->route('checkout.payemnt', $userDetail->id);
                } else {
                    return back()->withErrors('Invalid OTP')->withInput();
                }
            }
            return redirect()->route('cart.checkout')->withErrors('Expire OTP')->withInput();
        }
    }
}
