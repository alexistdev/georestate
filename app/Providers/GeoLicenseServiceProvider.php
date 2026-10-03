<?php

namespace App\Providers;

use App\Services\GeoLicense\LicenseActivationService;
use App\Services\GeoLicense\LicenseHolder;
use App\Services\GeoLicense\MachineIdGenerator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

/**
 * Registers GeoLicense services and triggers activation on first boot.
 *
 * Laravel 11/12/13 — register this provider in bootstrap/providers.php:
 *
 *   return [
 *       App\Providers\AppServiceProvider::class,
 *       App\Providers\GeoLicenseServiceProvider::class,  // <-- add this
 *   ];
 */
class GeoLicenseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(MachineIdGenerator::class);
        $this->app->singleton(LicenseHolder::class);

        $this->app->singleton(LicenseActivationService::class, function ($app) {
            return new LicenseActivationService(
                $app->make(LicenseHolder::class),
                $app->make(MachineIdGenerator::class),
            );
        });

        $this->app->singleton(\App\Services\GeoLicense\LicenseVerificationService::class, function ($app) {
            return new \App\Services\GeoLicense\LicenseVerificationService(
                $app->make(LicenseHolder::class),
                $app->make(MachineIdGenerator::class),
            );
        });
    }

    public function boot(): void
    {
        $holder = $this->app->make(LicenseHolder::class);

        // Activate when there is no token for the current key/SKU yet (first boot, cache flush,
        // or the license config changed), but not again before the retry cooldown after a failure.
        if ((! empty($holder->getToken()) && $holder->matchesConfig()) || ! $holder->canRetryActivation()) {
            return;
        }

        // Token from a different key/SKU: drop it so it can no longer keep the app unlocked.
        $holder->forget();

        try {
            $this->app->make(LicenseActivationService::class)->activate();
        } catch (\Throwable $e) {
            // Do not crash the app (or artisan commands); the middleware blocks traffic instead.
            $holder->markActivationFailed((int) config('geolicense.activation_retry_minutes', 5));
            Log::error($e->getMessage());
        }
    }
}
