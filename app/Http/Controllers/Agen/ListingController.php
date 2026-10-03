<?php

namespace App\Http\Controllers\Agen;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agen\PropertyRequest;
use App\Models\Agent;
use App\Models\Fasilitas;
use App\Models\Gambar;
use App\Models\Kategori;
use App\Models\Property;
use App\Models\Provinsi;
use App\Services\Agen\PropertyService;
use Exception;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    protected PropertyService $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService;
    }

    public function index()
    {
        $listProperties = $this->agent()->properties()
            ->with('kecamatan', 'kategori', 'gambarUtama')
            ->latest()
            ->paginate(10);

        return view('agen.listing', array(
            'title' => "Dashboard Agency | GeoRestate v.1.0",
            'menuUtama' => 'dataku',
            'menuKedua' => 'listing',
            'dataList' => $listProperties
        ));
    }

    public function create()
    {
        $this->agent();

        return view('agen.addlisting', array_merge($this->formData(), [
            'title' => "Tambah Listing | GeoRestate v.1.0",
            'menuUtama' => 'dataku',
            'menuKedua' => 'listing',
        ]));
    }

    public function store(PropertyRequest $request)
    {
        try {
            $property = $this->propertyService->save(
                $this->agent(),
                $request->validated(),
                $request->file('gambar', [])
            );
        } catch (Exception $e) {
            report($e);
            return redirect(route('agn.lists.add'))->withInput()
                ->withErrors(['error' => "Data Property gagal disimpan, silahkan coba lagi."]);
        }

        return redirect(route('agn.lists.show', $property))
            ->with(['success' => "Listing berhasil ditambahkan dan menunggu persetujuan admin."]);
    }

    public function show(Property $property)
    {
        $this->authorize('view', $property);
        $property->load('kecamatan', 'kategori', 'fasilitas', 'gambars');

        return view('agen.showlisting', array(
            'title' => "Detail Listing | GeoRestate v.1.0",
            'menuUtama' => 'dataku',
            'menuKedua' => 'listing',
            'property' => $property,
        ));
    }

    public function edit(Property $property)
    {
        $this->authorize('update', $property);
        $property->load('kecamatan', 'fasilitas', 'gambars');

        return view('agen.editlisting', array_merge($this->formData(), [
            'title' => "Edit Listing | GeoRestate v.1.0",
            'menuUtama' => 'dataku',
            'menuKedua' => 'listing',
            'property' => $property,
        ]));
    }

    public function update(PropertyRequest $request, Property $property)
    {
        $this->authorize('update', $property);

        try {
            $this->propertyService->update($property, $request->validated(), $request->file('gambar', []));
        } catch (Exception $e) {
            report($e);
            return redirect(route('agn.lists.edit', $property))->withInput()
                ->withErrors(['error' => "Data Property gagal disimpan, silahkan coba lagi."]);
        }

        return redirect(route('agn.lists.show', $property))
            ->with(['success' => "Listing berhasil diperbaharui dan menunggu persetujuan ulang admin."]);
    }

    public function destroy(Property $property)
    {
        $this->authorize('delete', $property);
        $this->propertyService->delete($property);

        return redirect(route('agn.lists'))->with(['delete' => "Listing berhasil dihapus!"]);
    }

    public function destroyGambar(Property $property, Gambar $gambar)
    {
        $this->authorize('update', $property);
        abort_unless($gambar->property_id === $property->id, 404);

        if ($property->gambars()->count() <= 1) {
            return back()->withErrors(['foto' => "Listing harus memiliki minimal 1 foto."]);
        }

        $this->propertyService->deleteGambar($gambar);

        return back()->with(['success' => "Foto berhasil dihapus."]);
    }

    public function setGambarUtama(Property $property, Gambar $gambar)
    {
        $this->authorize('update', $property);
        abort_unless($gambar->property_id === $property->id, 404);

        $this->propertyService->setGambarUtama($gambar);

        return back()->with(['success' => "Foto utama berhasil diubah."]);
    }

    /**
     * Data agen milik user yang login.
     */
    private function agent(): Agent
    {
        $agent = Auth::user()->hasAgent;
        abort_if($agent === null, 403, 'Data agen tidak ditemukan. Silahkan hubungi administrator.');

        return $agent;
    }

    /**
     * Data pilihan untuk form tambah/edit listing.
     */
    private function formData(): array
    {
        return [
            'dataProvinsi' => Provinsi::orderBy('name', 'ASC')->get(),
            'dataKategori' => Kategori::orderBy('name', 'ASC')->get(),
            'dataFasilitas' => Fasilitas::orderBy('name', 'ASC')->get(),
        ];
    }
}
