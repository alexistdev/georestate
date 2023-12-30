## GeoRestate v.1.0
Aplikasi berbasis web untuk manajemen real estate, seperti : kontrakan, kos-kos an atau apartemen. Aplikasi ini memiliki 3 role: administrator system, agent, dan user. Agent berfungsi sebagai pemasang listing/daftar property yang disewakan dan user adalah pengguna yang akan mencari atau menyewa property.

## System
- Framework Laravel 10.15.0
- Database MySQL

## Panduan Installasi
- Clone Repository
- Buka Terminal dan ketik composer install
- Buat database kosong dengan nama: georestate
- Copy env.example dan rename dengan nama .env
- ketik terminal: php artisan key:generate
- ketik terminal: php artisan migrate:fresh --seed
- ketik terminal: php artisan serve

## Info Login:
#### Administrator:
    - Username: admin@gmail.com
    - Password: 1234
#### Agent: 
    - Username: agent@gmail.com
    - Password: 1234

