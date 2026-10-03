<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RejectListingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->routeIs('adm.*') && Auth::check();
    }

    public function rules(): array
    {
        return [
            'alasan_penolakan' => 'required|string|min:5|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'alasan_penolakan.required' => "Alasan penolakan wajib diisi agar agen tahu apa yang harus diperbaiki!",
            'alasan_penolakan.min' => "Alasan penolakan minimal 5 karakter!",
            'alasan_penolakan.max' => "Alasan penolakan maksimal 1000 karakter!",
        ];
    }
}
