<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Master\ProvinsiRequest;
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
        return view('admin.district', array(
            'judul' => "Dashboard Administrator | GeoRestate v.1.0",
            'menuUtama' => 'dashboard',
            'menuKedua' => 'dashboard',
        ));
    }

    public function get_provinsi(Request $request)
    {
        if ($request->ajax()) {
            return $this->districtService->get_data_provinsi($request);
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
}
