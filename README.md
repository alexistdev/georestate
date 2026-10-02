## GeoRestate v.1.0

A web-based application for real estate management, such as boarding houses, rental rooms, or apartments. The application has 4 roles: super administrator, administrator, agent, and user. Agents post property listings available for rent (listings are approved by an administrator before they are published), while users search for properties and contact the agent.

## System
- Framework: Laravel 12 (PHP 8.4)
- Database: MySQL

## Installation Guide
- Clone the repository
- Open terminal and run `composer install`
- Run `npm install` and `npm run build` (needed by the forgot password, email verification and profile pages)
- Create an empty database named: `georestate`
- Copy `.env.example` and rename it to `.env`
- Run: `php artisan key:generate`
- Run: `php artisan migrate:fresh --seed`
- Run: `php artisan serve`

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
