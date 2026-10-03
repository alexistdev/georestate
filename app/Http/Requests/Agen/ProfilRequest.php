<?php

namespace App\Http\Requests\Agen;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * Validasi ubah profil agen (data diri, wilayah, foto).
 */
class ProfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->routeIs('agn.*') && Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'phone' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-]{8,20}$/'],
            'alamat' => 'nullable|string|max:255',
            'kecamatan' => 'nullable|integer|exists:kecamatans,id,deleted_at,NULL',
            'about' => 'nullable|string|max:2000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Nama wajib diisi!",
            'name.max' => "Nama maksimal 100 karakter!",
            'phone.required' => "Nomor telepon/WhatsApp wajib diisi agar calon penyewa bisa menghubungi Anda!",
            'phone.regex' => "Nomor telepon tidak valid. Contoh: 081234567890",
            'phone.max' => "Nomor telepon maksimal 20 karakter!",
            'alamat.max' => "Alamat maksimal 255 karakter!",
            'kecamatan.exists' => "Kecamatan tidak ditemukan!",
            'about.max' => "Tentang Saya maksimal 2000 karakter!",
            'foto.image' => "File harus berupa gambar!",
            'foto.mimes' => "Format foto harus JPG, PNG, atau WebP!",
            'foto.max' => "Ukuran foto maksimal 2 MB!",
        ];
    }
}
