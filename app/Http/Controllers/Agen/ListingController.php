<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agen\PropertyRequest;
use App\Models\Agent;
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
    protected $agentId;
    protected PropertyService $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            $this->agentId = Agent::where('user_id',$this->users->id)->first()->id ?? null;
            return $next($request);
        });
        $this->propertyService = $propertyService;
    }

    public function index()
    {

        $listProperties = Property::select('id','name','kecamatan_id','kategori_id','address','description','beds','baths','lb','lt','price','isPremium','isStatus','isPremium_expired','created_at')
                            ->with('kecamatan','kategori')->orderBy('isStatus','ASC')->where('agent_id',$this->agentId)->paginate(2);
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
            $result = Kabupaten::where('provinsi_id', $provinsi->id)->orderBy('name', 'ASC')
                ->get();
            return response()->json($result);
        }
        abort('404', 'NOT FOUND');
    }

    public function getKecamatan($kabupaten_id = null)
    {
        if ($kabupaten_id != null) {
            $kabupaten = Kabupaten::findOrFail($kabupaten_id);
            $result = Kecamatan::where('kabupaten_id', $kabupaten->id)->orderBy('name', 'ASC')->get();
            return response()->json($result);
        }
        abort('404', 'NOT FOUND');
    }

    public function store(PropertyRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->propertyService->save($request,$this->agentId);
            DB::commit();
            return redirect(route('agn.lists'))->with(['success' => "Data Property berhasil ditambahkan!"]);
        } catch (Exception $e) {
            DB::rollback();
            echo $e->getMessage();
//            return redirect(route('agn.lists'))->withErrors(['error' => $e->getMessage()]);
        }
    }
}
