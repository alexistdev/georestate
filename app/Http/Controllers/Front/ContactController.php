<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ContactRequest;
use App\Models\ContactMessage;

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

    public function store(ContactRequest $request)
    {
        ContactMessage::create($request->safe()->except('website'));

        return redirect(route('front.contact'))
            ->with(['success' => "Terima kasih, pesan Anda sudah kami terima. Kami akan segera menghubungi Anda."]);
    }
}
