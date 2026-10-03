<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Halaman ubah password untuk admin & super admin (tampilan panel admin).
 * Penyimpanan memakai route bawaan `password.update` (Auth\PasswordController).
 */
class PasswordController extends Controller
{
    public function edit()
    {
        return view('admin.password', array(
            'judul' => "Ubah Password | GeoRestate v.1.0",
            'menuUtama' => 'password',
            'menuKedua' => 'password',
        ));
    }
}
