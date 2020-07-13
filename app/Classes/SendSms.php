<?php

namespace App\Classes;

use Nexmo\Laravel\Facade\Nexmo;
use Twilio\Rest\Client;

class SendSms
{
    public function sendNexmoSms($message)
    {
        try {
            Nexmo::message()->send([
                'to'   => '917982650358',
                'from' => 'Vonage APIs',
                'text' => $message
            ]);
            return true;
        } catch(\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function sendTwilioSms($message)
    {
       try {
            $account_sid        = config('app.twilio')['TWILIO_SID'];
            $auth_token         = config('app.twilio')['TWILIO_AUTH_TOKEN'];
            $twilio_number      = config('app.twilio')['TWILIO_NUMBER'];
            $client = new Client($account_sid, $auth_token);

            $client->messages->create('+917982650358', [
                'from' => $twilio_number, 'body' => $message
            ]);
            return true;
       } catch(\Exception $e) {
           dd($e->getMessage());
       }
    }
}
