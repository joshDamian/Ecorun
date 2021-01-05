<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use App\Notifications\ProductCreated as NotificationsProductCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendProductCreatedNotificaton
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
     * @param  ProductCreated  $event
     * @return void
     */
    public function handle(ProductCreated $event)
    {
        $notifiables = $event->product->loadMissing('business.profile.followers')->business->profile->followers->except([$event->product->business->profile->id]);
        Notification::send($notifiables, new NotificationsProductCreated($event->product));
    }
}
