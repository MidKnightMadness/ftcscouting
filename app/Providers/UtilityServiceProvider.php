<?php

namespace App\Providers;

use App\Helpers\Random;
use Illuminate\Support\ServiceProvider;

class UtilityServiceProvider extends ServiceProvider
{

    protected $defer = true;

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
    }

    public function provides() {
        return ['App\Helpers\Random'];
    }
}
