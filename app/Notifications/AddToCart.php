<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddToCart extends Notification implements ShouldQueue
{
    use Queueable;

    public $cart;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($cart)
    {
        $this->cart = $cart;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'cart' => $this->cart
        ];
    }
}