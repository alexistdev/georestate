<?php

namespace App\Services\Admin;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DisctrictServiceImpl implements DistrictService
{
    public function get_data_provinsi(Request $request)
    {
        $province = Provinsi::orderBy('id','DESC')->orderBy('name', 'ASC')->get();
        return DataTables::of($province)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y H:i:s') ?? "-";
            })
            ->addColumn('action', function ($row) {
                $id = base64_encode($row->id);
                $btn = "<button type=\"button\" class=\"btn btn-sm btn-primary m-1 open-edit-provinsi\" data-id=\"$id\" data-name=\"$row->name\" data-bs-toggle=\"modal\" data-bs-target=\"#editProvinsi\"> <span class=\"icon-off\"><i class=\"mdi mdi-file-document-edit-outline align-middle m-1\" ></i></span></button>";
                $btn = $btn . "<button class=\"btn btn-sm btn-danger m-1 open-hapus-provinsi\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"> <i class=\"bx bx-trash align-middle m-1\"></i></span></button>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save_provinsi(Request $request)
    {
        $insert = new Provinsi();
        $insert->name = $request->name;
        $insert->save();
    }


    public function update_provinsi(Request $request)
    {
        $provinsi = Provinsi::findOrFail(base64_decode($request->provinsi_id));
        Provinsi::where('id',$provinsi->id)->update([
          'name' => $request->name
        ]);
    }

    public function delete_provinsi(int $id)
    {
        $provinsi = Provinsi::findOrFail($id);
        $provinsi->delete();
    }

    public function get_data_kabupaten(Request $request)
    {
        $kabupaten = Kabupaten::with('provinsi')->orderBy('provinsi_id','DESC')->orderBy('name', 'ASC')->get();
        return DataTables::of($kabupaten)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y H:i:s') ?? "-";
            })
            ->editColumn('provinsi', function ($request) {
                return $request->provinsi->name ?? "-";
            })
            ->addColumn('action', function ($row) {
                $id = base64_encode($row->id);
                $prov_id = base64_encode($row->provinsi_id);
                $btn = "<button type=\"button\" class=\"btn btn-sm btn-primary m-1 open-edit-kabupaten\" data-id=\"$id\" data-provinsi=\"$prov_id\" data-name=\"$row->name\" data-bs-toggle=\"modal\" data-bs-target=\"#editKabupaten\"> <span class=\"icon-off\"><i class=\"mdi mdi-file-document-edit-outline align-middle m-1\" ></i></span></button>";
                $btn = $btn."<button class=\"btn btn-sm btn-danger m-1 open-hapus-kabupaten\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapusKabupaten\"> <i class=\"bx bx-trash align-middle m-1\"></i></span></button>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save_kabupaten(Request $request)
    {
        $provinsi = Provinsi::findOrFail(base64_decode($request->provinsi_id));
        $idProvinsi = $provinsi->id;
        $kabupaten = new Kabupaten();
        $kabupaten->provinsi_id = $idProvinsi;
        $kabupaten->name = $request->name;
        $kabupaten->save();
    }

    public function update_kabupaten(Request $request)
    {
        $kabupaten = Kabupaten::findOrFail(base64_decode($request->kabupaten_id));
        $provinsi = Provinsi::findOrFail(base64_decode($request->provinsi_id));
        Kabupaten::where('id',$kabupaten->id)->update([
            'provinsi_id' => $provinsi->id,
            'name' => $request->name
        ]);
    }

    public function delete_kabupaten(int $id)
    {
        $kabupaten = Kabupaten::findOrFail($id);
        $kabupaten->delete();
    }

    public function get_data_kecamatan(Request $request)
    {
        $kecamatan = Kecamatan::with('kabupaten')->orderBy('kabupaten_id','DESC')->orderBy('name', 'ASC')->get();
        return DataTables::of($kecamatan)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y H:i:s') ?? "-";
            })
            ->editColumn('kabupaten', function ($request) {
                return $request->kabupaten->name ?? "-";
            })
            ->addColumn('action', function ($row) {
                $id = base64_encode($row->id);
                $kab_id = base64_encode($row->kabupaten_id);
                $btn = "<button type=\"button\" class=\"btn btn-sm btn-primary m-1 open-edit-kabupaten\" data-id=\"$id\" data-provinsi=\"$kab_id\" data-name=\"$row->name\" data-bs-toggle=\"modal\" data-bs-target=\"#editKabupaten\"> <span class=\"icon-off\"><i class=\"mdi mdi-file-document-edit-outline align-middle m-1\" ></i></span></button>";
                $btn = $btn."<button class=\"btn btn-sm btn-danger m-1 open-hapus-kabupaten\" data-id=\"$id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapusKabupaten\"> <i class=\"bx bx-trash align-middle m-1\"></i></span></button>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


}
