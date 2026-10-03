<?php

namespace App\Services\GeoLicense;

use Illuminate\Support\Facades\Cache;

/**
 * Persists license state in the Laravel cache (Redis or file driver).
 *
 * This replaces the in-memory singleton used by the Spring Boot starter.
 * All values are stored with Cache::forever() so they survive PHP restarts;
 * validity is re-evaluated on every scheduled verification run.
 *
 * The token is bound to the configuration it was issued for (server URL, license key, product SKU).
 * When that configuration changes (e.g. a different key in .env), the cached state no longer counts
 * as valid and the app must activate again.
 */
class LicenseHolder
{
    private const TOKEN_KEY      = 'geolicense.token';
    private const VALID_KEY      = 'geolicense.valid';
    private const LAST_VALID_KEY = 'geolicense.last_valid_at';
    private const RETRY_KEY      = 'geolicense.activation_retry_blocked';
    private const CONFIG_KEY     = 'geolicense.config_fingerprint';

    public function setToken(string $token): void
    {
        Cache::forever(self::TOKEN_KEY, $token);
        Cache::forever(self::CONFIG_KEY, $this->fingerprint());
    }

    public function getToken(): ?string
    {
        return Cache::get(self::TOKEN_KEY);
    }

    public function setValid(bool $valid): void
    {
        Cache::forever(self::VALID_KEY, $valid);

        if ($valid) {
            Cache::forever(self::LAST_VALID_KEY, now()->timestamp);
        }
    }

    public function isValid(): bool
    {
        return $this->matchesConfig() && (bool) Cache::get(self::VALID_KEY, false);
    }

    /**
     * True if the cached token was issued for the current server URL, license key and product SKU.
     */
    public function matchesConfig(): bool
    {
        return Cache::get(self::CONFIG_KEY) === $this->fingerprint();
    }

    /**
     * Returns a Unix timestamp of the last successful verification, or null if never verified.
     */
    public function getLastValidAt(): ?int
    {
        return $this->matchesConfig() ? Cache::get(self::LAST_VALID_KEY) : null;
    }

    /**
     * Block new activation attempts for the given number of minutes after a failure.
     */
    public function markActivationFailed(int $minutes): void
    {
        Cache::put(self::RETRY_KEY, $this->fingerprint(), now()->addMinutes($minutes));
    }

    /**
     * False during the cooldown after a failed activation, unless the configuration has changed since.
     */
    public function canRetryActivation(): bool
    {
        return Cache::get(self::RETRY_KEY) !== $this->fingerprint();
    }

    /**
     * Wipe all cached license state (useful for forced re-activation).
     */
    public function forget(): void
    {
        Cache::forget(self::TOKEN_KEY);
        Cache::forget(self::VALID_KEY);
        Cache::forget(self::LAST_VALID_KEY);
        Cache::forget(self::RETRY_KEY);
        Cache::forget(self::CONFIG_KEY);
    }

    private function fingerprint(): string
    {
        return hash('sha256', implode('|', [
            (string) config('geolicense.server_url'),
            (string) config('geolicense.license_key'),
            (string) config('geolicense.product_sku'),
        ]));
    }
}
