<?php

namespace App\Listeners;


use App\Mail\SendUserPostMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendDeletePostDataMailListener
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
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $message = 'Post Deleted';
        Mail::to($event->postDelete->posted_by)->send(new SendUserPostMail($event->postDelete, $message));
    }
}
