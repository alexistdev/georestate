<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
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

    public function create()
    {
        $provinsi = Provinsi::orderBy('name', 'ASC')->get();
        return view('agen.addlisting', array(
            'title' => "Dashboard Agency | GeoRestate v.1.0",
            'menuUtama' => 'dataku',
            'menuKedua' => 'listing',
            'dataProvinsi' => $provinsi
        ));
    }

    public function getKabupaten($provinsi_id = null)
    {
        if ($provinsi_id != null) {
            $provId = base64_decode($provinsi_id);
            $provinsi = Provinsi::findOrFail($provId);
            $result = Kabupaten::where('provinsi_id', $provinsi->id)->orderBy('name', 'ASC')->get();
            return response()->json($result);
        }
        abort('404', 'NOT FOUND');
    }

    public function getKecamatan($kabupaten_id = null)
    {
        if ($kabupaten_id != null) {
            $kabId = base64_decode($kabupaten_id);
            $kabupaten = Kabupaten::findOrFail($kabId);
            $result = Kecamatan::where('kabupaten_id', base64_decode($kabupaten->id))->orderBy('name', 'ASC')->get();
            return response()->json($result);
        }
        abort('404', 'NOT FOUND');
    }
}
