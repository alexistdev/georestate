<?php

/**
 * Informasi situs yang tampil di halaman publik (header, footer, halaman Kontak).
 * Nilai kosong tidak ditampilkan.
 */
return [
    'nama' => env('GEORESTATE_NAMA', 'GeoRestate'),
    'tagline' => env('GEORESTATE_TAGLINE', 'Cari kos, kamar, rumah, dan apartemen sewaan dengan mudah'),

    'kontak' => [
        'alamat' => env('GEORESTATE_ALAMAT'),
        'telepon' => env('GEORESTATE_TELEPON'),
        'email' => env('GEORESTATE_EMAIL'),
    ],
];
