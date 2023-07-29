<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('front.about', array(
            'judul' => "Halaman About | GeoRestate v.1.0",
            'menuUtama' => 'about',
            'menuKedua' => 'about',
        ));
    }
}
