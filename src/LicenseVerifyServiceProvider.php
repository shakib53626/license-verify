<?php

namespace Centralora\LicenseVerify;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Centralora\LicenseVerify\Http\Middleware\LicenseCheck;

class LicenseVerifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app instanceof Application) {
            $this->app->afterResolving(Middleware::class, function (Middleware $middleware) {
                $this->appendIfNotExists($middleware, LicenseCheck::class);
            });
        }

        // Load web and api routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

    }

    protected static function appendIfNotExists(Middleware $middleware, string $class): void
    {
        $reflection = new \ReflectionProperty($middleware, 'global');
        $reflection->setAccessible(true);

        $current = $reflection->getValue($middleware);

        if (!in_array($class, $current, true)) {
            // Append the middleware
            $middleware->append($class);
        }
    }
}
