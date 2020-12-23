<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Http\View\Composers\TagComposer;
use Illuminate\Support\Facades\View;

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
        View::composer(['*'], TagComposer::class);
    }
}
