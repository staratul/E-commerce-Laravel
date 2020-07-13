<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOTPMail extends Mailable
{
    use Queueable, SerializesModels;
    public $userDetail;
    public $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userDetail, $code)
    {
        $this->userDetail = $userDetail;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $code = $this->code;
        return $this->markdown('emails.sendotpmail', compact('code'));
    }
}
