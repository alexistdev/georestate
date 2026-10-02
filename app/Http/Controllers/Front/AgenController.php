<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use Illuminate\Database\Eloquent\Builder;

class AgenController extends Controller
{
    public function index()
    {
        $agents = Agent::aktif()
            ->whereHas('hasUser')
            ->with('hasUser', 'kecamatan')
            ->withCount(['properties' => fn (Builder $q) => $q->publik()])
            ->orderByDesc('properties_count')
            ->paginate(10);

        return view('front.agen', array(
            'judul' => "Halaman Agen | GeoRestate v.1.0",
            'menuUtama' => 'agen',
            'menuKedua' => 'agen',
            'dataAgents' => $agents,
        ));
    }

    public function show(Agent $agent)
    {
        abort_if($agent->isSuspend || $agent->hasUser === null, 404);
        $agent->load('kecamatan');

        $properties = $agent->properties()
            ->publik()
            ->with('kecamatan', 'kategori', 'gambarUtama')
            ->latest('approved_at')
            ->paginate(9);

        return view('front.detailagen', array(
            'judul' => $agent->hasUser->name." | GeoRestate v.1.0",
            'menuUtama' => 'agen',
            'menuKedua' => 'agen',
            'agent' => $agent,
            'dataProperties' => $properties,
        ));
    }
}
