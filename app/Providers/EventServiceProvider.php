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
            \App\Listeners\SendUserCreatePostMailListener::class,
            \App\Listeners\SendUserCreatePostDataMailListener::class,
        ],
        \App\Events\PostUpdateEvent::class => [
            \App\Listeners\SendUserUpdatePostMailListener::class,
            \App\Listeners\SendUserUpdatesPostDataMailListener::class,
        ],
        \App\Events\PostDeleteEvent::class => [
            \App\Listeners\SendDeletePostMailListener::class,
            \App\Listeners\SendDeletePostDataMailListener::class,
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
