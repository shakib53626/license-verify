<?php

namespace Shakib\LicenseVerify;
use Illuminate\Support\ServiceProvider;

class LicenseVerifyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // API Routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }
}
