<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact', array(
            'judul' => "Halaman Contact | GeoRestate v.1.0",
            'menuUtama' => 'contact',
            'menuKedua' => 'contact',
        ));
    }
}
