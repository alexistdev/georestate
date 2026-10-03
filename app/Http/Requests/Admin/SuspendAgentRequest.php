<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SuspendAgentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->routeIs('adm.*') && Auth::check();
    }

    public function rules(): array
    {
        return [
            'alasan_suspend' => 'required|string|min:5|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'alasan_suspend.required' => "Alasan suspend wajib diisi; alasan ini akan dilihat agen saat mencoba login!",
            'alasan_suspend.min' => "Alasan suspend minimal 5 karakter!",
            'alasan_suspend.max' => "Alasan suspend maksimal 500 karakter!",
        ];
    }
}
