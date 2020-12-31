<?php

namespace App\Listeners;

use App\Mail\PostMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class DeletePostListener implements ShouldQueue
{
    use InteractsWithQueue;
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
        Mail::to('example@gmail.com')->send(new PostMail());
    }

    /**
     * Handle a job failure.
     *
     * @param  \App\Events\OrderShipped  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed(OrderShipped $event, $exception)
    {
        dd($exception);
    }

}
