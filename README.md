## GeoRestate v.1.0

A web-based application for real estate management, such as boarding houses, rental rooms, or apartments. The application has 4 roles: super administrator, administrator, agent, and user. Agents post property listings available for rent (listings are approved by an administrator before they are published), while users search for properties and contact the agent.

## System
- Framework: Laravel 12 (PHP 8.4)
- Database: MySQL

## Installation Guide
- Clone the repository
- Open terminal and run `composer install`
- Create an empty database named: `georestate`
- Copy `.env.example` and rename it to `.env`
- Run: `php artisan key:generate`
- Run: `php artisan migrate:fresh --seed`
- Run: `php artisan serve`

## License (GeoLicense)
This application is protected by [GeoLicense](https://geolicense.my.id). Set these in `.env`:

```env
GEOLICENSE_SERVER_URL=https://geolicense.my.id
GEOLICENSE_LICENSE_KEY=your-license-key
GEOLICENSE_PRODUCT_SKU=your-product-sku
```

- On first boot the app activates the license and caches the token; all pages return **503** while the license is invalid (short grace period if the license server is unreachable).
- Re-verification runs hourly via the scheduler, so add the cron entry: `* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1`
- Manual check: `php artisan geolicense:verify`. After changing the key or SKU, run `php artisan cache:clear` to force re-activation.
- A valid license is required in every environment, including local development. Automated tests mark the license as valid in `tests/TestCase.php` and never contact the license server.

## Email & Password Reset
"Forgot password?" is shown only when a real mailer is configured (`MAIL_MAILER` other than `log`/`array`, e.g. `smtp` with `MAIL_HOST`, `MAIL_USERNAME`, `MAIL_PASSWORD`). Until then, administrators reset passwords from the admin panel (Agents → detail, Property Seekers → Reset Password; Super Admin → Manage Admins).

## Running Tests
Tests use an in-memory SQLite database (see `phpunit.xml`), so they never touch the MySQL development database.

```bash
php artisan test
```

## Login Info (seeder, local development only)

| Role | Email | Password |
|---|---|---|
| Super Administrator | archilles@gmail.com | P@ssw0rd |
| Administrator | admin@gmail.com | 1234 |
| Agent | agen@gmail.com | 1234 |
| User | user@gmail.com | 1234 |

New agents and users can also sign up at `/register`.

When `APP_ENV=local`, the seeder also creates demo data (`DemoListingSeeder`): agents `agen2@gmail.com` to `agen4@gmail.com` (password `1234`) and approved sample listings with generated photos. Run `php artisan storage:link` so the photos are visible.
