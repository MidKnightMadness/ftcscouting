<?php

namespace App\Providers;

use App\Helpers\PermissionHandler;
use App\Helpers\Random;
use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
       view()->composer('*', 'App\Http\ViewComposers\TeamComposer');
    }
    
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Random::class, function(){
            return new Random();
        });
        $this->app->singleton(PermissionHandler::class, function(){
            return new PermissionHandler();
        });
    }
}
