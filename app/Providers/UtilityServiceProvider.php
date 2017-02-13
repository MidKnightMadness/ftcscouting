<?php

namespace App\Providers;

use App\Helpers\PermissionHandler;
use App\Helpers\PinHelper;
use App\Helpers\Random;
use App\Helpers\TeamHelper;
use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
//        view()->composer('*', 'App\Http\ViewComposers\TeamComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->app->bind('random', function () {
            return new Random;
        });
        $this->app->bind('pnumber', function () {
            return new PinHelper;
        });
        $this->app->bind('teamhelper', TeamHelper::class);
        $this->app->singleton(PermissionHandler::class, function () {
            return new PermissionHandler();
        });
    }
}
