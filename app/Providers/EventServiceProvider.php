<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        \App\Events\PostCreateEvent::class => [
            \App\Listeners\CreatePostListener::class,
            \App\Listeners\CreatesPostListener::class,
        ],
        \App\Events\PostUpdateEvent::class => [
            \App\Listeners\UpdatePostListener::class,
            \App\Listeners\UpdatesPostListener::class,
        ],
        \App\Events\PostDeleteEvent::class => [
            \App\Listeners\DeletePostListener::class,
            \App\Listeners\DeletesPostListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
