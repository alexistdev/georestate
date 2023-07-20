<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    public function index()
    {
        return view('front.properties', array(
            'judul' => "Halaman Properties | GeoRestate v.1.0",
            'menuUtama' => 'properties',
            'menuKedua' => 'properties',
        ));
    }
}
