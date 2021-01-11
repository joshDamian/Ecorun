<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use App\Events\PostCreated;
use App\Events\ProductCreated;
use App\Events\SentMessage;
use App\Listeners\SendPostCreatedNotificaton;
use App\Listeners\SendDirectMessageNotification;
use App\Listeners\SendProductCreatedNotificaton;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        PostCreated::class => [
            SendPostCreatedNotificaton::class
        ],
        ProductCreated::class => [
            SendProductCreatedNotificaton::class
        ],
        SentMessage::class => [
            SendMessageNotification::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
