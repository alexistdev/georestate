<?php

namespace App\Http\Requests\Admin;

use App\Rules\NamaUnik;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Validasi tambah/ubah master data berbasis nama (kategori & fasilitas).
 */
class NamaMasterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->routeIs('adm.*') && Auth::check();
    }

    protected function prepareForValidation(): void
    {
        // Rapikan spasi berlebih: "  Kolam   Renang " → "Kolam Renang".
        if (is_string($this->name)) {
            $this->merge(['name' => Str::squish($this->name)]);
        }
    }

    public function rules(): array
    {
        $tabel = $this->routeIs('adm.kategori.*') ? 'kategoris' : 'fasilitas';
        $id = $this->route('id');

        return [
            'name' => ['required', 'string', 'max:100', new NamaUnik($tabel, $id ? (int) $id : null)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Nama wajib diisi!",
            'name.max' => "Nama maksimal 100 karakter!",
        ];
    }
}
