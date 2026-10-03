<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\Request;

/**
 * Favorit pencari properti (wajib login).
 */
class FavoritController extends Controller
{
    /**
     * Tambah / hapus properti dari favorit.
     */
    public function toggle(Request $request, string $slug)
    {
        $property = Property::publik()->where('slug', $slug)->firstOrFail();
        $hasil = $request->user()->favorit()->toggle($property->id);
        $ditambah = $hasil['attached'] !== [];

        return back()->with(['favorit_success' => $ditambah
            ? "\"{$property->name}\" disimpan ke Favorit Saya."
            : "\"{$property->name}\" dihapus dari Favorit Saya."]);
    }

    /**
     * Tamu yang menekan ❤: arahkan ke login, lalu kembali ke halaman properti.
     */
    public function masuk(string $slug)
    {
        Property::publik()->where('slug', $slug)->firstOrFail();
        session()->put('url.intended', route('front.properties.detail', $slug));

        return redirect()->route('login')
            ->with(['status' => 'Silakan masuk atau daftar sebagai pencari properti untuk menyimpan favorit.']);
    }
}
