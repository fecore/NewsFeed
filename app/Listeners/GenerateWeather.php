<?php

namespace App\Listeners;

use App\Events\ViewNews;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateWeather
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
     * @param  ViewNews  $event
     * @return void
     */
    public function handle(ViewNews $event)
    {
        //
    }
}
