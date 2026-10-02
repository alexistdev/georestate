<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('super.dashboard', array(
            'judul' => "Dashboard Super Administrator | GeoRestate v.1.0",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
        ));
    }
}
