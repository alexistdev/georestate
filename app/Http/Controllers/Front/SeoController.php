<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Property;
use Illuminate\Http\Response;

/**
 * sitemap.xml & robots.txt untuk mesin pencari.
 */
class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $halaman = collect([
            ['loc' => route('front.home'), 'lastmod' => null],
            ['loc' => route('front.properties'), 'lastmod' => null],
            ['loc' => route('front.agents'), 'lastmod' => null],
            ['loc' => route('front.about'), 'lastmod' => null],
            ['loc' => route('front.contact'), 'lastmod' => null],
        ]);

        $properti = Property::publik()->select('slug', 'updated_at')->latest('updated_at')->limit(5000)->get()
            ->map(fn ($p) => ['loc' => route('front.properties.detail', $p->slug), 'lastmod' => $p->updated_at]);

        $agen = Agent::aktif()->whereHas('hasUser')->select('id', 'updated_at')->get()
            ->map(fn ($a) => ['loc' => route('front.agents.detail', $a), 'lastmod' => $a->updated_at]);

        return response()
            ->view('front.sitemap', ['urls' => $halaman->concat($properti)->concat($agen)])
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }

    public function robots(): Response
    {
        $isi = implode("\n", [
            'User-agent: *',
            'Disallow: /staff/',
            'Disallow: /super/',
            'Disallow: /agent/',
            'Disallow: /akun/',
            'Disallow: /login',
            'Disallow: /register',
            'Sitemap: '.route('front.sitemap'),
            '',
        ]);

        return response($isi)->header('Content-Type', 'text/plain; charset=UTF-8');
    }
}
