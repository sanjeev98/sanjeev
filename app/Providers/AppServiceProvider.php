<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Http\View\Composers\TagComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
            info('Query', [
                "Query" => $query->sql,
                "Bindings" => $query->bindings,
                "Time" => $query->time,
            ]);
        });
        Queue::failing(function (JobFailed $event) {
            info('failed', [ $event->connectionName,
             $event->job,
             $event->exception,]);
        });
        View::composer(['*'], TagComposer::class);
    }
}
