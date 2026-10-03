<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agen\EmailRequest;
use App\Http\Requests\Agen\ProfilRequest;
use App\Models\Agent;
use App\Models\Provinsi;
use App\Services\Agen\ProfilService;
use Illuminate\Support\Facades\Auth;

/**
 * Profil Saya: data diri, wilayah, foto, email, dan password agen.
 */
class ProfilController extends Controller
{
    public function __construct(private readonly ProfilService $profilService)
    {
    }

    public function edit()
    {
        $agent = $this->agent();
        $agent->load('kecamatan');

        return view('agen.profil', array(
            'title' => "Profil Saya | GeoRestate v.1.0",
            'menuUtama' => 'profil',
            'menuKedua' => 'profil',
            'agent' => $agent,
            'dataProvinsi' => Provinsi::orderBy('name')->get(),
        ));
    }

    public function update(ProfilRequest $request)
    {
        $this->profilService->simpan($this->agent(), $request->safe()->except('foto'), $request->file('foto'));

        return redirect(route('agn.profil'))->with(['success' => "Profil berhasil disimpan."]);
    }

    public function updateEmail(EmailRequest $request)
    {
        $request->user()->update(['email' => $request->validated('email')]);

        return redirect(route('agn.profil').'#ganti-email')->with(['success' => "Email login berhasil diubah."]);
    }

    private function agent(): Agent
    {
        $agent = Auth::user()->hasAgent;
        abort_if($agent === null, 403, 'Data agen tidak ditemukan. Silahkan hubungi administrator.');

        return $agent;
    }
}
