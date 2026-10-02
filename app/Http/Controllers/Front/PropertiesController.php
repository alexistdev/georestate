<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kategori;
use App\Models\Kecamatan;
use App\Models\Property;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PropertiesController extends Controller
{
    public const PERIODE = ['harian' => 'Harian', 'bulanan' => 'Bulanan', 'tahunan' => 'Tahunan'];
    public const URUTAN = ['terbaru' => 'Terbaru', 'termurah' => 'Harga Termurah', 'termahal' => 'Harga Termahal'];

    public function index(Request $request)
    {
        $filter = $this->filter($request);

        $properties = Property::publik()
            ->filter($filter)
            ->with('kecamatan', 'kategori', 'gambarUtama')
            ->paginate(12)
            ->withQueryString();

        return view('front.properties', array(
            'judul' => "Cari Properti | GeoRestate v.1.0",
            'menuUtama' => 'properties',
            'menuKedua' => 'properties',
            'dataProperties' => $properties,
            'filter' => $filter,
            'dataKategori' => Kategori::orderBy('name')->get(),
            'dataProvinsi' => Provinsi::orderBy('name')->get(),
            'dataKabupaten' => isset($filter['provinsi'])
                ? Kabupaten::where('provinsi_id', $filter['provinsi'])->orderBy('name')->get()
                : collect(),
            'dataKecamatan' => isset($filter['kabupaten'])
                ? Kecamatan::where('kabupaten_id', $filter['kabupaten'])->orderBy('name')->get()
                : collect(),
        ));
    }

    public function show(string $slug)
    {
        $property = Property::publik()
            ->where('slug', $slug)
            ->with('kecamatan', 'kategori', 'fasilitas', 'gambars', 'agent.hasUser')
            ->firstOrFail();

        $serupa = Property::publik()
            ->whereKeyNot($property->id)
            ->where(function ($q) use ($property) {
                $q->where('kategori_id', $property->kategori_id)
                    ->orWhereIn('kecamatan_id', Kecamatan::select('id')->where('kabupaten_id', $property->kecamatan?->kabupaten_id));
            })
            ->with('kecamatan', 'kategori', 'gambarUtama')
            ->latest('approved_at')
            ->limit(3)
            ->get();

        return view('front.detailproperties', array(
            'judul' => $property->name." | GeoRestate v.1.0",
            'menuUtama' => 'properties',
            'menuKedua' => 'properties',
            'property' => $property,
            'dataSerupa' => $serupa,
        ));
    }

    /**
     * Data kabupaten untuk dropdown filter (AJAX).
     */
    public function kabupaten(Provinsi $provinsi)
    {
        return response()->json(
            Kabupaten::where('provinsi_id', $provinsi->id)->orderBy('name')->get(['id', 'name'])
        );
    }

    /**
     * Data kecamatan untuk dropdown filter (AJAX).
     */
    public function kecamatan(Kabupaten $kabupaten)
    {
        return response()->json(
            Kecamatan::where('kabupaten_id', $kabupaten->id)->orderBy('name')->get(['id', 'name'])
        );
    }

    /**
     * Ambil filter dari query string; nilai yang tidak valid diabaikan.
     */
    private function filter(Request $request): array
    {
        $angka = function (string $key) use ($request): ?int {
            $nilai = filter_var($request->query($key), FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
            return $nilai === false ? null : $nilai;
        };
        $pilihan = function (string $key, array $boleh) use ($request): ?string {
            $nilai = $request->query($key);
            return is_string($nilai) && array_key_exists($nilai, $boleh) ? $nilai : null;
        };
        $kata = $request->query('q');

        return array_filter([
            'q' => is_string($kata) && trim($kata) !== '' ? Str::limit(trim($kata), 100, '') : null,
            'kategori' => $angka('kategori'),
            'provinsi' => $angka('provinsi'),
            'kabupaten' => $angka('kabupaten'),
            'kecamatan' => $angka('kecamatan'),
            'periode' => $pilihan('periode', self::PERIODE),
            'harga_min' => $angka('harga_min'),
            'harga_max' => $angka('harga_max'),
            'kamar' => $angka('kamar'),
            'urut' => $pilihan('urut', self::URUTAN),
        ], fn ($nilai) => $nilai !== null);
    }
}
