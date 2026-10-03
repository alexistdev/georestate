<?php

namespace App\Http\Requests\Agen;

use App\Models\Property;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;

/**
 * Validasi tambah (POST) & edit (PATCH) listing properti oleh agen.
 */
class PropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (!$this->routeIs('agn.*')) {
            return false;
        }
        return Auth::check();
    }

    public function rules(): array
    {
        $hargaRule = fn (string $kolom) => [
            'nullable', 'integer', 'min:1', 'max:999999999999',
            'required_without_all:'.implode(',', array_diff(array_keys(Property::PERIODE_HARGA), [$kolom])),
        ];

        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'kategori' => 'required|integer|exists:kategoris,id,deleted_at,NULL',
            'lt' => 'required|integer|min:0|max:1000000',
            'lb' => 'required|integer|min:0|max:1000000',
            'kamar_tidur' => 'nullable|integer|min:0|max:99',
            'kamar_mandi' => 'nullable|integer|min:0|max:99',
            'harga_harian' => $hargaRule('harga_harian'),
            'harga_bulanan' => $hargaRule('harga_bulanan'),
            'harga_tahunan' => $hargaRule('harga_tahunan'),
            'fasilitas' => 'nullable|array',
            'fasilitas.*' => 'integer|distinct|exists:fasilitas,id,deleted_at,NULL',
            'kecamatan' => 'required|integer|exists:kecamatans,id,deleted_at,NULL',
            'address' => 'nullable|string|max:255',
            // Titik peta opsional, tetapi lintang & bujur harus diisi berpasangan dan berada di Indonesia.
            'latitude' => ['nullable', 'required_with:longitude', 'numeric', 'between:'.implode(',', Property::BATAS_LINTANG)],
            'longitude' => ['nullable', 'required_with:latitude', 'numeric', 'between:'.implode(',', Property::BATAS_BUJUR)],
            // Foto wajib minimal 1 saat tambah; saat edit opsional (menambah foto).
            'gambar' => [$this->isMethod('POST') ? 'required' : 'nullable', 'array', 'max:'.Property::MAX_GAMBAR],
            'gambar.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    /**
     * Saat edit, total foto lama + foto baru tidak boleh melebihi batas.
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                $property = $this->route('property');
                if (!$property instanceof Property) {
                    return;
                }
                $total = $property->gambars()->count() + count($this->file('gambar', []));
                if ($total > Property::MAX_GAMBAR) {
                    $validator->errors()->add(
                        'gambar',
                        'Maksimal '.Property::MAX_GAMBAR.' foto per listing. Hapus foto lama terlebih dahulu.'
                    );
                }
            },
        ];
    }

    public function messages(): array
    {
        $hargaWajib = "Isi minimal salah satu harga (harian, bulanan, atau tahunan)!";

        return [
            'name.required' => "Nama Listing/Property wajib diisi!",
            'name.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
            'description.max' => "Panjang karakter maksimal yang diperbolehkan adalah 5000 karakter!",
            'kategori.required' => "Wajib dipilih!",
            'kategori.integer' => "Kategori tidak valid!",
            'kategori.exists' => "Kategori sudah tidak tersedia, silahkan pilih kategori lain!",
            'lt.required' => "Wajib diisi!",
            'lt.integer' => "Harus berupa angka !",
            'lb.required' => "Wajib diisi!",
            'lb.integer' => "Harus berupa angka !",
            'kamar_tidur.integer' => "Harus berupa angka !",
            'kamar_tidur.max' => "Maksimal tidak boleh lebih dari 99 !",
            'kamar_mandi.integer' => "Harus berupa angka !",
            'kamar_mandi.max' => "Maksimal tidak boleh lebih dari 99 !",
            'harga_harian.required_without_all' => $hargaWajib,
            'harga_bulanan.required_without_all' => $hargaWajib,
            'harga_tahunan.required_without_all' => $hargaWajib,
            'harga_harian.integer' => "Harus berupa angka !",
            'harga_bulanan.integer' => "Harus berupa angka !",
            'harga_tahunan.integer' => "Harus berupa angka !",
            'harga_harian.min' => "Harga harus lebih dari 0 !",
            'harga_bulanan.min' => "Harga harus lebih dari 0 !",
            'harga_tahunan.min' => "Harga harus lebih dari 0 !",
            'fasilitas.*.exists' => "Fasilitas tidak ditemukan!",
            'kecamatan.required' => "Kecamatan wajib diisi!",
            'kecamatan.integer' => "Kecamatan tidak valid!",
            'kecamatan.exists' => "Kecamatan tidak ditemukan!",
            'address.max' => "Panjang karakter maksimal yang diperbolehkan adalah 255 karakter!",
            'latitude.required_with' => "Titik lokasi tidak lengkap, silahkan pilih ulang di peta!",
            'longitude.required_with' => "Titik lokasi tidak lengkap, silahkan pilih ulang di peta!",
            'latitude.numeric' => "Titik lokasi tidak valid!",
            'longitude.numeric' => "Titik lokasi tidak valid!",
            'latitude.between' => "Titik lokasi harus berada di wilayah Indonesia!",
            'longitude.between' => "Titik lokasi harus berada di wilayah Indonesia!",
            'gambar.required' => "Upload minimal 1 foto properti!",
            'gambar.max' => "Maksimal ".Property::MAX_GAMBAR." foto per listing!",
            'gambar.*.image' => "File harus berupa gambar!",
            'gambar.*.mimes' => "Format foto harus JPG, PNG, atau WebP!",
            'gambar.*.max' => "Ukuran foto maksimal 2 MB!",
        ];
    }
}
