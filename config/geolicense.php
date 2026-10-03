<?php

return [

    /*
     * Base URL of the GeoLicense server.
     * Example: http://localhost:8082  or  https://license.yourdomain.com
     */
    'server_url' => env('GEOLICENSE_SERVER_URL', 'https://geolicense.my.id'),

    /*
     * License key issued by the GeoLicense server for this installation.
     */
    'license_key' => env('GEOLICENSE_LICENSE_KEY'),

    /*
     * SKU of the product this app is licensed for (Products menu on the GeoLicense server).
     * Required: the server rejects activation/verification without a matching SKU.
     */
    'product_sku' => env('GEOLICENSE_PRODUCT_SKU'),

    /*
     * How often (in minutes) the background scheduler re-verifies the license.
     * Matches the artisan schedule defined in routes/console.php.
     */
    'verify_interval_mins' => env('GEOLICENSE_VERIFY_INTERVAL_MINS', 60),

    /*
     * If the license server is unreachable, allow requests for this many minutes
     * after the last successful verification before blocking traffic.
     */
    'grace_period_minutes' => env('GEOLICENSE_GRACE_PERIOD_MINS', 30),

    /*
     * After a failed activation, wait this many minutes before trying again,
     * so an unreachable server does not slow down every request.
     */
    'activation_retry_minutes' => env('GEOLICENSE_ACTIVATION_RETRY_MINS', 5),

    /*
     * URI patterns that bypass the license check entirely.
     * Supports wildcard (*) matching via Str::is().
     */
    'exclude_paths' => [
        'health',
        'up',
    ],

];
