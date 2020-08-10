<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReplyOfContactMessage extends Mailable
{
    use Queueable, SerializesModels;
    public $reply;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reply, $user)
    {
        $this->reply = $reply;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $reply = $this->reply;
        $user = $this->user;
        return $this->markdown('emails.replymessages', compact('reply', 'user'));
    }
}
