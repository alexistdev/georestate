<?php

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AgentServiceImpl implements AgentService
{
    public function index(Request $request)
    {
        $agent = User::with('hasAgent')->orderBy('isPremium', 'DESC')->where('role_id','3')->get();
        return DataTables::of($agent)
            ->addIndexColumn()
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y H:i:s') ?? "-";
            })
            ->editColumn('phone', function ($request) {
                return $request->hasAgent->phone ?? "-";
            })
            ->editColumn('agentID', function ($request) {
                return $request->hasAgent->member_identifier ?? "-";
            })
            ->editColumn('alamat', function ($request) {
                return $request->hasAgent->alamat ?? "-";
            })
            ->editColumn('isPremium', function ($request) {
                $str = "<span class=\"badge rounded-pill text-bg-primary\">Premium</span>";
                if($request->isPremium != 1){
                    $str = "<span class=\"badge rounded-pill text-bg-success\">Free</span>";
                }
                return $str;
            })
            ->addColumn('action', function ($row) {
//                $url = route('adm.dosen.edit', $row->id);

                $btn = "<a href=\"#\"><button type=\"button\" class=\"btn btn-sm btn-primary m-1\" > <span class=\"icon-off\"><i class=\"mdi mdi-account-eye-outline align-middle m-1\"></i>Detail</span></button></a>";
                $btn = $btn . "<button class=\"btn btn-sm btn-danger m-1 open-hapus\" data-id=\"$row->id\" data-bs-toggle=\"modal\" data-bs-target=\"#modalHapus\"> <i class=\"bx bx-trash align-middle m-1\"></i>Hapus</span></button>";
                return $btn;
            })
            ->rawColumns(['action','isPremium'])
            ->make(true);
    }
}
