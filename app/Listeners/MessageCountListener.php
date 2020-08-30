<?php

namespace App\Listeners;

use App\Events\MessageCount;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class MessageCountListener
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
     * @param  MessageCount  $event
     * @return void
     */
    public function handle(MessageCount $event)
    {
        //
    }
}
