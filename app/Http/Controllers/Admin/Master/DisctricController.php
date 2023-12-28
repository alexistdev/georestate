<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Master\KabupatenRequest;
use App\Http\Requests\Admin\Master\ProvinsiRequest;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use Exception;
use App\Services\Admin\DistrictService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DisctricController extends Controller
{
    protected $users;
    protected DistrictService $districtService;

    public function __construct(DistrictService $districtService)
    {
        $this->middleware(function ($request, $next) {
            $this->users = Auth::user();
            return $next($request);
        });
        $this->districtService = $districtService;
    }

    public function index()
    {
        $provinsi = Provinsi::orderBy('name','ASC')->get();
        return view('admin.district', array(
            'judul' => "Dashboard Administrator | GeoRestate v.1.0",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
            'dataProvinsi' => $provinsi
        ));
    }

    public function get_provinsi(Request $request)
    {
        if ($request->ajax()) {
            return $this->districtService->get_data_provinsi($request);
        }
        return null;
    }

    public function get_kabupaten(Request $request)
    {
        if ($request->ajax()) {
            return $this->districtService->get_data_kabupaten($request);
        }
        return null;
    }

    public function provinsi_store(ProvinsiRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->districtService->save_provinsi($request);
            DB::commit();
            return redirect(route('adm.disctrict'))->with(['success' => "Data Provinsi berhasil diperbaharui!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.disctrict'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function provinsi_update(ProvinsiRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->districtService->update_provinsi($request);
            DB::commit();
            return redirect(route('adm.disctrict'))->with(['success' => "Data Provinsi berhasil diperbaharui!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.disctrict'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function provinsi_destroy(ProvinsiRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $id = base64_decode($request->provinsi_id);
            $this->districtService->delete_provinsi($id);
            DB::commit();
            return redirect(route('adm.disctrict'))->with(['delete' => "Data Provinsi berhasil dihapus!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.disctrict'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function kabupaten_store(KabupatenRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->districtService->save_kabupaten($request);
            DB::commit();
            return redirect(route('adm.disctrict'))->with(['success' => "Data Kabupaten berhasil ditambah!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.disctrict'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function kabupaten_update(KabupatenRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $this->districtService->update_kabupaten($request);
            DB::commit();
            return redirect(route('adm.disctrict'))->with(['success' => "Data Kabupaten berhasil diperbaharui!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.disctrict'))->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function kabupaten_destroy(KabupatenRequest $request)
    {
        $request->validated();
        DB::beginTransaction();
        try {
            $id = base64_decode($request->kabupaten_id);
            $this->districtService->delete_kabupaten($id);
            DB::commit();
            return redirect(route('adm.disctrict'))->with(['delete' => "Data Kabupaten berhasil dihapus!"]);
        } catch (Exception $e) {
            DB::rollback();
            return redirect(route('adm.disctrict'))->withErrors(['error' => $e->getMessage()]);
        }
    }
}
