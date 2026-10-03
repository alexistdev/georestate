<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\InquiryRequest;
use App\Models\Inquiry;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;

/**
 * Form "Tanya Agen" di halaman detail properti (boleh tanpa login).
 */
class InquiryController extends Controller
{
    public function store(InquiryRequest $request, string $slug)
    {
        $property = Property::publik()->where('slug', $slug)->firstOrFail();

        Inquiry::create([
            ...$request->safe()->except('website'),
            'property_id' => $property->id,
            'agent_id' => $property->agent_id,
            'user_id' => Auth::id(),
        ]);

        return redirect(route('front.properties.detail', $slug).'#tanya-agen')
            ->with(['inquiry_success' => "Pertanyaan Anda sudah terkirim ke agen. Agen akan segera menghubungi Anda."]);
    }
}
