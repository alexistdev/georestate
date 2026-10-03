<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Master\KabupatenRequest;
use App\Http\Requests\Admin\Master\KecamatanRequest;
use App\Http\Requests\Admin\Master\ProvinsiRequest;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Services\Admin\DistrictService;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Master wilayah: provinsi, kabupaten, kecamatan.
 */
class DistrictController extends Controller
{
    public function __construct(private readonly DistrictService $districtService) {}

    public function index()
    {
        return view('admin.district', [
            'judul' => 'Data Wilayah | GeoRestate v.1.0',
            'menuUtama' => 'master',
            'menuKedua' => 'wilayah',
            'dataProvinsi' => Provinsi::orderBy('name')->get(['id', 'name']),
            'dataKabupaten' => Kabupaten::orderBy('name')->get(['id', 'name']),
        ]);
    }

    /** Data tabel (DataTables server-side) */
    public function get_provinsi(Request $request)
    {
        return $this->districtService->get_data_provinsi($request);
    }

    public function get_kabupaten(Request $request)
    {
        return $this->districtService->get_data_kabupaten($request);
    }

    public function get_kecamatan(Request $request)
    {
        return $this->districtService->get_data_kecamatan($request);
    }

    public function provinsi_store(ProvinsiRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->save_provinsi($request), 'Data Provinsi berhasil disimpan!');
    }

    public function provinsi_update(ProvinsiRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->update_provinsi($request), 'Data Provinsi berhasil diperbaharui!');
    }

    public function provinsi_destroy(ProvinsiRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->delete_provinsi($request->integer('provinsi_id')), 'Data Provinsi berhasil dihapus!', 'delete');
    }

    public function kabupaten_store(KabupatenRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->save_kabupaten($request), 'Data Kabupaten berhasil ditambah!');
    }

    public function kabupaten_update(KabupatenRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->update_kabupaten($request), 'Data Kabupaten berhasil diperbaharui!');
    }

    public function kabupaten_destroy(KabupatenRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->delete_kabupaten($request->integer('kabupaten_id')), 'Data Kabupaten berhasil dihapus!', 'delete');
    }

    public function kecamatan_store(KecamatanRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->save_kecamatan($request), 'Data Kecamatan berhasil disimpan!');
    }

    public function kecamatan_update(KecamatanRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->update_kecamatan($request), 'Data Kecamatan berhasil diperbaharui!');
    }

    public function kecamatan_destroy(KecamatanRequest $request)
    {
        return $this->simpan(fn () => $this->districtService->delete_kecamatan($request->integer('kecamatan_id')), 'Data Kecamatan berhasil dihapus!', 'delete');
    }

    /**
     * Jalankan perubahan dalam transaksi lalu kembali ke halaman wilayah.
     */
    private function simpan(Closure $aksi, string $pesan, string $jenis = 'success')
    {
        try {
            DB::transaction($aksi);
        } catch (Exception $e) {
            report($e);

            return redirect(route('adm.wilayah'))->withErrors(['error' => 'Data gagal disimpan, silahkan coba lagi.']);
        }

        return redirect(route('adm.wilayah'))->with([$jenis => $pesan]);
    }
}
