<?php

namespace App\Listeners;

use App\Mail\PostsMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class CreatesPostListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $message= 'post created';
        Mail::to($event->postCreate->posted_by)->send(new PostsMail($event->postCreate,$message));
    }
}
