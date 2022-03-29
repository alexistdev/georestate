<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * GeoRestate v.2.0
     * Date: 29-03-2022
     * Author:AlexisDev
     * Email: alexistdev@gmail.com
     * Phone: 0823-7140-8678
     */

    protected $users;
    protected $role;
    protected $notif;

//    public function __construct()
//    {
//        $this->middleware(function ($request, $next) {
//            $this->users = Auth::user();
////            $this->role = User::with('role')->find($this->users->id)->role;
//            return $next($request);
//        });
//    }

    public function index()
    {

        return view('frontend.home', array(
            'judul' => "GeoRestate",
            'aktifTag' => "master",
            'tagSubMenu' => "city",
//            'userName' => $this->users,
//            'roleUser' => $this->role->name,
        ));
    }
}
