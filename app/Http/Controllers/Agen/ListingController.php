<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agen\PropertyRequest;
use App\Models\Kabupaten;
use App\Models\Kategori;
use App\Models\Kecamatan;
use App\Models\Property;
use App\Models\Provinsi;
use App\Services\Agen\PropertyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    protected $users;
    protected PropertyService $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->propertyService = $propertyService;
    }

    public function index()
    {

        return  $listProperties = Property::select('id','kecamatan_id')->with('kecamatan')->get();
        return view('agen.listing', array(
            'title' => "Dashboard Agency | GeoRestate v.1.0",
            'menuUtama' => 'dataku',
            'menuKedua' => 'listing',
            'dataList' => $listProperties
        ));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('name','ASC')->get();
        $provinsi = Provinsi::orderBy('name', 'ASC')->get();
        return view('agen.addlisting', array(
            'title' => "Dashboard Agency | GeoRestate v.1.0",
            'menuUtama' => 'dataku',
            'menuKedua' => 'listing',
            'dataProvinsi' => $provinsi,
            'dataKategori' => $kategori,
        ));
    }

    public function getKabupaten($provinsi_id = null)
    {
        if ($provinsi_id != null) {
            $provId = base64_decode($provinsi_id);
            $provinsi = Provinsi::findOrFail($provId);
            $result = Kabupaten::where('provinsi_id', $provinsi->id)->orderBy('name', 'ASC')->get();
            return response()->json($result);
        }
        abort('404', 'NOT FOUND');
    }

    public function getKecamatan($kabupaten_id = null)
    {
        if ($kabupaten_id != null) {
            $kabId = base64_decode($kabupaten_id);
            $kabupaten = Kabupaten::findOrFail($kabId);
            $result = Kecamatan::where('kabupaten_id', base64_decode($kabupaten->id))->orderBy('name', 'ASC')->get();
            return response()->json($result);
        }
        abort('404', 'NOT FOUND');
    }

    public function store(PropertyRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->propertyService->save($request);
            DB::commit();
            return redirect(route('agn.lists'))->with(['success' => "Data Property berhasil ditambahkan!"]);
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
//            return redirect(route('agn.lists'))->withErrors(['error' => $e->getMessage()]);
        }
    }
}
