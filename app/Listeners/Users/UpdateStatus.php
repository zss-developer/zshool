<?php

namespace App\Listeners\Users;

use Illuminate\Auth\Events\Login;
use Carbon\Carbon;

class UpdateStatus
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
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $event->user->logged_in = Carbon::now();
        $event->user->save();
    }
}
