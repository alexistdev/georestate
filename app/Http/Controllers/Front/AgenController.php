<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AgenController extends Controller
{
    public function index()
    {
        return view('front.agen', array(
            'judul' => "Halaman Agen | GeoRestate v.1.0",
            'menuUtama' => 'agen',
            'menuKedua' => 'agen',
        ));
    }
}
