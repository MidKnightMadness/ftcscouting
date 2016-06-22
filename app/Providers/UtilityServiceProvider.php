<?php

namespace App\Providers;

use App\Helpers\Random;
use App\Helpers\TeamHelper;
use App\Team;
use App\TeamInvite;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Log;

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
        $this->app->singleton(TeamHelper::class, function(){
            return new TeamHelper();
        });
    }
}
