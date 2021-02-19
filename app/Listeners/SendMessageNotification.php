<?php

namespace App\Listeners;

use App\Events\SentMessage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendMessageNotification
{
    /**
    * Create the event listener.
    *
    * @return void
    */
    public function __construct() {
        //
    }

    /**
    * Handle the event.
    *
    * @param  SentMessage  $event
    * @return void
    */
    public function handle(SentMessage $event) {
        //
    }
}