<?php

namespace App\Services\Admin;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DistrictServiceImpl implements DistrictService
{
    public function get_data_provinsi(Request $request)
    {
        return DataTables::of(Provinsi::query()->select(['id', 'name']))
            ->addIndexColumn()
            ->addColumn('action', fn (Provinsi $row) => $this->tombol('provinsi', 'editProvinsi', 'modalHapus', $row))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function save_provinsi(Request $request)
    {
        Provinsi::create(['name' => $request->name]);
    }

    public function update_provinsi(Request $request)
    {
        Provinsi::findOrFail($request->integer('provinsi_id'))->update(['name' => $request->name]);
    }

    public function delete_provinsi(int $id)
    {
        Provinsi::findOrFail($id)->delete();
    }

    public function get_data_kabupaten(Request $request)
    {
        return DataTables::of(Kabupaten::query()->with('provinsi')->select('kabupatens.*'))
            ->addIndexColumn()
            ->addColumn('action', fn (Kabupaten $row) => $this->tombol('kabupaten', 'editKabupaten', 'modalHapusKabupaten', $row, ['provinsi' => $row->provinsi_id]))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function save_kabupaten(Request $request)
    {
        Kabupaten::create([
            'provinsi_id' => $request->integer('provinsi_id'),
            'name' => $request->name,
        ]);
    }

    public function update_kabupaten(Request $request)
    {
        Kabupaten::findOrFail($request->integer('kabupaten_id'))->update([
            'provinsi_id' => $request->integer('provinsi_id'),
            'name' => $request->name,
        ]);
    }

    public function delete_kabupaten(int $id)
    {
        Kabupaten::findOrFail($id)->delete();
    }

    public function get_data_kecamatan(Request $request)
    {
        return DataTables::of(Kecamatan::query()->with('kabupaten')->select('kecamatans.*'))
            ->addIndexColumn()
            ->addColumn('action', fn (Kecamatan $row) => $this->tombol('kecamatan', 'editKecamatan', 'modalHapusKecamatan', $row, ['kabupaten' => $row->kabupaten_id]))
            ->rawColumns(['action'])
            ->toJson();
    }

    public function save_kecamatan(Request $request)
    {
        Kecamatan::create([
            'kabupaten_id' => $request->integer('kabupaten_id'),
            'name' => $request->name,
        ]);
    }

    public function update_kecamatan(Request $request)
    {
        Kecamatan::findOrFail($request->integer('kecamatan_id'))->update([
            'kabupaten_id' => $request->integer('kabupaten_id'),
            'name' => $request->name,
        ]);
    }

    public function delete_kecamatan(int $id)
    {
        Kecamatan::findOrFail($id)->delete();
    }

    /**
     * Tombol edit & hapus di kolom aksi. $data berisi atribut data-* tambahan untuk form edit.
     */
    private function tombol(string $jenis, string $modalEdit, string $modalHapus, $row, array $data = []): string
    {
        $atribut = '';
        foreach ($data as $kunci => $nilai) {
            $atribut .= ' data-'.$kunci.'="'.e($nilai).'"';
        }

        return '<button type="button" class="btn btn-sm btn-primary m-1 open-edit-'.$jenis.'" data-id="'.e($row->id).'"'.$atribut
            .' data-name="'.e($row->name).'" data-bs-toggle="modal" data-bs-target="#'.$modalEdit.'" title="Ubah">'
            .'<i class="mdi mdi-file-document-edit-outline align-middle"></i></button>'
            .'<button type="button" class="btn btn-sm btn-danger m-1 open-hapus-'.$jenis.'" data-id="'.e($row->id).'"'
            .' data-bs-toggle="modal" data-bs-target="#'.$modalHapus.'" title="Hapus">'
            .'<i class="bx bx-trash align-middle"></i></button>';
    }
}
