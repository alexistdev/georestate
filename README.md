# GeoRestate v1.0

GeoRestate is a web application for listing rental properties: boarding houses (kos), rooms, apartments, houses, and shophouses. Agents post listings, administrators approve them, and property seekers search the listings and contact the agent directly by phone or WhatsApp.

## Features

- **4 roles**, each with its own area:
  - **Super Administrator:** manages admin accounts.
  - **Administrator:** moderates listings, manages agents, property seekers, master data (categories, facilities, regions), and contact messages.
  - **Agent:** self-registers, manages listings (photos, prices, facilities, location point on a map), answers inquiries, and edits their public profile.
  - **User (property seeker):** saves favorites, sends inquiries, and views their inquiry history.
- **Listing approval:** a listing appears on the website only after an administrator approves it. Editing an approved listing sends it back for review.
- **Daily, monthly, and yearly prices.**
- **Search and filters:** keyword, category, province/regency/district, rental period, price range, and number of rooms.
- **Location map:** Leaflet with OpenStreetMap, including directions links.
- **SEO:** meta tags, Open Graph, `sitemap.xml`, and `robots.txt`.
- **Indonesian region data:** 34 provinces, 514 regencies, and about 7,200 districts.

The user interface is in Indonesian.

## Tech Stack

| | |
|---|---|
| Backend | Laravel 12, PHP 8.4 |
| Database | MySQL / MariaDB |
| Frontend | Blade + Bootstrap 5 (Porto template for the website, Velzon template for the panels), jQuery, DataTables (server-side), Select2, Leaflet |
| License | [GeoLicense](https://geolicense.my.id) |
| Tests | PHPUnit (SQLite in-memory) |

Node.js/npm is **not** needed. All front-end assets are already in `public/` or loaded from a CDN.

## Requirements

- Git
- PHP **8.4** with these extensions: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`, `curl`, and `xml`. GD is used for photo cropping and demo photos.
- [Composer](https://getcomposer.org/) 2
- MySQL 8 or MariaDB 10.6+
- An internet connection. The app checks its license online, and some libraries, the map, and map tiles load from a CDN or OpenStreetMap.

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/alexistdev/georestate.git
cd georestate
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Create the environment file

```bash
cp .env.example .env
php artisan key:generate
```

On Windows (Command Prompt), use `copy .env.example .env` instead of `cp`.

### 4. Create the database

Create an empty database, for example `georestate`:

```sql
CREATE DATABASE georestate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Then set the connection in `.env`:

```env
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=georestate
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Register a license on GeoLicense

GeoRestate needs a valid license in **every** environment, including local development. Without one, every page returns **503**.

1. Open **https://geolicense.my.id/register** and create an account, then log in.
2. Open the **Marketplace** menu and select the **GeoRestate** product.
3. Choose a plan (use the **Trial** plan if it is offered) and place the order.
4. Open the **Invoice** menu and complete the invoice if the plan is paid.
5. Open the **License** menu, open your GeoRestate license, and copy the **license key**.

Put the key in `.env`. The product SKU for GeoRestate is `GEOR`:

```env
GEOLICENSE_SERVER_URL=https://geolicense.my.id
GEOLICENSE_LICENSE_KEY=paste-your-license-key-here
GEOLICENSE_PRODUCT_SKU=GEOR
```

### 6. Run migrations and seed the data

```bash
php artisan migrate --seed
```

This creates the tables and fills in:
- roles
- Indonesian region data
- property categories
- facilities
- login accounts (see [Login Accounts](#login-accounts))

When `APP_ENV=local`, it also adds demo agents and sample listings with generated photos.

To reset the database later, run `php artisan migrate:fresh --seed`. This **deletes all data**.

### 7. Link the storage folder

Uploaded listing photos and agent photos are stored in `storage/app/public`. Make them reachable from the browser:

```bash
php artisan storage:link
```

### 8. Run the application

```bash
php artisan serve
```

Open **http://127.0.0.1:8000**.

On the first request the app activates your license with the GeoLicense server. You can also check the license manually:

```bash
php artisan geolicense:verify
```

### 9. (Optional) Run the scheduler

The license is re-verified every hour by Laravel's scheduler. During local development, keep this running in a second terminal:

```bash
php artisan schedule:work
```

On a server, add this cron entry instead:

```cron
* * * * * cd /path-to-georestate && php artisan schedule:run >> /dev/null 2>&1
```

## Login Accounts

These accounts are created by the seeder and are for local development only.

| Role | Email | Password |
|---|---|---|
| Super Administrator | archilles@gmail.com | P@ssw0rd |
| Administrator | admin@gmail.com | 1234 |
| Agent | agen@gmail.com | 1234 |
| User | user@gmail.com | 1234 |

With `APP_ENV=local`, demo agents `agen2@gmail.com` to `agen4@gmail.com` (password `1234`) are also created.

New agents and property seekers can sign up at `/register`.

## Configuration

All settings are in `.env`.

| Setting | Purpose |
|---|---|
| `GEORESTATE_NAMA`, `GEORESTATE_ALAMAT`, `GEORESTATE_TELEPON`, `GEORESTATE_EMAIL` | Site name and contact details shown in the header, footer, and Contact page. |
| `APP_TIMEZONE` | Defaults to `Asia/Jakarta`. |
| `GEORESTATE_PETA_TILE_URL` | Map tile server. Defaults to OpenStreetMap, which is fine for light traffic; use another tile provider for heavy traffic. |
| `MAIL_MAILER`, `MAIL_HOST`, `MAIL_USERNAME`, `MAIL_PASSWORD`, ... | Email. "Forgot password?" appears only when a real mailer is set, i.e. `MAIL_MAILER` is not `log` or `array`. Until then, administrators reset passwords from the admin panel. |

After changing `.env` on a server that uses `php artisan config:cache`, run `php artisan config:clear`.

## Troubleshooting

**Every page shows "503 — Lisensi aplikasi tidak valid"**
- Check `GEOLICENSE_LICENSE_KEY` and that `GEOLICENSE_PRODUCT_SKU=GEOR`.
- Make sure the license is active and not expired in the **License** menu on geolicense.my.id.
- After changing the key or SKU, run `php artisan cache:clear` to force re-activation, then reload the page.
- Run `php artisan geolicense:verify`, and check `storage/logs/laravel.log` for details.

**Listing or agent photos do not appear**
- Run `php artisan storage:link`.
- Make sure `APP_URL` matches the address you open in the browser.

**`SQLSTATE[HY000] [1045] Access denied` or `Unknown database`**
- Check the `DB_*` values in `.env` and that the database exists.

## Running Tests

Tests use an in-memory SQLite database (see `phpunit.xml`), so they never touch your MySQL data. They mark the license as valid and make no requests to the license server.

```bash
php artisan test
```

Code style:

```bash
vendor/bin/pint
```

## Project Notes

The roadmap, product decisions, and module status are documented in [`docs/ANALISIS.md`](docs/ANALISIS.md), in Indonesian.

## Credits

- [Laravel](https://laravel.com)
- Website template: Porto by Okler Themes
- Panel template: Velzon by Themesbrand
- Maps: [Leaflet](https://leafletjs.com) and [OpenStreetMap](https://www.openstreetmap.org/copyright) contributors
- Licensing: [GeoLicense](https://geolicense.my.id)
