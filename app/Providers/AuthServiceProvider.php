<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Team' => 'App\Policies\TeamPolicy'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        parent::registerPolicies();

        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(365));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(365));
    }
}
