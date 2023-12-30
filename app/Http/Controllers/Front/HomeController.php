<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Agent;

class HomeController extends Controller
{
    public function index()
    {
        $agents = Agent::with('hasUser')->inRandomOrder()->limit(5)->get();
        return view('front.home', array(
            'judul' => "Halaman Home | GeoRestate v.1.0",
            'menuUtama' => 'home',
            'menuKedua' => 'home',
            'dataAgents' => $agents,
        ));
    }
}
