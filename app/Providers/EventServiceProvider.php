<?php

namespace App\Providers;

use App\Events\AddToCartEvent;
use App\Events\OrderShippedEvent;
use App\Events\SendOTPEvent;
use App\Listeners\AddToCartListener;
use App\Listeners\OrderShippedListener;
use App\Listeners\SendOTPListener;
use App\Mail\OrderShipped;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AddToCartEvent::class => [
            AddToCartListener::class,
        ],
        SendOTPEvent::class => [
            SendOTPListener::class,
        ],
        OrderShippedEvent::class => [
            OrderShippedListener::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
