<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    protected $users;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
    }

    public function index()
    {
        return view('agen.listing', array(
            'title' => "Dashboard Agency | GeoRestate v.1.0",
            'menuUtama' => 'dataku',
            'menuKedua' => 'listing',
        ));
    }
}
