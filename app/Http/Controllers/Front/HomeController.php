<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Kategori;
use App\Models\Property;
use App\Models\Provinsi;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{
    public function index()
    {
        $terbaru = Property::publik()
            ->with('kecamatan', 'kategori', 'gambarUtama')
            ->latest('approved_at')
            ->limit(6)
            ->get();

        $kategori = Kategori::withCount(['properties' => fn (Builder $q) => $q->publik()])
            ->orderBy('name')
            ->get();

        $agents = Agent::aktif()->with('hasUser')->inRandomOrder()->limit(5)->get();

        return view('front.home', array(
            'judul' => "Halaman Home | GeoRestate v.1.0",
            'menuUtama' => 'home',
            'menuKedua' => 'home',
            'dataTerbaru' => $terbaru,
            'dataKategori' => $kategori,
            'dataProvinsi' => Provinsi::orderBy('name')->get(),
            'dataAgents' => $agents,
            'totalListing' => Property::publik()->count(),
        ));
    }
}
