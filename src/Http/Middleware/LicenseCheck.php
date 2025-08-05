<?php

namespace Centralora\LicenseVerify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LicenseCheck
{
    public function handle(Request $request, Closure $next)
    {
        $excludedPaths = [
            'api/activate-license',
            'api/reset-license',
            'api/install-module',
            'api/uninstall-module'
        ];

        $currentDomain = $request->getHost();
        $cached = cache()->get('license_verified');

        $isVerified = is_array($cached) &&
                      isset($cached['status'], $cached['domain']) &&
                      $cached['status'] &&
                      $cached['domain'] === $currentDomain;

        if (!$isVerified) {
            if ($request->is('license-verify') || $this->isExcluded($request, $excludedPaths)) {
                return $next($request);
            }
            return redirect()->route('license.verify')->withErrors([
                'license' => 'This installation is not verified. Contact support at support@yourdomain.com'
            ]);
        }

        if ($request->is('license-verify')) {
            return redirect('/');
        }

        return $next($request);
    }

    protected function isExcluded(Request $request, array $excludedPaths): bool
    {
        foreach ($excludedPaths as $path) {
            if ($request->is($path)) {
                return true;
            }
        }
        return false;
    }
}
