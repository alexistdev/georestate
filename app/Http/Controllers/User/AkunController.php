<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Area akun pencari properti: favorit, riwayat pertanyaan, ubah password.
 */
class AkunController extends Controller
{
    public function favorit(Request $request)
    {
        // Hanya yang masih tayang (listing yang diturunkan / agen disuspend disembunyikan).
        $properties = $request->user()->favorit()
            ->publik()
            ->with('kecamatan', 'kategori', 'gambarUtama')
            ->latest('favorites.created_at')
            ->paginate(12);

        return view('front.akun.favorit', array(
            'judul' => "Favorit Saya | GeoRestate v.1.0",
            'menuUtama' => 'akun',
            'menuKedua' => 'favorit',
            'dataProperties' => $properties,
        ));
    }

    public function pertanyaan(Request $request)
    {
        $pertanyaan = $request->user()->inquiries()
            ->with('property', 'agent.hasUser')
            ->latest()
            ->paginate(15);

        return view('front.akun.pertanyaan', array(
            'judul' => "Riwayat Pertanyaan | GeoRestate v.1.0",
            'menuUtama' => 'akun',
            'menuKedua' => 'pertanyaan',
            'dataPertanyaan' => $pertanyaan,
        ));
    }

    public function password()
    {
        return view('front.akun.password', array(
            'judul' => "Ubah Password | GeoRestate v.1.0",
            'menuUtama' => 'akun',
            'menuKedua' => 'password',
        ));
    }
}
