<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;
    public $userDetail;
    public $orders;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userDetail, $orders)
    {
        $this->userDetail = $userDetail;
        $this->orders = $orders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $orders = $this->orders;
        $userDetail = $this->userDetail;
        return $this->view('emails.ordershipped', compact('orders', 'userDetail'))
                        ->with(['message' => $this]);
    }
}
