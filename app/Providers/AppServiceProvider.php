<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        if (env('LOG_QUERIES', false))
            DB::listen(function ($query) {
                $sql = $query->sql;
                $backtrace = debug_backtrace();
                $log = "Query \"{$sql}\" executed by: \n";
                foreach ($backtrace as $bt) {
                    $file = isset($bt['file']) ? $bt['file'] : "Unknown";
                    $line = isset($bt['file']) ? $bt['line'] : "??";
                    $log .= "\t{$file}:{$line}\n";
                }
                \Log::info($log);
            });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->app->alias('bugsnag.multi', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.multi', \Psr\Log\LoggerInterface::class);
    }
}
