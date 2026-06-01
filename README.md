## GeoRestate v.1.0

A web-based application for real estate management, such as boarding houses, rental rooms, or apartments. The application has 3 roles: system administrator, agent, and user. Agents are responsible for posting property listings available for rent, while users are those who search for or rent properties.

## System
- Framework: Laravel 12
- Database: MySQL

## Installation Guide
- Clone the repository
- Open terminal and run `composer install`
- Create an empty database named: `georestate`
- Copy `.env.example` and rename it to `.env`
- Run: `php artisan key:generate`
- Run: `php artisan migrate:fresh --seed`
- Run: `php artisan serve`

## Login Info

#### Administrator
- Username: admin@gmail.com
- Password: 1234

#### Agent
- Username: agent@gmail.com
- Password: 1234
