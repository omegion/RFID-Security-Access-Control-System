<?php

namespace App\Listeners;

use App\Events\CardIsFound;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class CreateNewHistoryForUser
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
     * @param  CardIsFound  $event
     * @return void
     */
    public function handle(CardIsFound $event)
    {
        Log::debug("card is found, user : ". $event->user->name);
        
        $history = new \App\UserHistory;
        $history->user_id = $event->user->id;
        $history->save();
        
    }
}
