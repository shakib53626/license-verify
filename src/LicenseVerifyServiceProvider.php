<?php

namespace Shakib\LicenseVerify;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Shakib\LicenseVerify\Http\Middleware\LicenseCheck;

class LicenseVerifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Load web and api routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        // Laravel 12: Append global middleware dynamically
        if ($this->app instanceof Application) {
            $this->app->afterResolving(Middleware::class, function (Middleware $middleware) {
                $middleware->append(LicenseCheck::class);
            });
        }
    }

    public function register(): void
    {
        //
    }
}
