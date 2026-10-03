<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

/**
 * Pesan dari form Kontak di website.
 */
class PesanController extends Controller
{
    public function index(Request $request)
    {
        $belumDibaca = $request->query('filter') === 'baru';

        $pesan = ContactMessage::when($belumDibaca, fn ($q) => $q->whereNull('read_at'))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.pesan', array(
            'judul' => "Pesan Kontak | GeoRestate v.1.0",
            'menuUtama' => 'pesan',
            'menuKedua' => 'pesan',
            'dataPesan' => $pesan,
            'belumDibaca' => $belumDibaca,
        ));
    }

    public function show(ContactMessage $pesan)
    {
        if ($pesan->read_at === null) {
            $pesan->forceFill(['read_at' => now()])->save();
        }

        return view('admin.showpesan', array(
            'judul' => "Pesan Kontak | GeoRestate v.1.0",
            'menuUtama' => 'pesan',
            'menuKedua' => 'pesan',
            'pesan' => $pesan,
        ));
    }

    public function destroy(ContactMessage $pesan)
    {
        $pesan->delete();

        return redirect(route('adm.pesan'))->with(['delete' => "Pesan berhasil dihapus!"]);
    }
}
