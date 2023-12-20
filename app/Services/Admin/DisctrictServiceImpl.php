<?php

namespace App\Services\Admin;

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
                $btn = "<button type=\"button\" class=\"btn btn-sm btn-primary m-1 open-edit-provinsi\" data-id=\"$id\" data-name=\"$row->name\" data-code=\"$row->code\" data-bs-toggle=\"modal\" data-bs-target=\"#editProvinsi\"> <span class=\"icon-off\"><i class=\"mdi mdi-file-document-edit-outline align-middle m-1\" ></i>Edit</span></button>";
                $btn = $btn . "<button class=\"btn btn-sm btn-danger m-1 open-hapus\" data-id=\"$row->id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"> <i class=\"bx bx-trash align-middle m-1\"></i>Hapus</span></button>";
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function save_provinsi(Request $request)
    {
        $insert = new Provinsi();
        $insert->code = $request->code;
        $insert->name = $request->name;
        $insert->save();
    }


    public function update_provinsi(Request $request)
    {
        $provinsi = Provinsi::findOrFail(base64_decode($request->provinsi_id));
        Provinsi::where('id',$provinsi->id)->update([
          'code' => $request->code,
          'name' => $request->name
        ]);
    }


}
