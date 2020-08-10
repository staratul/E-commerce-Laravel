<?php

namespace App\Listeners;

use App\Mail\ReplyOfContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReplyOfContactMessageListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to($event->user['user_email'])->send(new ReplyOfContactMessage($event->reply, $event->user));
    }
}
