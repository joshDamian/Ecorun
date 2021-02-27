<?php

namespace App\Listeners;

use App\Events\PlacedOrder;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPlacedOrderNotification
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
     * @param  PlacedOrder  $event
     * @return void
     */
    public function handle(PlacedOrder $event)
    {
        //
    }
}
