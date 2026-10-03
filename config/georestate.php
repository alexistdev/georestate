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

    /*
     * Peta lokasi (Leaflet). Default memakai tile OpenStreetMap; untuk trafik besar
     * ganti ke penyedia tile lain (lihat https://operations.osmfoundation.org/policies/tiles/).
     */
    'peta' => [
        'tile_url' => env('GEORESTATE_PETA_TILE_URL', 'https://tile.openstreetmap.org/{z}/{x}/{y}.png'),
        'atribusi' => env('GEORESTATE_PETA_ATRIBUSI', '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'),
        // Pusat & zoom awal saat titik belum dipilih (Indonesia).
        'pusat' => [-2.5, 118.0],
        'zoom' => 5,
    ],
];
