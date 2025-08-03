<?php

namespace Shakib\LicenseVerify;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Application;
use Shakib\LicenseVerify\Http\Middleware\LicenseCheck;

class LicenseVerifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Laravel 12 এ middleware append করতে bootstrap callback use করো
        if ($this->app instanceof Application) {
            $this->app->afterResolving(Middleware::class, function (Middleware $middleware) {
                $middleware->append(LicenseCheck::class);
            });
        }
    }

    public function register(): void
    {
        // Optional: config publish, binding, etc.
    }
}
